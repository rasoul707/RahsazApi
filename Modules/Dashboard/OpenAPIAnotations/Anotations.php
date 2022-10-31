<?php


/**
 * @OA\GET(
 *     path="/admin/dashboard/index",
 *     tags={"Admin/Dashboard"},
 *     summary="Admin - Dashboard",
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
