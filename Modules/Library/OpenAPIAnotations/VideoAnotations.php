<?php


/**
 * @OA\GET(
 *     path="/admin/library/videos/index",
 *     tags={"Admin/Library"},
 *     summary="Admin - Library",
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
 * @OA\DELETE(
 *     path="/admin/library/videos/destroy/{id}",
 *     tags={"Admin/Library"},
 *     summary="Admin - Library",
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
 * @OA\PUT(
 *     path="/admin/library/videos/update/{id}",
 *     tags={"Admin/Library"},
 *     summary="Admin - Library",
 *     description="",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="id",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="title",
 *         in="query",
 *         description="title",
 *         required=false,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="alt",
 *         in="query",
 *         description="alt",
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
 * @OA\POST(
 *     path="/admin/library/videos/store",
 *     tags={"Admin/Library"},
 *      summary="admin upload videos",
 *      description="",
 *     @OA\RequestBody(
 *       @OA\MediaType(
 *           mediaType="multipart/form-data",
 *           @OA\Schema(
 *               required={"video"},
 *               @OA\Property(
 *                  property="video",
 *                  description="video file",
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
