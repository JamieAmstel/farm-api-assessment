<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Models\Field;

/**
 * Class FieldSensorController
 * @package App\Http\Controllers
 */
class FieldSensorController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *      path="/fields/{id}/sensors",
     *      operationId="getFieldList",
     *      tags={"Fields"},
     *      summary="Get field information and its related sensors",
     *      description="Returns field data and its related sensors data",
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
     * Return all sensors by field
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $field = Field::with('sensors')->findOrFail($id);

        return $this->success([
            'field' => $field
        ]);
    }
}
