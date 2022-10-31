<?php
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Rahsaz OpenApi",
 *      description="developed by Erfan Sabouri",
 *      @OA\Contact(
 *          email="erfaansabouri@gmail.com"
 *      )
 * )
 */
/**
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST_DEV,
 *      description="RAHSAZ DEV SERVER"
 *  )
 */
/**
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST_PROD,
 *      description="RAHSAZ PROD SERVER"
 *  )
 */

/**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     securityScheme="bearerAuth",
 *     bearerFormat="JWT"
 * )
 */

/**
 * @OA\Get(
 *      path="/clear-cache",
 *      tags={"Artisan"},
 *      summary="clear cache",
 *      description="",
 *     @OA\Response(response=200, description="Successful", @OA\JsonContent()),
 *     @OA\Response(response=204, description="Successful. without content"),
 *     @OA\Response(response=400, description="Bad request"),
 *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent()),
 *     @OA\Response(response=422, description="Unprocessable Entity"),
 *     security={
 *         {
 *             "bearerAuth": {}
 *         }
 *     },
 * )
 */
