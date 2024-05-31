<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveRestaurantFormRequest;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Restaurant/Index',[
            'restaurants' => fn() =>
                QueryBuilder::for(Restaurant::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Restaurant/Save');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveRestaurantFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $restaurantImagePath = $request->file('image')->store('uploads/restaurant/images');
            $restaurantImagePath = str_replace('public/', '', $restaurantImagePath);
            } else {
            $restaurantImagePath = null;
        }
        $data['image'] = $restaurantImagePath;

        Restaurant::create($data);
        return redirect()->route('restaurant.index')->with('flash.banner', 'Restaurant added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        return Inertia::render('Restaurant/Save',
            array_merge([
                'restaurant' => $restaurant,
            ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveRestaurantFormRequest $request, Restaurant $restaurant)
    {
        $restaurant->name = $request['name'];
        $restaurant->latitude = $request['latitude'];
        $restaurant->longitude = $request['longitude'];
        $restaurant->min_order_price = $request['min_order_price'];
        $restaurant->delivery_fee = $request['delivery_fee'];
        $restaurant->delivery_max_time = $request['delivery_max_time'];
        $restaurant->delivery_min_time = $request['delivery_min_time'];
        if ($request->hasFile('image')) {
            $restaurantImagePath = $request->file('image')->store('uploads/restaurant/images');
            $restaurantImagePath = str_replace('public/', '', $restaurantImagePath);
            } else {
            $restaurantImagePath = null;
        }
        $restaurant->image = $restaurantImagePath;

        $restaurant->update();
        return redirect()->route('restaurant.index')->with('flash.banner', 'Restaurant Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return back()->with('flash.banner', 'Restaurant deleted successfully');
    }
}
