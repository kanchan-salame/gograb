<?php

namespace App\Http\Controllers;

use App\Models\PackageSize;
use Illuminate\Http\Request;
use App\Http\Requests\SavePackageSizeRequestForm;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;

class PackageSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('PackageSize/Index',[
            'packageSizes' => fn() =>
                QueryBuilder::for(PackageSize::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('PackageSize/Save');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePackageSizeRequestForm $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/packagesize/images');
            $categoryImagePath = str_replace('public/', '', $categoryImagePath);
            } else {
            $categoryImagePath = null;
        }
        $data['image'] = $categoryImagePath;

        PackageSize::create($data);
        return redirect()->route('packageSize.index')->with('flash.banner', 'Package Size added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PackageSize $packageSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageSize $packageSize)
    {
        return Inertia::render('PackageSize/Save',
            array_merge([
                'packageSize' => $packageSize,
            ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavePackageSizeRequestForm $request, PackageSize $packageSize)
    {
        $packageSize->title = $request['title'];
        $packageSize->description = $request['description'];
        $packageSize->price = $request['price'];
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/packagesize/images');
            $categoryImagePath = str_replace('public/', '', $categoryImagePath);
            } else {
            $categoryImagePath = null;
        }
        $packageSize->image = $categoryImagePath;
        $packageSize->update();
        return redirect()->route('packageSize.index')->with('flash.banner', 'Package Size Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageSize $packageSize)
    {
        $packageSize->delete();
        return back()->with('flash.banner', 'Package Size deleted successfully');
    }
}
