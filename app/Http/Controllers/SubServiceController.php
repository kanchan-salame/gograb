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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubService $subService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubService $subService)
    {
        //
    }
}
