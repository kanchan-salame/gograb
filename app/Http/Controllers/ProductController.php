<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveProductFormRequest;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Product/Index',[
            'products' => fn() =>
                QueryBuilder::for(Product::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Product/Save',[
            'productCategories' => fn() =>
                QueryBuilder::for(ProductCategory::class)->get(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveProductFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/product/images');
            } else {
            $categoryImagePath = null;
        }
        $data['image'] = $categoryImagePath;
        Product::create($data);
        return redirect()->route('product.index')->with('flash.banner', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render('Product/Save',[
            'product' => $product,
            'productCategories' => fn() =>
                QueryBuilder::for(ProductCategory::class)->get(),
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveProductFormRequest $request, Product $product)
    {
        $product->name = $request['name'];
        $product->quantity = $request['quantity'];
        $product->price = $request['price'];
        $product->unit = $request['unit'];
        $product->description = $request['description'];
        $product->product_category_id = $request['product_category_id'];
        $product->product_sub_category_id = $request['product_sub_category_id'];
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/product/images');
            } else {
            $categoryImagePath = null;
        }
        $product->image = $categoryImagePath;
        $product->update();
        return redirect()->route('product.index')->with('flash.banner', 'Product Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('flash.banner', 'Product deleted successfully');
    }
}
