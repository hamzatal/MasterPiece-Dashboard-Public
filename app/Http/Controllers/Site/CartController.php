<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
use Cookie;

class CartController extends Controller
{
    private $cookieName = 'shopping_cart';
    private $cookieExpiration = 60 * 24 * 7;

    public function index()
    {
        $cartData = json_decode(request()->cookie($this->cookieName), true) ?? ['items' => [], 'coupon' => null];

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
            $coupon = Coupon::where('code', $cartData['coupon'])->where('is_active', true)->first();
            if ($coupon) {
                $discount = ($subtotal * $coupon->discount_value) / 100;
                $appliedCoupon = $coupon;
            }
        }

        $total = $subtotal - $discount;
        $coupon = Coupon::where('is_active', true)
            ->orderBy('discount_value', 'desc')
            ->first();

        return view('ecommerce.cart', compact('products', 'subtotal', 'discount', 'total', 'appliedCoupon', 'coupon'));
    }

    public function add(Request $request)
    {
        $cartData = json_decode(request()->cookie($this->cookieName), true) ?? ['items' => []];
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

        return redirect()->back()->cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);
    }
    public function addToCart(Request $request)
    {
        try {
            $cartData = json_decode(request()->cookie('shopping_cart'), true) ?? ['items' => []];
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);

            // Check if the product exists
            $product = Product::find($productId);
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.',
                ], 404);
            }

            // Check if the product is already in the cart
            $itemKey = array_search($productId, array_column($cartData['items'], 'product_id'));

            if ($itemKey !== false) {
                // Update quantity if the product is already in the cart
                $cartData['items'][$itemKey]['quantity'] += $quantity;
            } else {
                // Add new item to the cart
                $cartData['items'][] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ];
            }

            // Save the updated cart data in the cookie
            $cookie = cookie('shopping_cart', json_encode($cartData), 60 * 24 * 7);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully!',
                'cart_count' => array_sum(array_column($cartData['items'], 'quantity')),
            ])->withCookie($cookie);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error adding product to cart: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $cartData = json_decode(request()->cookie($this->cookieName), true) ?? ['items' => []];
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

        $subtotal = 0;
        $discount = 0;
        $products = [];

        foreach ($cartData['items'] as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $price = $product->is_discount_active ? $product->new_price : $product->original_price;
                $itemTotal = $price * $item['quantity'];
                $subtotal += $itemTotal;

                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                ];
            }
        }

        if (!empty($cartData['coupon'])) {
            $coupon = Coupon::where('code', $cartData['coupon'])->where('is_active', true)->first();
            if ($coupon) {
                $discount = ($subtotal * $coupon->discount_value) / 100;
            }
        }

        $total = $subtotal - $discount;

        return response()->json([
            'success' => true,
            'products' => $products,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
        ])->cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $cartData = json_decode(request()->cookie($this->cookieName), true) ?? ['items' => []];

        $coupon = Coupon::where('code', $couponCode)->where('is_active', true)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code',
            ], 400);
        }

        $cartData['coupon'] = $couponCode;

        $subtotal = $this->calculateSubtotal($cartData['items']);

        $discount = ($subtotal * $coupon->discount_value) / 100;

        $total = $subtotal - $discount;

        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'total' => $total,
            'message' => 'Coupon applied successfully!',
        ])->cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);
    }

    private function calculateSubtotal($items)
    {
        $subtotal = 0;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $price = $product->is_discount_active ? $product->new_price : $product->original_price;
                $subtotal += $price * $item['quantity'];
            }
        }

        return $subtotal;
    }

    public function checkout()
    {
        $cartData = session()->get('cart', ['items' => []]);
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

        if (isset($cartData['coupon'])) {
            $coupon = Coupon::where('code', $cartData['coupon'])->first();
            if ($coupon) {
                $discount = ($subtotal * $coupon->discount_value) / 100;
                $appliedCoupon = $coupon;
            }
        }

        $total = $subtotal - $discount;

        $user = auth()->user();

        return view('ecommerce.checkout', compact('products', 'subtotal', 'discount', 'total', 'appliedCoupon', 'user'));
    }

    public function removeCoupon()
    {
        $cartData = json_decode(request()->cookie($this->cookieName), true) ?? ['items' => []];

        if (!empty($cartData['coupon'])) {
            unset($cartData['coupon']);
        }

        return redirect()->back()->cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);
    }

    public function removeItem($productId)
    {
        try {
            $cartData = json_decode(request()->cookie($this->cookieName), true) ?? ['items' => []];
            $itemKey = $this->findItemKey($cartData['items'], $productId);

            if ($itemKey !== false) {
                unset($cartData['items'][$itemKey]);
                $cartData['items'] = array_values($cartData['items']);

                return response()->json([
                    'success' => true,
                    'message' => 'Item removed successfully',
                ])->cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item',
            ], 500);
        }
    }

    public function clearCart()
    {
        try {
            $cookie = cookie($this->cookieName, json_encode(['items' => []]), $this->cookieExpiration);

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
            ])->withCookie($cookie);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart',
            ], 500);
        }
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

    private function calculateDiscount($subtotal, $couponCode)
    {
        $discount = 0;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->where('is_active', true)->first();
            if ($coupon) {
                $discount = ($subtotal * $coupon->discount_value) / 100;
            }
        }

        return $discount;
    }
}
