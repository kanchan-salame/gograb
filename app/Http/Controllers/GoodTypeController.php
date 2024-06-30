<?php

namespace App\Http\Controllers;

use App\Models\GoodType;
use Illuminate\Http\Request;
use App\Http\Requests\SaveGoodTypeFormRequest;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;

class GoodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('GoodType/Index',[
            'goodTypes' => fn() =>
                QueryBuilder::for(GoodType::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('GoodType/Save');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveGoodTypeFormRequest $request)
    {
        GoodType::create($request->all());
        return redirect()->route('goodType.index')->with('flash.banner', 'Good Type added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(GoodType $goodType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoodType $goodType)
    {
        return Inertia::render('GoodType/Save',
            array_merge([
                'goodType' => $goodType,
            ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveGoodTypeFormRequest $request, GoodType $goodType)
    {
        $goodType->name = $request['name'];
        $goodType->update();
        return redirect()->route('goodType.index')->with('flash.banner', 'Good Type Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoodType $goodType)
    {
        $goodType->delete();
        return back()->with('flash.banner', 'Good Type deleted successfully');
    }
}
