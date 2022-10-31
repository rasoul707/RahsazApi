<?php

namespace Modules\User\Http\Controllers\Customer;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Library\Entities\Image;
use Modules\User\Entities\User;
use Illuminate\Validation\ValidationException;
use Modules\User\Http\Requests\CustomerUpdateProfileRequest;

class ProfileController extends Controller
{
    /**
     * @OA\GET (
     *     path="/customer/profile/show",
     *     tags={"Customer/Profile"},
     *     summary="مشتری - مدیریت پروفایل",
     *     description="",
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function show()
    {
        $user = auth()->user();
        return response()
            ->json($user);
    }

    /**
     * @OA\PUT (
     *     path="/customer/profile/update",
     *     tags={"Customer/Profile"},
     *     summary="مشتری - مدیریت پروفایل",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer_UpdateProfile")
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function updateProfile(CustomerUpdateProfileRequest $request)
    {
        $user = User::query()
            ->findOrFail(auth()->user()->id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        //$user->phone_number = $request->phone_number;
        //$user->email = $request->email;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->legal_info_melli_code = $request->legal_info_melli_code;
        $user->legal_info_economical_code = $request->legal_info_economical_code;
        $user->legal_info_registration_number = $request->legal_info_registration_number;
        $user->legal_info_company_name = $request->legal_info_company_name;
        $user->legal_info_state = $request->legal_info_state;
        $user->legal_info_city = $request->legal_info_city;
        $user->legal_info_address = $request->legal_info_address;
        $user->refund_info_bank_name = $request->refund_info_bank_name;
        $user->refund_info_account_holder_name = $request->refund_info_account_holder_name;
        $user->refund_info_cart_number = $request->refund_info_cart_number;
        $user->refund_info_account_number = $request->refund_info_account_number;
        $user->refund_info_sheba_number = $request->refund_info_sheba_number;
        $user->save();
        return response()
            ->json(null, 204);
    }

    /**
     * @OA\PUT (
     *     path="/customer/profile/update-password",
     *     tags={"Customer/Profile"},
     *     summary="مشتری - مدیریت پروفایل",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer_UpdatePassword")
     *     ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *     security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        if(!Hash::check($request->old_password, $user->password)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
            'old_password' => ['رمز عبور فعلی اشتباه است!'],
        ]);
            throw $error;
        }
        $user->password = bcrypt($request->new_password);
        $user->save();
        return response()
            ->json(null, 204);
    }



    /**
     * @OA\POST(
     *     path="/customer/upload-image",
     *     tags={"Customer/UploadImage"},
     *      summary="Customer upload image",
     *      description="",
     *     @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               required={"image"},
     *               @OA\Property(
     *                  property="image",
     *                  description="image file",
     *                  type="file",
     *               ),
     *           ),
     *       )
     *   ),
     *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
     *     @OA\Response(response=204, description="Successful"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
     *    security={
     *         {
     *             "bearerAuth": {}
     *         }
     *     },
     * )
     */

    public function uploadImage(Request $request)
    {
        $image = $request->file('image');
        Validator::make(['image' => $image], [
            'image' => ['required','mimes:webm,jpg,jpeg,bmp,png'],
        ])->validate();
        $fileName = time() . ' '. $image->getClientOriginalName();
        Storage::disk('local')->putFileAs(
            'public/images',
            $image,
            $fileName
        );
        $imageModel = Image::query()
            ->create([
                'path' => $fileName,
                'title' => $request->title,
                'alt' => $request->alt,
            ]);
        return response()->json($imageModel);
    }
}
