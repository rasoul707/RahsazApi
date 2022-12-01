<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Http\Resources\SubAdminLabelSearchResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\User\Entities\Builder\UserBuilder;
use Modules\User\Entities\Permission;
use Modules\User\Entities\User;
use Modules\User\Entities\UserPermission;

class SubAdminController extends Controller
{

    /**
     * @OA\POST(
     *     path="/admin/sub-admins/store",
     *     tags={"Admin/My-Team"},
     *     summary="تیم من",
     *     description="",
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="first_name",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="last_name",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         description="phone_number",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="role",
     *         in="query",
     *         description="role",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="username",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="permission_ids[]",
     *         example="id",
     *         in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="integer",
     *                  example="1"
     *              ),
     *          ),
     *         description="permission_ids",
     *         required=false,
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

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['required', 'unique:users,phone_number'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required'],
            'username' => ['required', 'unique:users,username'],
            'password' => ['required'],
            'permissions' => ['nullable', 'array'],
        ]);

        $user = new User();
        $user->type = User::TYPES['مدیر'];
        $user->password = bcrypt($request->password);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->username = $request->username;
        $user->save();

        User::setUserPermissions($user, $request);

        return response()
            ->json(null, 204);
    }


    /**
     * @OA\PUT(
     *     path="/admin/sub-admins/update/{id}",
     *     tags={"Admin/My-Team"},
     *     summary="تیم من",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="first_name",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="last_name",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         description="phone_number",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="role",
     *         in="query",
     *         description="role",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="username",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="permission_ids[]",
     *         example="id",
     *         in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="integer",
     *                  example="1"
     *              ),
     *          ),
     *         description="permission_ids",
     *         required=false,
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

    public function update(Request $request, $id)
    {
        $user = User::query()->findOrFail($id);

        $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['required', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => ['required'],
            'username' => ['required', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable'],
            'permissions' => ['nullable', 'array'],
        ]);

        $user->type = User::TYPES['مدیر'];
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->username = $request->username;
        $user->save();

        User::setUserPermissions($user, $request);

        return response()
            ->json(null, 204);
    }


    /**
     * @OA\PUT(
     *     path="/admin/sub-admins/update-permissions/{id}",
     *     tags={"Admin/My-Team"},
     *     summary="تیم من",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="permission_ids[]",
     *         example="id",
     *         in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="integer",
     *                  example="1"
     *              ),
     *          ),
     *         description="permission_ids",
     *         required=false,
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

    public function updatePermissions(Request $request, $id)
    {
        $user = User::query()->findOrFail($id);

        $request->validate([
            'permissions' => ['array', 'nullable'],
        ]);

        UserPermission::query()->where('user_id', $user->id)->delete();
        foreach ($request->permissions as $permission) {
            $permissionModel = Permission::query()->where('tag_id_en', $permission)->first();
            if ($permissionModel) {
                UserPermission::query()
                    ->create([
                        'user_id' => $user->id,
                        'permissions_id' => $permissionModel->id,
                    ]);
            }
        }


        return response()
            ->json(null, 204);
    }


    /**
     * @OA\DELETE(
     *     path="/admin/sub-admins/destroy/{id}",
     *     tags={"Admin/My-Team"},
     *     summary="تیم من",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
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

    public function destroy($id)
    {
        User::query()->isSubAdmin()->findMany(explode(",", $id))->delete();
        return response()->json(null, 204);
    }


    /**
     * @OA\GET(
     *     path="/admin/sub-admins/index/",
     *     tags={"Admin/My-Team"},
     *     summary="تیم من",
     *     description="",
     *     @OA\Parameter(
     *         name="offset",
     *         example="0",
     *         in="query",
     *         description="offset",
     *         required=true,
     *         explode=true
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         example="",
     *         in="query",
     *         description="search",
     *         required=false,
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

    public function index(Request $request)
    {
        $request->validate([
            'offset' => ['required'],
            'page_size' => ['required'],
        ]);

        $builder = (new UserBuilder())
            ->type(User::TYPES['مدیر'])
            ->search($request->search, ['first_name', 'last_name'])
            ->offset($request->offset)
            ->pageCount($request->page_size);

        return response()
            ->json([
                'page_count' => $request->page_size,
                'total_count' => $builder->count(),
                'items' => $builder->getWithPageCount(),
            ]);
    }



    /**
     * @OA\GET(
     *     path="/admin/sub-admins/show/{id}",
     *     tags={"Admin/My-Team"},
     *     summary="تیم من",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         example="1",
     *         in="path",
     *         description="id",
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

    public function show($id)
    {
        $user = User::query()
            ->findOrFail($id);

        return response()
            ->json($user);
    }

    /**
     * @OA\GET(
     *     path="/admin/sub-admins/show-permissions",
     *     tags={"Admin/My-Team"},
     *     summary="تیم من",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         example="1",
     *         in="query",
     *         description="id",
     *         required=false,
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

    public function showPermissions(Request $request)
    {
        if (empty($request->id)) {
            $allPermissions = Permission::query()->get();
            foreach ($allPermissions as $allPermission) {
                $allPermission['user_access'] = false;
            }

            return response()
                ->json([
                    'permissions' => $allPermissions
                ]);
        }
        $user = User::query()
            ->findOrFail($request->id);

        $allPermissions = Permission::query()->get();
        foreach ($allPermissions as $allPermission) {
            $allPermission['user_access'] = UserPermission::query()
                ->where('permission_id', $allPermission->id)
                ->where('user_id', $user->id)
                ->first() ? true : false;
        }
        return response()
            ->json([
                'permissions' => $allPermissions
            ]);
    }


    /**
     * @OA\GET(
     *     path="/admin/sub-admins/label-search/",
     *     tags={"Admin/My-Team"},
     *     summary="تیم من",
     *     description="",
     *     @OA\Parameter(
     *         name="search",
     *         example="",
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
            ->type(User::TYPES['مدیر'])
            ->search($request->search, ['first_name', 'last_name'])
            ->offset($request->offset)
            ->pageCount(25);

        $items = $builder->getWithPageCount();
        return response()
            ->json(SubAdminLabelSearchResource::collection($items));
    }
}
