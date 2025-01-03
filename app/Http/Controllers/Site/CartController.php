<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
use Cookie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private $cookieName = 'shopping_cart';
    private $cookieExpiration = 60 * 24 * 7; // 7 days

    public function index()
    {
        try {
            $cartData = $this->getCartData();
            $cartSummary = $this->calculateCartSummary($cartData);

            return view('ecommerce.cart', [
                'products' => $cartSummary['products'],
                'subtotal' => $cartSummary['subtotal'],
                'discount' => $cartSummary['discount'],
                'total' => $cartSummary['total'],
                'appliedCoupon' => $cartSummary['appliedCoupon'],
                'coupon' => $this->getActiveCoupon()
            ]);
        } catch (\Exception $e) {
            Log::error('Cart index error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load cart. Please try again.');
        }
    }

    private function getCartData()
    {
        return json_decode(request()->cookie($this->cookieName), true) ?? ['items' => [], 'coupon' => null];
    }

    private function calculateCartSummary($cartData)
    {
        $products = [];
        $subtotal = 0;
        $discount = 0;
        $appliedCoupon = null;

        foreach ($cartData['items'] as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $price = $product->is_discount_active ? $product->new_price : $product->original_price;
                $itemTotal = $price * $item['quantity'];
                $subtotal += $itemTotal;

                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image1,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                    'category' => $product->category ? $product->category->name : 'Uncategorized',
                ];
            }
        }

        if (!empty($cartData['coupon'])) {
            $appliedCoupon = $this->validateAndGetCoupon($cartData['coupon']);
            if ($appliedCoupon) {
                $discount = ($subtotal * $appliedCoupon->discount_value) / 100;
            }
        }

        return [
            'products' => $products,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $subtotal - $discount,
            'appliedCoupon' => $appliedCoupon
        ];
    }

    private function getActiveCoupon()
    {
        return Cache::remember('active_coupon', 60, function () {
            return Coupon::where('is_active', true)
                ->orderBy('discount_value', 'desc')
                ->first();
        });
    }

    private function validateAndGetCoupon($code)
    {
        return Cache::remember("coupon_{$code}", 60, function () use ($code) {
            return Coupon::where('code', $code)
                ->where('is_active', true)
                ->first();
        });
    }

    public function add(Request $request)
    {
        try {
            $this->validate($request, [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $cartData = $this->getCartData();
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);

            $itemKey = $this->findItemKey($cartData['items'], $productId);

            if ($itemKey !== false) {
                $cartData['items'][$itemKey]['quantity'] += $quantity;
            } else {
                $cartData['items'][] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ];
            }

            return $this->successResponse('Product added to cart successfully!', $cartData);
        } catch (\Exception $e) {
            Log::error('Add to cart error: ' . $e->getMessage());
            return $this->errorResponse('Unable to add product to cart.');
        }
    }

    public function update(Request $request)
    {
        try {
            $this->validate($request, [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $cartData = $this->getCartData();
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity');

            $itemKey = $this->findItemKey($cartData['items'], $productId);

            if ($itemKey !== false) {
                if ($quantity > 0) {
                    $cartData['items'][$itemKey]['quantity'] = $quantity;
                } else {
                    unset($cartData['items'][$itemKey]);
                    $cartData['items'] = array_values($cartData['items']);
                }
            }

            $summary = $this->calculateCartSummary($cartData);

            return response()->json([
                'success' => true,
                'products' => $summary['products'],
                'subtotal' => $summary['subtotal'],
                'discount' => $summary['discount'],
                'total' => $summary['total'],
            ])->cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);
        } catch (\Exception $e) {
            Log::error('Update cart error: ' . $e->getMessage());
            return $this->errorResponse('Unable to update cart.');
        }
    }

    public function applyCoupon(Request $request)
    {
        try {
            $this->validate($request, [
                'coupon_code' => 'required|string|max:50'
            ]);

            $couponCode = $request->input('coupon_code');
            $cartData = $this->getCartData();

            $coupon = $this->validateAndGetCoupon($couponCode);

            if (!$coupon) {
                return $this->errorResponse('Invalid coupon code', 400);
            }

            $cartData['coupon'] = $couponCode;
            $summary = $this->calculateCartSummary($cartData);

            return response()->json([
                'success' => true,
                'subtotal' => $summary['subtotal'],
                'discount_amount' => $summary['discount'],
                'total' => $summary['total'],
                'message' => 'Coupon applied successfully!'
            ])->cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);
        } catch (\Exception $e) {
            Log::error('Apply coupon error: ' . $e->getMessage());
            return $this->errorResponse('Unable to apply coupon.');
        }
    }

    public function removeCoupon()
    {
        try {
            $cartData = $this->getCartData();
            unset($cartData['coupon']);

            $summary = $this->calculateCartSummary($cartData);

            return response()->json([
                'success' => true,
                'subtotal' => $summary['subtotal'],
                'total' => $summary['total'],
                'message' => 'Coupon removed successfully'
            ])->cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);
        } catch (\Exception $e) {
            Log::error('Remove coupon error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to remove coupon'
            ], 400);
        }
    }

    public function removeItem($productId)
    {
        try {
            $cartData = $this->getCartData();
            $itemKey = $this->findItemKey($cartData['items'], $productId);

            if ($itemKey !== false) {
                unset($cartData['items'][$itemKey]);
                $cartData['items'] = array_values($cartData['items']);
            }

            return $this->successResponse('Item removed successfully', $cartData);
        } catch (\Exception $e) {
            Log::error('Remove item error: ' . $e->getMessage());
            return $this->errorResponse('Unable to remove item.');
        }
    }

    public function clearCart()
    {
        try {
            return $this->successResponse('Cart cleared successfully', ['items' => []]);
        } catch (\Exception $e) {
            Log::error('Clear cart error: ' . $e->getMessage());
            return $this->errorResponse('Unable to clear cart.');
        }
    }

    private function successResponse($message, $cartData)
    {
        return redirect()->back()
            ->cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration)
            ->with('success', $message);
    }

    private function errorResponse($message, $status = 400)
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], $status);
        }

        return redirect()->back()->with('error', $message);
    }

    private function findItemKey($items, $productId)
    {
        foreach ($items as $key => $item) {
            if ($item['product_id'] == $productId) {
                return $key;
            }
        }
        return false;
    }
}
