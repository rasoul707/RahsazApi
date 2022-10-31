<?php
namespace Modules\WebsiteSetting\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="WebsiteSettingSetupBody schema model",
 *     title="WebsiteSettingSetupBody model",
 *     required={}
 * )
 */
class WebsiteSettingSetupBody
{

    /**
     *
     * @OA\Property(
     *     format="object",
     *     description="",
     *     property="sliders",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="image_id",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="order",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="href",
     *                  type="string",
     *              ),
     *          ),
     *    )
     * ),
     *
     * @var object[]
     */
    private $sliders;

    /**
     *
     * @OA\Property(
     *     format="object",
     *     description="",
     *     property="homepage_groups",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="title",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *              format="object",
     *              description="",
     *              property="product_ids",
     *                  @OA\Items(
     *                      type="integer",
     *                  )
     *              ),
     *          ),
     *    )
     * ),
     *
     * @var object[]
     */
    private $homepage_groups;

    /**
     *
     * @OA\Property(
     *     format="object",
     *     description="",
     *     property="banners",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="image_id",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="location",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="href",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="type",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="status",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="expired_at",
     *                  type="string",
     *              ),
     *          ),
     *    )
     * ),
     *
     * @var object[]
     */
    private $banners;

}
