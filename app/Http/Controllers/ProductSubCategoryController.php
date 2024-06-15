<?php

namespace App\Http\Controllers;

use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveProductSubCategoryFormRequest;
use App\Models\ProductCategory;

class ProductSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Product/SubCategories/Index',[
            'productSubCategories' => fn() =>
                QueryBuilder::for(ProductSubCategory::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Product/SubCategories/Save',[
            'productCategories' => fn() =>
                QueryBuilder::for(ProductCategory::class)->get(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveProductSubCategoryFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/product/sub-category/images');
            } else {
            $categoryImagePath = null;
        }
        $data['image'] = $categoryImagePath;
        ProductSubCategory::create($data);
        return redirect()->route('productSubCategory.index')->with('flash.banner', 'Product Sub Category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSubCategory $productSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSubCategory $productSubCategory)
    {
        return Inertia::render('Product/SubCategories/Save',
            array_merge([
                'productSubCategory' => $productSubCategory,
                'productCategories' => fn() => QueryBuilder::for(ProductCategory::class)->get(),
            ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSubCategory $productSubCategory)
    {
        $productSubCategory->name = $request['name'];
        $productSubCategory->product_category_id = $request['product_category_id'];
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/product/sub-category/images');
            } else {
            $categoryImagePath = null;
        }
        $productSubCategory->image = $categoryImagePath;
        $productSubCategory->update();
        return redirect()->route('productSubCategory.index')->with('flash.banner', 'Product Sub Category Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSubCategory $productSubCategory)
    {
        $productSubCategory->delete();
        return back()->with('flash.banner', 'Product Sub Category deleted successfully');
    }
}
