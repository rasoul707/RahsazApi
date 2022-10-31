<?php
namespace Modules\Category\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="ReorderItems schema model",
 *     title="ReorderItems model",
 *     required={}
 * )
 */
class ReorderItems
{

    /**
     * @OA\Property(
     *     format="object",
     *     description="",
     *     property="items",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="order",
     *                  type="string",
     *              ),
     *          )
     *      ),
     * @var object[]
     */
    private $items;


}
