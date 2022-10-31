<?php
namespace Modules\Category\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="StoreItemProduct schema model",
 *     title="StoreItemProduct model",
 *     required={}
 * )
 */
class StoreItemProduct
{
    /**
     * @OA\Property(
     *     example="product_id",
     *     description="",
     *     title="product_id",
     * )
     *
     * @var string
     */
    private $product_id;

    /**
     * @OA\Property(
     *     example="product_number_in_map",
     *     description="",
     *     title="product_number_in_map",
     * )
     *
     * @var string
     */
    private $product_number_in_map;




}
