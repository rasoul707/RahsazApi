<?php
namespace Modules\Product\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="AddProductsRequestBody schema model",
 *     title="AddProductsRequestBody model",
 *     required={}
 * )
 */
class AddProductsRequestBody
{

    /**
     *
     * @OA\Property(
     *     format="object",
     *     description="",
     *     property="products",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="product_id",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="product_size_id",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="size_price",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="has_cyrup",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="cyrup_price",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="count",
     *                  type="string",
     *              ),
     *          @OA\Property(
     *          format="object",
     *          description="",
     *          property="cyrups",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(
     *                      property="cyrup_id",
     *                      type="integer",
     *                  ),
     *              )
     *          ),
     *          @OA\Property(
     *          format="object",
     *          description="",
     *          property="extras",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(
     *                      property="extra_id",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="price",
     *                      type="integer",
     *                  ),
     *              )
     *          ),
     *          @OA\Property(
     *          format="object",
     *          description="",
     *          property="choices",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(
     *                      property="choice_id",
     *                      type="integer",
     *                  ),
     *                  @OA\Property(
     *                      property="choice_item_id",
     *                      type="integer",
     *                  ),
     *              )
     *          ),
     *    )
     * ),
     *
     * @var object[]
     */
    private $choices_and_extras;

}
