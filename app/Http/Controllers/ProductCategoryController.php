<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveProductCategoryFormRequest;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Product/Categories/Index',[
            'productCategories' => fn() =>
                QueryBuilder::for(ProductCategory::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Product/Categories/Save');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveProductCategoryFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/product/category/images');
            } else {
            $categoryImagePath = null;
        }
        $data['image'] = $categoryImagePath;
        ProductCategory::create($data);
        return redirect()->route('productCategory.index')->with('flash.banner', 'Product Category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        return Inertia::render('Product/Categories/Save',
            array_merge([
                'productCategory' => $productCategory,
            ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveProductCategoryFormRequest $request, ProductCategory $productCategory)
    {
        $productCategory->name = $request['name'];
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/product/category/images');
            } else {
            $categoryImagePath = null;
        }
        $productCategory->image = $categoryImagePath;
        $productCategory->update();
        return redirect()->route('productCategory.index')->with('flash.banner', 'Product Category Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return back()->with('flash.banner', 'Product Category deleted successfully');
    }
}
