<?php
namespace Modules\Coupon\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="StoreCouponRequestBody schema model",
 *     title="StoreCouponRequestBody model",
 *     required={}
 * )
 */
class StoreCouponRequestBody
{
    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="code",
     * )
     *
     * @var string
     */
    private $code;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="description",
     * )
     *
     * @var string
     */
    private $description;


    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="type",
     * )
     *
     * @var string
     */
    private $type;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="amount_type",
     * )
     *
     * @var string
     */
    private $amount_type;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="amount",
     * )
     *
     * @var string
     */
    private $amount;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="expired_at",
     * )
     *
     * @var string
     */
    private $expired_at;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="limit_count",
     * )
     *
     * @var string
     */
    private $limit_count;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="max_amount",
     * )
     *
     * @var string
     */
    private $max_amount;


    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="min_amount",
     * )
     *
     * @var string
     */
    private $min_amount;

    /**
     * @OA\Property(
     *     format="array",
     *     description="",
     *     title="allowed_product_ids",
     *          @OA\Items(
     *              type="integer",
     *          )
     * )
     *
     * @var array
     */
    private $allowed_product_ids;


    /**
     * @OA\Property(
     *     format="array",
     *     description="",
     *     title="allowed_category_ids",
     *          @OA\Items(
     *              type="integer",
     *          )
     * )
     *
     * @var array
     */
    private $allowed_category_ids;

    /**
     * @OA\Property(
     *     format="array",
     *     description="",
     *     title="allowed_user_ids",
     *          @OA\Items(
     *              type="integer",
     *          )
     * )
     *
     * @var array
     */
    private $allowed_user_ids;

    /**
     * @OA\Property(
     *     format="array",
     *     description="",
     *     title="allowed_package_ids",
     *          @OA\Items(
     *              type="integer",
     *          )
     * )
     *
     * @var array
     */
    private $allowed_package_ids;

}
