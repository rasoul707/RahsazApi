<?php
namespace Modules\Product\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="StoreProductBody schema model",
 *     title="StoreProductBody model",
 *     required={}
 * )
 */
class StoreProductBody
{

    /**
     * @OA\Property(
     *     example="name",
     *     description="",
     *     title="name",
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     example="note_before_buy",
     *     description="",
     *     title="note_before_buy",
     * )
     *
     * @var string
     */
    private $note_before_buy;


    /**
     * @OA\Property(
     *     example="description",
     *     description="",
     *     title="description",
     * )
     *
     * @var string
     */
    private $description;


    /**
     * @OA\Property(
     *     example="price_in_toman_for_gold_group",
     *     description="",
     *     title="price_in_toman_for_gold_group",
     * )
     *
     * @var integer
     */
    private $price_in_toman_for_gold_group;


    /**
     * @OA\Property(
     *     example="price_in_toman_for_silver_group",
     *     description="",
     *     title="price_in_toman_for_silver_group",
     * )
     *
     * @var integer
     */
    private $price_in_toman_for_silver_group;


    /**
     * @OA\Property(
     *     example="price_in_toman_for_bronze_group",
     *     description="",
     *     title="price_in_toman_for_bronze_group",
     * )
     *
     * @var integer
     */
    private $price_in_toman_for_bronze_group;

    /**
     * @OA\Property(
     *     example="special_sale_price",
     *     description="",
     *     title="special_sale_price",
     * )
     *
     * @var integer
     */
    private $special_sale_price;

    /**
     * @OA\Property(
     *     example="special_price_started_at",
     *     description="",
     *     example="1400-09-01 12:07:46",
     *     title="special_price_started_at",
     * )
     *
     * @var string
     */
    private $special_price_started_at;

    /**
     * @OA\Property(
     *     example="special_price_expired_at",
     *     description="",
     *     example="1400-09-01 12:07:46",
     *     title="special_price_started_at",
     * )
     *
     * @var string
     */
    private $special_price_expired_at;

    /**
     * @OA\Property(
     *     example="price_depends_on_currency",
     *     description="",
     *     example="1",
     *     title="price_depends_on_currency",
     * )
     *
     * @var integer
     */
    private $price_depends_on_currency;

    /**
     * @OA\Property(
     *     example="1",
     *     description="",
     *     example="1",
     *     title="currency_id",
     * )
     *
     * @var integer
     */
    private $currency_id;

    /**
     * @OA\Property(
     *     example="10",
     *     description="",
     *     example="1",
     *     title="currency_price",
     * )
     *
     * @var integer
     */
    private $currency_price;


    /**
     * @OA\Property(
     *     example="weight",
     *     description="",
     *     example="20",
     *     title="weight",
     * )
     *
     * @var integer
     */
    private $weight;

    /**
     * @OA\Property(
     *     example="length",
     *     description="",
     *     example="20",
     *     title="length",
     * )
     *
     * @var integer
     */
    private $length;


    /**
     * @OA\Property(
     *     example="width",
     *     description="",
     *     example="20",
     *     title="width",
     * )
     *
     * @var integer
     */
    private $width;

    /**
     * @OA\Property(
     *     example="height",
     *     description="",
     *     example="50",
     *     title="height",
     * )
     *
     * @var integer
     */
    private $height;

    /**
     * @OA\Property(
     *     example="identifier",
     *     description="",
     *     example="PLK0-SX",
     *     title="identifier",
     * )
     *
     * @var string
     */
    private $identifier;

    /**
     * @OA\Property(
     *     example="management_enable",
     *     description="",
     *     example="1",
     *     title="management_enable",
     * )
     *
     * @var integer
     */
    private $management_enable;

    /**
     * @OA\Property(
     *     example="supply_count_in_store",
     *     description="",
     *     example="277",
     *     title="supply_count_in_store",
     * )
     *
     * @var integer
     */
    private $supply_count_in_store;

    /**
     * @OA\Property(
     *     example="max_buy_limit",
     *     description="",
     *     example="20",
     *     title="max_buy_limit",
     * )
     *
     * @var integer
     */
    private $max_buy_limit;

    /**
     * @OA\Property(
     *     example="low_supply_alert",
     *     description="",
     *     example="10",
     *     title="low_supply_alert",
     * )
     *
     * @var integer
     */
    private $low_supply_alert;

    /**
     * @OA\Property(
     *     example="only_sell_individually",
     *     description="",
     *     example="1",
     *     title="only_sell_individually",
     * )
     *
     * @var integer
     */
    private $only_sell_individually;


    /**
     * @OA\Property(
     *     example="shelf_code",
     *     description="",
     *     example="TS5623",
     *     title="shelf_code",
     * )
     *
     * @var string
     */
    private $shelf_code;

    /**
     * @OA\Property(
     *     example="supplier_price",
     *     description="",
     *     example="1500",
     *     title="supplier_price",
     * )
     *
     * @var integer
     */
    private $supplier_price;

    /**
     * @OA\Property(
     *     example="manufacturing_country",
     *     description="",
     *     example="US",
     *     title="manufacturing_country",
     * )
     *
     * @var string
     */
    private $manufacturing_country;


    /**
     * @OA\Property(
     *     format="object",
     *     description="",
     *     property="other_names",
     *          @OA\Items(
     *              type="string",
     *          )
     *      ),
     * ),
     *
     * @var object[]
     */
    private $other_names;

    /**
     * @OA\Property(
     *     format="object",
     *     description="",
     *     property="tags",
     *          @OA\Items(
     *              type="string",
     *          )
     *      ),
     * ),
     *
     * @var object[]
     */
    private $tags;




    /**
     * @OA\Property(
     *     example="cover_image_id",
     *     description="",
     *     title="cover_image_id",
     * )
     *
     * @var integer
     */
    private $cover_image_id;



    /**
     * @OA\Property(
     *     format="array",
     *     description="",
     *     property="gallery_image_ids",
     *          @OA\Items(
     *              type="integer",
     *          )
     *      ),
     * ),
     *
     * @var object[]
     */
    private $gallery_image_ids;




    /**
     * @OA\Property(
     *     format="array",
     *     description="",
     *     property="video_ids",
     *          @OA\Items(
     *              type="integer",
     *          )
     *      ),
     * ),
     *
     * @var object[]
     */
    private $video_ids;





    /**
     * @OA\Property(
     *     format="array",
     *     description="",
     *     property="similar_product_ids",
     *          @OA\Items(
     *              type="integer",
     *          )
     *      ),
     * ),
     *
     * @var object[]
     */
    private $similar_product_ids;


    /**
     * @OA\Property(
     *     format="object",
     *     description="",
     *     property="product_attributes",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="attribute_key",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="attribute_value",
     *                  type="string",
     *              ),
     *          )
     *      ),
     * ),
     *
     * @var object[]
     */
    private $product_attributes;


    /**
     * @OA\Property(
     *     format="array",
     *     description="",
     *     property="sub_category_ids",
     *          @OA\Items(
     *              type="integer",
     *          )
     *      ),
     * ),
     *
     * @var object[]
     */
    private $sub_category_ids;


}
