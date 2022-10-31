<?php
namespace Modules\Currency\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="StoreCurrencyBody schema model",
 *     title="StoreCurrencyBody model",
 *     required={}
 * )
 */
class StoreCurrencyBody
{
    /**
     * @OA\Property(
     *     example="دلار آمریکا",
     *     description="",
     *     title="title_fa",
     * )
     *
     * @var string
     */
    private $title_fa;

    /**
     * @OA\Property(
     *     example="USD",
     *     description="",
     *     title="title_en",
     * )
     *
     * @var string
     */
    private $title_en;

    /**
     * @OA\Property(
     *     example="$",
     *     description="",
     *     title="sign",
     * )
     *
     * @var string
     */
    private $sign;

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
     *     example="27000",
     *     description="",
     *     title="bronze_package_price",
     * )
     *
     * @var string
     */
    private $bronze_package_price;

    /**
     * @OA\Property(
     *     example="24000",
     *     description="",
     *     title="special_price",
     * )
     *
     * @var string
     */
    private $special_price;

}
