<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverRequest;
use App\Models\Driver;
use App\Services\Driver\DriverManager;

class DriverController extends Controller
{
    public DriverManager $driverManager;

    public function __construct(DriverManager $driverManager)
    {
        $this->driverManager = $driverManager;
    }

    public function index(DriverRequest $request)
    {
        $drivers = $this->driverManager->search(20);
        return response()->json($drivers);
    }

    public function store(DriverRequest $request) {
        $driver = Driver::create($request->validated());
        return response()->json($driver, 201);
    }

    public function update(DriverRequest $request, $id) {
        $driver = Driver::findOrFail($id);
        $driver->update($request->validated());
        return response()->json($driver);
    }
}
