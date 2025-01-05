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

                $variantKey = $item['variant_key'] ?? $this->generateItemKey(
                    $product->id,
                    $item['color'] ?? null,
                    $item['size'] ?? null
                );

                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image1,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                    'category' => $product->category ? $product->category->name : 'Uncategorized',
                    'color' => $item['color'] ?? null,
                    'size' => $item['size'] ?? null,
                    'variant_key' => $variantKey
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

        return view('ecommerce.cart', compact('products', 'subtotal', 'discount', 'total', 'appliedCoupon', 'coupon', 'cartData'));
    }

    private function generateItemKey($productId, $color = null, $size = null)
    {
        $specs = [
            'product_id' => $productId,
            'color' => $color,
            'size' => $size
        ];

        return implode('_', array_filter($specs));
    }

    private function findItemKey($items, $productId, $color = null, $size = null)
    {
        foreach ($items as $key => $item) {
            $itemProductId = $item['product_id'];
            $itemColor = $item['color'] ?? null;
            $itemSize = $item['size'] ?? null;

            // Check if this is the item we're looking for
            $productMatches = (string)$itemProductId === (string)$productId;
            $colorMatches = $itemColor === $color || ($itemColor === null && $color === null);
            $sizeMatches = $itemSize === $size || ($itemSize === null && $size === null);

            if ($productMatches && $colorMatches && $sizeMatches) {
                return $key;
            }
        }

        return false;
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
            $cartData = json_decode(request()->cookie($this->cookieName), true) ?? ['items' => [], 'coupon' => null];

            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);
            $color = $request->input('color');
            $size = $request->input('size');

            $product = Product::find($productId);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            // Find item based on product ID, color, and size
            $itemKey = $this->findItemKey($cartData['items'], $productId, $color, $size);

            if ($itemKey !== false) {
                // Update quantity if exact same variant exists
                $cartData['items'][$itemKey]['quantity'] += $quantity;
            } else {
                // Add as new item if variant doesn't exist
                $cartData['items'][] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'color' => $color,
                    'size' => $size,
                    'variant_key' => $this->generateItemKey($productId, $color, $size)
                ];
            }

            $cookie = cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);

            return redirect()->back()
                ->with('success', 'Product added to cart successfully!')
                ->withCookie($cookie);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing your request.');
        }
    }

    public function update(Request $request)
    {
        try {
            $cartData = json_decode(request()->cookie($this->cookieName), true) ?? ['items' => []];

            $productId = $request->input('product_id');
            $quantity = max(1, intval($request->input('quantity'))); // Ensure quantity is at least 1
            $color = $request->input('color');
            $size = $request->input('size');

            $itemKey = $this->findItemKey($cartData['items'], $productId, $color, $size);

            if ($itemKey !== false) {
                // Update quantity for the specific variant
                $cartData['items'][$itemKey]['quantity'] = $quantity;

                // Recalculate totals
                $subtotal = $this->calculateSubtotal($cartData['items']);
                $discount = $this->calculateDiscount($subtotal, $cartData['coupon'] ?? null);
                $total = $subtotal - $discount;

                // Prepare updated product information
                $product = Product::find($productId);
                $price = $product->is_discount_active ? $product->new_price : $product->original_price;
                $itemTotal = $price * $quantity;

                $updatedProduct = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                    'color' => $color,
                    'size' => $size
                ];

                $cookie = cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);

                return response()->json([
                    'success' => true,
                    'product' => $updatedProduct,
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'total' => $total
                ])->cookie($cookie);
            }

            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart: ' . $e->getMessage()
            ], 500);
        }
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

    public function removeCoupon(Request $request)
    {
        try {
            $cartData = json_decode(request()->cookie($this->cookieName), true) ?? ['items' => []];

            // Remove coupon from cart data
            if (isset($cartData['coupon'])) {
                unset($cartData['coupon']);
            }

            // Recalculate totals without coupon
            $subtotal = $this->calculateSubtotal($cartData['items']);
            $total = $subtotal; // No discount since coupon is removed

            $cookie = cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);

            return response()->json([
                'success' => true,
                'message' => 'Coupon removed successfully',
                'subtotal' => $subtotal,
                'discount' => 0,
                'total' => $total
            ])->cookie($cookie);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove coupon: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeItem($productId)
    {
        try {
            $cartData = json_decode(request()->cookie($this->cookieName), true) ?? ['items' => []];

            // Get color and size from the request
            $color = request()->input('color') ?? null;
            $size = request()->input('size') ?? null;

            // Find the specific variant to remove
            $itemKey = $this->findItemKey($cartData['items'], $productId, $color, $size);

            if ($itemKey !== false) {
                // Remove the specific item
                unset($cartData['items'][$itemKey]);
                $cartData['items'] = array_values($cartData['items']); // Reindex array

                // Recalculate totals
                $subtotal = $this->calculateSubtotal($cartData['items']);
                $discount = $this->calculateDiscount($subtotal, $cartData['coupon'] ?? null);
                $total = $subtotal - $discount;

                return response()->json([
                    'success' => true,
                    'message' => 'Item removed successfully',
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'total' => $total
                ])->cookie($this->cookieName, json_encode($cartData), $this->cookieExpiration);
            }

            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item: ' . $e->getMessage()
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

    private function calculateDiscount($subtotal, $couponCode)
    {
        $discount = 0;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)
                ->where('is_active', true)
                ->first();

            if ($coupon) {
                $discount = ($subtotal * $coupon->discount_value) / 100;
            }
        }

        return $discount;
    }
}
