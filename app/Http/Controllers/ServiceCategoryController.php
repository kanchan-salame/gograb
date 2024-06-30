<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveServiceCategoryFormRequest;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Service/Categories/Index',[
            'serviceCategories' => fn() =>
                QueryBuilder::for(ServiceCategory::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Service/Categories/Save');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveServiceCategoryFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/service/category/images');
            } else {
            $categoryImagePath = null;
        }
        $data['image'] = $categoryImagePath;
        ServiceCategory::create($data);
        return redirect()->route('serviceCategory.index')->with('flash.banner', 'Service Category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        return Inertia::render('Service/Categories/Save',
            array_merge([
                'serviceCategory' => $serviceCategory,
            ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveServiceCategoryFormRequest $request, ServiceCategory $serviceCategory)
    {
        $serviceCategory->name = $request['name'];
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/category/images');
            } else {
            $categoryImagePath = null;
        }
        $serviceCategory->image = $categoryImagePath;
        $serviceCategory->update();
        return redirect()->route('serviceCategory.index')->with('flash.banner', 'Service Category Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        $serviceCategory->delete();
        return back()->with('flash.banner', 'Service Category deleted successfully');
    }
}
