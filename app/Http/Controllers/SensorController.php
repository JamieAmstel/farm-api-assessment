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
     * @OA\Get(
     *      path="/sensors",
     *      operationId="getSensorList",
     *      tags={"Sensors"},
     *      summary="Get list of sensors",
     *      description="Returns list of sensors",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     *     )
     */

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
     * @OA\Post(
     *      path="/sensors",
     *      operationId="storeSensor",
     *      tags={"Sensors"},
     *      summary="Store new sensor",
     *      description="Returns sensor data",
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */

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
     * @OA\Get(
     *      path="/sensors/{id}",
     *      operationId="getSensorById",
     *      tags={"Sensors"},
     *      summary="Get sensor information",
     *      description="Returns sensor data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Sensor id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

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
     * @OA\Patch(
     *      path="/sensors/{id}",
     *      operationId="updateSensor",
     *      tags={"Sensors"},
     *      summary="Update existing sensor",
     *      description="Returns updated sensor data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Sensor id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

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
     * @OA\Delete(
     *      path="/sensors/{id}",
     *      operationId="deleteSensor",
     *      tags={"Sensors"},
     *      summary="Delete existing sensor",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Sensor id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

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
