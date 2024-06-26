<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveServiceFormRequest;
use App\Models\ServiceCategory;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Service/Index',[
            'services' => fn() =>
                QueryBuilder::for(Service::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Service/Save',[
            'serviceCategories' => fn() =>
                QueryBuilder::for(ServiceCategory::class)->get(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveServiceFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/service/images');
            } else {
            $categoryImagePath = null;
        }
        $data['image'] = $categoryImagePath;
        Service::create($data);
        return redirect()->route('service.index')->with('flash.banner', 'Service added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return Inertia::render('Service/Save',[
            'service' => $service,
            'serviceCategories' => fn() =>
                QueryBuilder::for(ServiceCategory::class)->get(),
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveServiceFormRequest $request, Service $service)
    {
        $service->name = $request['name'];
        $service->service_category_id = $request['service_category_id'];
        $service->service_sub_category_id = $request['service_sub_category_id'];
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/service/images');
            } else {
            $categoryImagePath = null;
        }
        $service->image = $categoryImagePath;
        $service->update();
        return redirect()->route('service.index')->with('flash.banner', 'Service Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('flash.banner', 'Service deleted successfully');
    }
}
