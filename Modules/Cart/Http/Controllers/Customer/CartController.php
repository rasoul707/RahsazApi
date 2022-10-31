<?php

namespace Modules\Cart\Http\Controllers\Customer;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Cart\Entities\Cart;
use Modules\Cart\Http\Requests\CartAddProductRequest;
use Modules\Cart\Http\Requests\CartDeleteProductRequest;
use Modules\Order\Entities\Order;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;

class CartController extends Controller
{
    /**
     * @OA\GET(
     *     path="/customer/cart",
     *     tags={"Customer/Cart"},
     *     summary="Customer Cart - Index",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function index()
    {
        $user = User::query()->find(\auth()->user()->id);
        User::firstOrCreateCart($user);

        $cart = Cart::query()
            ->with(['items'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        return response()->json($cart);
    }

    /**
     * @OA\POST(
     *     path="/customer/cart/add-product",
     *     tags={"Customer/Cart"},
     *     summary="Customer Cart - Add Product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CartAddProductBody")
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function addProduct(CartAddProductRequest $request)
    {
        $user = Auth::user();
        User::firstOrCreateCart($user);
        $cart = Cart::where('user_id', $user->id)->firstOrFail();
        $product = Product::where('id', $request->product_id)->firstOrFail();
        $count = $request->count ?? 1;
        Cart::addProduct($cart, $product, $count);
        return response()
            ->json(null, 204);
    }


    /**
     * @OA\POST(
     *     path="/customer/cart/delete-product",
     *     tags={"Customer/Cart"},
     *     summary="Customer Cart - delete Product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CartDeleteProductBody")
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function deleteProduct(CartDeleteProductRequest $request)
    {
        $user = Auth::user();
        User::firstOrCreateCart($user);
        $cart = Cart::where('user_id', $user->id)->firstOrFail();
        $product = Product::where('id', $request->product_id)->firstOrFail();
        Cart::deleteProduct($cart,$product);
        return response()
            ->json(null, 204);
    }

    /**
     * @OA\PUT(
     *     path="/customer/cart/empty",
     *     tags={"Customer/Cart"},
     *     summary="Customer Cart - empty cart",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function emptyCart()
    {
        $user = Auth::user();
        User::firstOrCreateCart($user);
        $cart = Cart::where('user_id', $user->id)->firstOrFail();
        Cart::emptyCart($cart);
        return response()
            ->json(null, 204);
    }

    /**
     * @OA\POST(
     *     path="/customer/cart/finalize",
     *     tags={"Customer/Cart"},
     *     summary="Finalize Cart - نهایی کردن سبد خرید",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function finalize()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->firstOrFail();

        $order = DB::transaction(function () use ($cart){
            $order = $cart->finalize();
            return $order;
        });

        return response()
            ->json($order);
    }
}
