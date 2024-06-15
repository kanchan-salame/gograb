<?php

namespace App\Http\Controllers;

use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveServiceSubCategoryFormRequest;
use App\Models\ServiceCategory;

class ServiceSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Service/SubCategories/Index',[
            'serviceSubCategories' => fn() =>
                QueryBuilder::for(ServiceSubCategory::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Service/SubCategories/Save',[
            'serviceCategories' => fn() =>
                QueryBuilder::for(ServiceCategory::class)->get(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveServiceSubCategoryFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/service/sub-category/images');
            } else {
            $categoryImagePath = null;
        }
        $data['image'] = $categoryImagePath;
        ServiceSubCategory::create($data);
        return redirect()->route('serviceSubCategory.index')->with('flash.banner', 'Service Category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceSubCategory $serviceSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceSubCategory $serviceSubCategory)
    {
        return Inertia::render('Service/SubCategories/Save',
            array_merge([
                'serviceSubCategory' => $serviceSubCategory,
                'serviceCategories' => fn() => QueryBuilder::for(ServiceCategory::class)->get(),
            ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveServiceSubCategoryFormRequest $request, ServiceSubCategory $serviceSubCategory)
    {
        $serviceSubCategory->name = $request['name'];
        $serviceSubCategory->service_category_id = $request['service_category_id'];
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/sub-category/images');
            } else {
            $categoryImagePath = null;
        }
        $serviceSubCategory->image = $categoryImagePath;
        $serviceSubCategory->update();
        return redirect()->route('serviceSubCategory.index')->with('flash.banner', 'Service Category Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceSubCategory $serviceSubCategory)
    {
        $serviceSubCategory->delete();
        return back()->with('flash.banner', 'Service Sub Category deleted successfully');
    }
}
