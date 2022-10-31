<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Http\Resources\CustomerLabelSearchResource;
use App\Http\Resources\UserPackageLabelSearchResource;
use App\Models\TimeHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\Address;
use Modules\User\Entities\Builder\UserBuilder;
use Modules\User\Entities\Builder\UserPackageBuilder;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\StoreCustomerRequest;
use Modules\User\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $builder = (new UserBuilder())
            ->search($request->search, ['first_name', 'last_name', 'package', 'email', 'type', 'username', 'phone_number', 'role', 'address', 'created_at'])
            ->role($request->role)
            ->package($request->package)
            ->order($request->order_by, $request->order_type)
            ->type(User::TYPES['مشتری'])
            ->offset($request->offset)
            ->pageCount();

        return response()
            ->json([
                'page_count' => 25,
                'total_count' => $builder->count(),
                'items' => $builder->getWithPageCount(),
            ]);
    }

    public function show($id)
    {
        $user = User::query()
            ->findOrFail($id);

        return response()
            ->json($user);
    }

    public function destroy($id)
    {
        $user = User::query()
            ->findOrFail($id)
            ->delete();

        return response()
            ->json(null, 204);
    }
    /**
     * @OA\PUT(
     *     path="/admin/customers/update/{id}",
     *     tags={"Admin/Customers"},
     *     summary="کاربران من",
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
     *         @OA\JsonContent(ref="#/components/schemas/AdminUpdateOrCreateCustomerRequestBody")
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

    public function update(UpdateCustomerRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $user = User::findOrFail($id);
            User::updateOrCreateCustomer($user, $request);
            $user->save();
        });

        return response()
            ->json(null, 204);
    }

    /**
     * @OA\POST(
     *     path="/admin/customers/store",
     *     tags={"Admin/Customers"},
     *     summary="کاربران من",
     *     description="",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AdminUpdateOrCreateCustomerRequestBody")
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


    public function store(StoreCustomerRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = new User();
            User::updateOrCreateCustomer($user, $request);
            $user->save();
        });
        return response()
            ->json(null, 204);
    }

    /**
     * @OA\GET(
     *     path="/admin/customers/label-search",
     *     tags={"Admin/Customers"},
     *     summary="کاربران من",
     *     description="",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=true,
     *         explode=true
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

    public function labelSearch(Request $request)
    {
        $request->validate([
            'search' => ['required'],
        ]);

        $builder = (new UserBuilder())
            ->search($request->search, ['first_name', 'last_name'])
            ->order($request->order_by, $request->order_type)
            ->type(User::TYPES['مشتری'])
            ->offset(0)
            ->pageCount(25)
            ->getWithPageCount();


        return response()
            ->json(CustomerLabelSearchResource::collection($builder));
    }


    /**
     * @OA\GET(
     *     path="/admin/customers/packages/label-search",
     *     tags={"Admin/Customers"},
     *     summary="کاربران من",
     *     description="",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=true,
     *         explode=true
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

    public function packagesLabelSearch(Request $request)
    {
        $request->validate([
            'search' => ['required'],
        ]);

        $builder = (new UserPackageBuilder())
            ->search($request->search, ['title'])
            ->offset(0)
            ->pageCount(25)
            ->getWithPageCount();


        return response()
            ->json(UserPackageLabelSearchResource::collection($builder));
    }

    /**
     * @OA\GET(
     *     path="/admin/customers/addresses/{id}",
     *     tags={"Admin/Customers"},
     *     summary="کاربران من",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="path",
     *         required=true,
     *         explode=true
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

    public function addresses($id)
    {
        $addresses = Address::query()
            ->where('user_id', $id)
            ->get();


        return response()
            ->json($addresses);
    }
}
