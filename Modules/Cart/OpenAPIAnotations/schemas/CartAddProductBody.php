<?php
namespace Modules\Cart\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="CartAddProductBody schema model",
 *     title="CartAddProductBody model",
 *     required={}
 * )
 */
class CartAddProductBody
{

    /**
     * @OA\Property(
     *     format="integer",
     *     description="",
     *     title="product_id",
     * )
     *
     * @var integer
     */
    private $product_id;


    /**
     * @OA\Property(
     *     format="integer",
     *     description="",
     *     title="count",
     * )
     *
     * @var integer
     */
    private $count;
}
