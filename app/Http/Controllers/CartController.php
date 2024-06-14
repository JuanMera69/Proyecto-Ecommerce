<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        $totalQuantity = 0;

        $totalQuantity += $cartItems->sum('quantity');

        $totalPrice = $cartItems->sum(function ($cartItem) {

            $product = optional($cartItem->product);
            return $product->price * $cartItem->quantity;

        });
        return view('cart.index', compact('cartItems', 'totalQuantity', 'totalPrice'));
    }

    public function add(Request $request, Product $product)

    {

        $cartItem = CartItem::firstOrCreate(

            ['user_id' => Auth::id(), 'product_id' => $product->id],

            ['quantity' => 0]
        );

        if (($cartItem->quantity + 1) > $product->stock) {
            return redirect()->route('cart.index')->with('error', 'No hay mas unidades disponibles en stock.');
        }

        $cartItem->quantity += 1;

        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Producto añadido al carrito');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->user_id == Auth::id()) {
            $cartItem->delete();
            return response()->json(['success' => 'Producto eliminado del carrito'], 200);
        }
        return response()->json(['error' => 'No puedes eliminar este producto del carrito'], 403);
    }

    public function update(Request $request, CartItem $cartItem)
    {

        if ($cartItem->user_id == Auth::id()) {
            if ($request->quantity > $cartItem->product->stock) {
                return response()->json(['error' => 'La cantidad solicitada excede el stock disponible.'], 400);
            }

            $cartItem->quantity = $request->quantity;

            $cartItem->save();

            return response()->json(['success' => 'Cantidad actualizada', 'cartItem' => $cartItem], 200);
        }
        return response()->json(['error' => 'No puedes actualizar este producto del carrito'], 403);
    }
}