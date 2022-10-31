<?php
namespace Modules\Cart\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="CartDeleteProductBody schema model",
 *     title="CartDeleteProductBody model",
 *     required={}
 * )
 */
class CartDeleteProductBody
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

}
