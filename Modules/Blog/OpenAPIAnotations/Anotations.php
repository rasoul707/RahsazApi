<?php


/**
 * @OA\GET(
 *     path="/admin/blog/index",
 *     tags={"Admin/Blog"},
 *     summary="Admin - Blog",
 *     description="",
 *     @OA\Parameter(
 *         name="offset",
 *         in="query",
 *         description="offset",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="status",
 *         in="query",
 *         description="status",
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
 * @OA\POST(
 *     path="/admin/blog/store",
 *     tags={"Admin/Blog"},
 *     summary="Admin - Blog",
 *     description="",
 *     @OA\Parameter(
 *         name="written_by_user_id",
 *         in="query",
 *         description="written_by_user_id",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="title",
 *         in="query",
 *         description="title",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="description",
 *         in="query",
 *         description="description",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="image",
 *         in="query",
 *         description="image",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="has_educational_video",
 *         in="query",
 *         description="has_educational_video",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="tags",
 *         in="query",
 *         description="tags",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="status",
 *         in="query",
 *         description="status",
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
 *     path="/admin/blog/update/{id}",
 *     tags={"Admin/Blog"},
 *     summary="Admin - Blog",
 *     description="",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="id",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="written_by_user_id",
 *         in="query",
 *         description="written_by_user_id",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="title",
 *         in="query",
 *         description="title",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="description",
 *         in="query",
 *         description="description",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="image",
 *         in="query",
 *         description="image",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="has_educational_video",
 *         in="query",
 *         description="has_educational_video",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="tags",
 *         in="query",
 *         description="tags",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="status",
 *         in="query",
 *         description="status",
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
 *     path="/admin/blog/update-status/{id}",
 *     tags={"Admin/Blog"},
 *     summary="Admin - Blog",
 *     description="",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="id",
 *         required=true,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="status",
 *         in="query",
 *         description="status",
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
 *     path="/admin/blog/destory/{id}",
 *     tags={"Admin/Blog"},
 *     summary="Admin - Blog",
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
