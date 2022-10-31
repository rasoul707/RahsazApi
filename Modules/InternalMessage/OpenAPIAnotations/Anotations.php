<?php


/**
 * @OA\POST(
 *     path="/admin/internal-message/send",
 *     tags={"Admin/Internal-Message"},
 *     summary="Admin - Internal Message",
 *     description="",
 *     @OA\Parameter(
 *         name="user_ids[]",
 *         example="1",
 *         in="query",
 *          @OA\Schema(
 *              type="array",
 *              @OA\Items(
 *                  type="string",
 *                  example="1"
 *              ),
 *          ),
 *         description="user_ids",
 *         required=false,
 *         explode=true
 *     ),
 *     @OA\Parameter(
 *         name="text",
 *         example="text",
 *         in="query",
 *         description="text",
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


