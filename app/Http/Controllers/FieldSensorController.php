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
