<?php
namespace Modules\WebsiteSetting\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="StoreSliderBody schema model",
 *     title="StoreSliderBody model",
 *     required={}
 * )
 */
class StoreSliderBody
{
    /**
     * @OA\Property(
     *     example="image_id",
     *     description="",
     *     title="image_id",
     * )
     *
     * @var string
     */
    private $image_id;

    /**
     * @OA\Property(
     *     example="order",
     *     description="",
     *     title="order",
     * )
     *
     * @var string
     */
    private $order;

    /**
     * @OA\Property(
     *     example="href",
     *     description="",
     *     title="href",
     * )
     *
     * @var string
     */
    private $href;
}
