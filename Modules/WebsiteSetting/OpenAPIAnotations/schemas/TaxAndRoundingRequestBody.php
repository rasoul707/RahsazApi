<?php
namespace Modules\WebsiteSetting\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="TaxAndRoundingRequestBody schema model",
 *     title="TaxAndRoundingRequestBody model",
 *     required={}
 * )
 */
class TaxAndRoundingRequestBody
{
    /**
     * @OA\Property(
     *     example="18",
     *     description="",
     *     title="taxation_percentage",
     * )
     *
     * @var string
     */
    private $taxation_percentage;

    /**
     * @OA\Property(
     *     example="12",
     *     description="",
     *     title="charges_percentage",
     * )
     *
     * @var string
     */
    private $charges_percentage;

    /**
     * @OA\Property(
     *     example="1",
     *     description="",
     *     title="is_rounding_enable",
     * )
     *
     * @var boolean
     */
    private $is_rounding_enable;

    /**
     * @OA\Property(
     *     example="500",
     *     description="",
     *     title="rounding_price",
     * )
     *
     * @var string
     */
    private $rounding_price;


    /**
     * @OA\Property(
     *     example="0",
     *     description="",
     *     title="rounding_target",
     * )
     *
     * @var string
     */
    private $rounding_target;

    /**
     * @OA\Property(
     *     example="up",
     *     description="",
     *     title="rounding_flag",
     * )
     *
     * @var string
     */
    private $rounding_flag;


}
