<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use App\Models\RestaurantMenuItem;
use Spatie\QueryBuilder\QueryBuilder;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $cart = Cart::find(1);
        // dd($cart);
        return Inertia::render('Cart/Index',[
            'carts' => fn() =>
                QueryBuilder::for(Cart::class)->with(['restaurantMenuItem'])->get(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request['formtype'] == 'restaurantMenuItem') {
            $data = [
                'restaurant_menu_item_id' => $request['restaurant_menu_item_id'],
                'user_id' => Auth::user()->id,
                'quantity' => 1,
            ];
        } else {
            $data = [
                'package_size_id' => $request['package_size_id'],
                'user_id' => Auth::user()->id,
                'quantity' => 1,
            ];
        }

        Cart::create($data);
        return redirect()->route('cart.index')->with('flash.banner', 'Item added to cart');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back()->with('flash.banner', 'Item deleted from cart');
    }
}
