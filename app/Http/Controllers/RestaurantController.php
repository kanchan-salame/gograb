<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveRestaurantFormRequest;
use App\Models\Category;
use App\Models\RestaurantCategories;
use App\Models\RestaurantTiming;
use App\Http\Requests\SaveRestaurantMenuFormRequest;
use App\Models\RestaurantMenu;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Restaurant/Index',[
            'restaurants' => fn() =>
                QueryBuilder::for(Restaurant::class)->with(['user'])->paginate(5),
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
        $data['user_id'] = Auth::user()->id;

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
        $restaurant->user_id = Auth::user()->id;
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

    /**
     * select categories for restaurant.
     */
    public function selectCategories(Restaurant $restaurant)
    {
        return Inertia::render('Restaurant/Category',
            array_merge([
                'restaurant' => $restaurant,
                'categories' => Category::all(),
                'restaurantCategories' => $restaurant->restaurantCategories,
            ]));
    }

    /**
     * set timing of restaurant.
     */
    public function setTiming(Restaurant $restaurant)
    {
        return Inertia::render('Restaurant/Timing',
            array_merge([
                'restaurant' => $restaurant,
                'categories' => Category::all(),
            ]));
    }

    /**
     * set menus of restaurant.
     */
    public function setMenus(Restaurant $restaurant)
    {
        return Inertia::render('Restaurant/Menu/Index',
            array_merge([
                'restaurant' => $restaurant,
                'menus' => RestaurantMenu::where('restaurant_id', $restaurant->id)->get(),
            ]));
    }

    /**
     * set menus of restaurant.
     */
    public function createMenu(Restaurant $restaurant)
    {
        return Inertia::render('Restaurant/Menu/Save',
        array_merge([
            'restaurant' => $restaurant,
            'menu' =>'',
        ]));
    }

    /**
     * set menus of restaurant.
     */
    public function editMenu(Restaurant $restaurant, RestaurantMenu $restaurantMenu)
    {
        return Inertia::render('Restaurant/Menu/Save',
        array_merge([
            'restaurant' => $restaurant,
            'menu' => $restaurantMenu,
        ]));
    }

    /**
     * save menus of restaurant.
     */
    public function saveMenu(SaveRestaurantMenuFormRequest $request, Restaurant $restaurant)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $restaurantMenuImagePath = $request->file('image')->store('uploads/restaurant/menu/images');
            $restaurantMenuImagePath = str_replace('public/', '', $restaurantMenuImagePath);
            } else {
            $restaurantMenuImagePath = null;
        }
        $data['image'] = $restaurantMenuImagePath;
        $data['restaurant_id'] = $restaurant->id;

        RestaurantMenu::create($data);
        return redirect()->route('restaurant.menus', $restaurant->id)->with('flash.banner', 'Restaurant Menu added successfully');
    }

    public function updateMenu(SaveRestaurantMenuFormRequest $request, Restaurant $restaurant, RestaurantMenu $restaurantMenu)
    {
        // $data = $request->all();
        $restaurantMenu->name = $request['name'];
        $restaurantMenu->description = $request['description'];

        if ($request->hasFile('image')) {
            $restaurantMenuImagePath = $request->file('image')->store('uploads/restaurant/menu/images');
            $restaurantMenuImagePath = str_replace('public/', '', $restaurantMenuImagePath);
            } else {
            $restaurantMenuImagePath = null;
        }
        $restaurantMenu->image = $restaurantMenuImagePath;
        $restaurantMenu->restaurant_id = $restaurant->id;

        $restaurantMenu->update();
        return redirect()->route('restaurant.menus', $restaurant->id)->with('flash.banner', 'Restaurant Menu added successfully');
    }

    public function destroyMenu(Restaurant $restaurant, RestaurantMenu $restaurantMenu)
    {
        $restaurantMenu->delete();
        return redirect()->route('restaurant.menus', $restaurant->id)->with('flash.banner', 'Restaurant Menu deleted successfully');
    }




    /**
     * add/update categories for restaurant.
     */
    public function updateCategories(Request $request, Restaurant $restaurant)
    {
        if ($restaurant->restaurantCategories()->count() > 0) {
            foreach ($restaurant->restaurantCategories as $key => $restaurantCategory) {
                $restaurantCategory->delete();
            }
        }
        foreach ($request->categories as $key => $value) {
            $data['restaurant_id'] = $restaurant->id;
            $data['category_id'] = $value;
            RestaurantCategories::create($data);
        }
        return redirect()->route('restaurant.index')->with('flash.banner', 'Restaurant categories updated successfully');
    }

    /**
     * add/update categories for restaurant.
     */
    public function updateTiming(Request $request, Restaurant $restaurant)
    {
        // dd($request->all());
        if ($restaurant->restaurantTimings()->count() > 0) {
            foreach ($restaurant->restaurantTimings as $key => $restaurantTiming) {
                $restaurantTiming->delete();
            }
        }
        foreach ($request->days as $key => $value) {
            // dd($request->opening_times[$key]);
            if (!empty($request->opening_times[$key])) {
                $data['restaurant_id'] = $restaurant->id;
                $data['day'] = $value;
                $data['opening_time'] = implode(",", $request->opening_times[$key]);
                $data['closing_time'] = implode(",", $request->closing_times[$key]);
                RestaurantTiming::create($data);
            }
        }
        return redirect()->route('restaurant.index')->with('flash.banner', 'Restaurant timing updated successfully');
    }
}
