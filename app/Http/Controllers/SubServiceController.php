<?php

namespace App\Http\Controllers;

use App\Models\SubService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\SaveSubServiceFormRequest;
use App\Models\ServiceCategory;
use App\Models\Service;

class SubServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Service/SubService/Index',[
            'subServices' => fn() =>
                QueryBuilder::for(SubService::class)->paginate(5),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Service/SubService/Save',[
            'serviceCategories' => fn() =>
                QueryBuilder::for(ServiceCategory::class)->get(),
                'services' => fn() =>
                QueryBuilder::for(Service::class)->get(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveSubServiceFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/subService/images');
            } else {
            $categoryImagePath = null;
        }
        $data['image'] = $categoryImagePath;
        SubService::create($data);
        return redirect()->route('subService.index')->with('flash.banner', 'Sub Service added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubService $subService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubService $subService)
    {
        return Inertia::render('Service/SubService/Save',[
            'subService' => $subService,
            'serviceCategories' => fn() =>
                QueryBuilder::for(ServiceCategory::class)->get(),
                'services' => fn() =>
                QueryBuilder::for(Service::class)->get(),
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveSubServiceFormRequest $request, SubService $subService)
    {
        $subService->name = $request['name'];
        $subService->service_category_id = $request['service_category_id'];
        $subService->service_sub_category_id = $request['service_sub_category_id'];
        $subService->service_id = $request['service_id'];
        if ($request->hasFile('image')) {
            $categoryImagePath = $request->file('image')->store('uploads/subService/images');
            } else {
            $categoryImagePath = null;
        }
        $subService->image = $categoryImagePath;
        $subService->update();
        return redirect()->route('subService.index')->with('flash.banner', 'Sub Service Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubService $subService)
    {
        $subService->delete();
        return back()->with('flash.banner', 'Sub Service deleted successfully');
    }
}
