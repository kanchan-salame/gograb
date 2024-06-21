<?php

namespace App\Http\Controllers;

use App\Models\FoodOrder;
use App\Models\Address;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use App\Models\RestaurantMenuItem;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveFoodOrderFormRequest;
use Spatie\QueryBuilder\AllowedFilter;
use App\Filters\ActiveFilter;
use App\Filters\IdFilter;
use App\Models\User;

class FoodOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'driver') {
            return Inertia::render('FoodOrder/Index',[
                'foodOrders' => fn() =>
                    QueryBuilder::for(FoodOrder::class)
                    ->where('driver_id', auth()->user()->id)
                    ->with(['restaurantMenuItem'])
                    ->with(['restaurantMenu'])
                    ->with(['restaurant'])
                    ->paginate(10),
                "drivers" => User::where('role', 'driver')->get(),
                ]);
        }
        return Inertia::render('FoodOrder/Index',[
            'foodOrders' => fn() =>
                QueryBuilder::for(FoodOrder::class)
                ->with(['restaurantMenuItem'])
                ->with(['restaurantMenu'])
                ->with(['restaurant'])
                ->paginate(10),
            "drivers" => User::where('role', 'driver')->get(),
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
    public function store(SaveFoodOrderFormRequest $request)
    {
        $addressData = [
            'address' => $request['address'],
            'city' => $request['city'],
            'state' => $request['state'],
            'country' => $request['country'],
            'phone' => $request['phone'],
            'email' => $request['email'],
        ];
        $addressId = Address::create($addressData)->id;

        foreach ($request['cart_items'] as $key => $item) {
            $data = [
                'user_id' => auth()->user()->id,
                'restaurant_id' => $item['restaurant_id'],
                'restaurant_menu_id' => $item['restaurant_menu_id'],
                'restaurant_menu_item_id' => $item['restaurant_menu_item_id'],
                'status' => 'processing',
                'status_reason' => 'Just placed order',
                'quantity' => $item['quantity'],
                'price' => $item['restaurant_menu_item']['price'],
                'delivery_charge' => null,
                'delivery_type' => null,
                'payment_type' => null,
                'payment_status' => null,
                'tax' => null,
                'instructions' => null,
                'discount' => null,
                'sub_total' => null,
                'total' => $item['quantity'] * $item['restaurant_menu_item']['price'],
            ];

            $foodOrderId = FoodOrder::create($data)->id;

            $orderDetailData = [
                'food_order_id' => $foodOrderId,
                'address_id' => $addressId,
            ];

            OrderDetail::create($orderDetailData);
        }
        return redirect()->route('foodOrder.index')->with('flash.banner', 'Your Food order placed!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FoodOrder $foodOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodOrder $foodOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function assignToDriver(Request $request, FoodOrder $foodOrder)
    {
        $foodOrder->driver_id = $request['driver'];
        $foodOrder->status = 'dispatched';
        $foodOrder->update();
        return redirect()->route('foodOrder.index')->with('flash.banner', 'Order Assign To Driver!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function changeStatus(Request $request, FoodOrder $foodOrder)
    {
        $foodOrder->driver_id = $request['driver'];
        $foodOrder->status = 'dispatched';
        $foodOrder->update();
        return redirect()->route('foodOrder.index')->with('flash.banner', 'Order Assign To Driver!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodOrder $foodOrder)
    {
        //
    }
}
