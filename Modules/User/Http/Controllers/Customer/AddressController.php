<?php

namespace Modules\User\Http\Controllers\Customer;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Address;
use Modules\User\Entities\Builder\AddressBuilder;

class AddressController extends Controller
{
    /**
     * @OA\GET (
     *     path="/customer/addresses/index",
     *     tags={"Customer/Addresses"},
     *     summary="مشتری - مدیریت آدرس",
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
    public function index()
    {
        $builder = (new AddressBuilder())
            ->userId(auth()->user()->id)
            ->order('id', 'asc');

        return response()
            ->json($builder->getAll());
    }

    /**
     * @OA\PUT (
     *     path="/customer/addresses/update/{id}",
     *     tags={"Customer/Addresses"},
     *     summary="مشتری - مدیریت آدرس",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer_UpdateAddress")
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
    public function update(Request $request, $id)
    {
        Address::query()
            ->where('id',$id)
            ->where('user_id', auth()->user()->id)
            ->update([
                'user_id' => auth()->user()->id,
                'location' => $request->location,
                'country' => $request->country,
                'city' => $request->city,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
            ]);

        return response()
            ->json(null, 204);
    }

    /**
     * @OA\POST (
     *     path="/customer/addresses/store",
     *     tags={"Customer/Addresses"},
     *     summary="مشتری - مدیریت آدرس",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer_UpdateAddress")
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
    public function store(Request $request)
    {
        Address::query()
            ->create([
                'user_id' => auth()->user()->id,
                'location' => $request->location,
                'country' => $request->country,
                'city' => $request->city,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
            ]);

        return response()
            ->json(null, 204);
    }
}
