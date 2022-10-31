<?php


/**
 * @OA\GET(
 *     path="/admin/customers/index",
 *     tags={"Admin/Customers"},
 *     summary="کاربران من",
 *     description="",
 *     @OA\Parameter(
 *         name="offset",
 *         in="query",
 *         description="offset",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="order_by",
 *         in="query",
 *         description="order_by",
 *         required=false,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="order_type",
 *         in="query",
 *         description="order_type",
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



/**
 * @OA\GET(
 *     path="/admin/customers/show/{id}",
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




/**
 * @OA\DELETE(
 *     path="/admin/customers/destroy/{id}",
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

