<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Models\Sensor;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
    use ApiResponse;

    /**
     * Return all sensors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $sensors = Sensor::all();

        return $this->success([
            'sensors' => $sensors
        ]);
    }

    /**
     * Store a new sensor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'lat' => ['required'],
            'lng' => ['required'],
            'status' => ['required'],
            'field_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->error([
                $validator->messages()
            ], '', 401);
        }

        $data = $validator->safe()->only(['name', 'lat', 'lng', 'status', 'field_id']);

        $sensor = Sensor::create($data);

        return $this->success([
            'sensor' => $sensor
        ]);
    }

    /**
     * Return a single sensor
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $sensor = Sensor::findOrFail($id);

        return $this->success([
            'sensor' => $sensor
        ]);

    }

    /**
     * Update a sensor
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $sensor = Sensor::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'lat' => [],
            'lng' => [],
            'status' => [],
            'field_id' => [],
        ]);

        if ($validator->fails()) {
            return $this->error([
                $validator->messages()
            ], '', 401);
        }

        $data = $validator->safe()->only(['name', 'lat', 'lng', 'status', 'field_id']);

        $sensor->update($data);

        return $this->success([
            'sensor' => $sensor
        ]);
    }

    /**
     * Destroy a sensor
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $sensor = Sensor::findOrFail($id);

        $sensor->delete();

        return $this->success('', 'Record deleted.');

    }

}
