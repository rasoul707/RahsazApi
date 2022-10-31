<?php
namespace Modules\WebsiteSetting\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="UpdateCurrencyRequestBody schema model",
 *     title="UpdateCurrencyRequestBody model",
 *     required={}
 * )
 */
class UpdateCurrencyRequestBody
{
    /**
     * @OA\Property(
     *     example="25000",
     *     description="",
     *     title="golden_package_price",
     * )
     *
     * @var string
     */
    private $golden_package_price;


    /**
     * @OA\Property(
     *     example="26000",
     *     description="",
     *     title="silver_package_price",
     * )
     *
     * @var string
     */
    private $silver_package_price;


    /**
     * @OA\Property(
     *     example="30000",
     *     description="",
     *     title="bronze_package_price",
     * )
     *
     * @var string
     */
    private $bronze_package_price;

}
