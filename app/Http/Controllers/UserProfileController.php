<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

/**
 * Class UserProfileController
 * @package App\Http\Controllers
 */
class UserProfileController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *      path="/profile",
     *      operationId="getProfile",
     *      tags={"Profile"},
     *      summary="Get profile",
     *      description="Returns profile data",
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
     * Return authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->success([
            'user' => Auth::user()
        ]);
    }

    /**
     * @OA\Patch(
     *      path="/profile",
     *      operationId="updateProfile",
     *      tags={"Profile"},
     *      summary="Update authenticated user",
     *      description="Returns authenticated user data",
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
     * Update authenticated user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'unique:users,email'],
            'password' => ['string', Password::min(8)->mixedCase()->symbols(), 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->error([
                $validator->messages()
            ], '', 401);
        }

        $data = $validator->safe()->only(['name', 'email', 'password']);

        Auth::user()->update($data);

        return $this->success([
            'user' => Auth::user()
        ]);
    }
}
