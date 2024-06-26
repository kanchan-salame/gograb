<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\UserResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Filters\ActiveFilter;
use App\Filters\NameFilter;
use App\Models\FoodOrder;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Users/Index',[
            'users' => fn() =>
                QueryBuilder::for(User::class)
                    ->allowedFilters([
                        AllowedFilter::custom('role', new ActiveFilter),
                        AllowedFilter::custom('name', new NameFilter)
                    ])->paginate(5),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function myOrders()
    {
        return Inertia::render('Users/MyOrders',[
            'myOrders' => fn() =>
                QueryBuilder::for(FoodOrder::class)
                ->where('user_id', auth()->user()->id)
                ->with(['restaurantMenuItem'])
                ->with(['restaurantMenu'])
                ->with(['restaurant'])
                ->get(),
            'user_data' => auth()->user(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('flash.banner', 'User deleted successfully');
    }
}
