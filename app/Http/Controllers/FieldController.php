<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Models\Field;
use Illuminate\Support\Facades\Validator;

class FieldController extends Controller
{
    use ApiResponse;

    /**
     * Return all fields
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $fields = Field::all();

        return $this->success([
            'fields' => $fields
        ]);
    }

    /**
     * Store a new field
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return $this->error([
                $validator->messages()
            ], '', 401);
        }

        $data = $validator->safe()->only(['name']);

        $field = Field::create($data);

        return $this->success([
            'field' => $field
        ]);
    }

    /**
     * Return a single field
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $field = Field::findOrFail($id);

        return $this->success([
            'field' => $field
        ]);

    }

    /**
     * Update a field
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return $this->error([
                $validator->messages()
            ], '', 401);
        }

        $data = $validator->safe()->only(['name']);

        $field = Field::find($id)->update($data);

        return $this->success([
            'field' => $field
        ]);
    }

    /**
     * Destroy a field
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $field = Field::findOrFail($id);

        $field->delete();

        return $this->success('', 'Record deleted.');

    }

}
