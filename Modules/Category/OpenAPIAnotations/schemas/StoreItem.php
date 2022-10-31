<?php
namespace Modules\Category\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="StoreItem schema model",
 *     title="StoreItem model",
 *     required={}
 * )
 */
class StoreItem
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
     *     example="icon.png",
     *     description="",
     *     title="icon",
     * )
     *
     * @var string
     */
    private $icon;

    /**
     * @OA\Property(
     *     example="1",
     *     description="",
     *     title="parent_category_item_id",
     * )
     *
     * @var string
     */
    private $parent_category_item_id;

    /**
     * @OA\Property(
     *     example="1",
     *     description="",
     *     title="category_id",
     * )
     *
     * @var string
     */
    private $category_id;



}
