<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Models\Field;
use Illuminate\Support\Facades\Validator;

/**
 * Class FieldController
 * @package App\Http\Controllers
 */
class FieldController extends Controller
{

    use ApiResponse;

    /**
     * @OA\Get(
     *      path="/fields",
     *      operationId="getFieldList",
     *      tags={"Fields"},
     *      summary="Get list of fields",
     *      description="Returns list of fields",
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
     * @OA\Post(
     *      path="/fields",
     *      operationId="storeField",
     *      tags={"Fields"},
     *      summary="Store new field",
     *      description="Returns field data",
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
     * @OA\Get(
     *      path="/fields/{id}",
     *      operationId="getFieldById",
     *      tags={"Fields"},
     *      summary="Get field information",
     *      description="Returns field data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Field id",
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
     * @OA\Patch(
     *      path="/fields/{id}",
     *      operationId="updateField",
     *      tags={"Fields"},
     *      summary="Update existing field",
     *      description="Returns updated field data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Field id",
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
     * Update a field
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return $this->error([
                $validator->messages()
            ], '', 401);
        }

        $data = $validator->safe()->only(['name']);

        $field->update($data);

        return $this->success([
            'field' => $field
        ]);
    }

    /**
     * @OA\Delete(
     *      path="/fields/{id}",
     *      operationId="deleteField",
     *      tags={"Fields"},
     *      summary="Delete existing field",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Field id",
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
