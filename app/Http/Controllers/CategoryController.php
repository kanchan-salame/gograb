<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveCategoryFormRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Categories/Index',[
            'categories' => fn() =>
                QueryBuilder::for(Category::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Categories/Save');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveCategoryFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('public/uploads/category/images');
            $categoryImagePath = str_replace('public/', '', $categoryImagePath);
            } else {
            $categoryImagePath = null;
        }
        $data['image'] = $categoryImagePath;

        if ($request->hasFile('icon')) {
            $categoryIconPath = $request->file('icon')->store('public/uploads/category/icons');
            $categoryIconPath = str_replace('public/', '', $categoryIconPath);
            } else {
            $categoryIconPath = null;
        }
        $data['icon'] = $categoryIconPath;
        Category::create($data);
        return redirect()->route('category.index')->with('flash.banner', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('flash.banner', 'Category deleted successfully');
    }
}
