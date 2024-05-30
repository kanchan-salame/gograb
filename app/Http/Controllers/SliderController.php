<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveSliderFormRequest;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Slider/Index',[
            'sliders' => fn() =>
                QueryBuilder::for(Slider::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Slider/Save');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveSliderFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $sliderPicturePath = $request->file('image')->store('public/uploads/slider');
            $sliderPicturePath = str_replace('public/', '', $sliderPicturePath);
            } else {
            $sliderPicturePath = null;
        }
        $data['image'] = $sliderPicturePath;
        Slider::create($data);
        return redirect()->route('sliders.index')->with('flash.banner', 'Slider added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return back()->with('flash.banner', 'Slider deleted successfully');
    }
}
