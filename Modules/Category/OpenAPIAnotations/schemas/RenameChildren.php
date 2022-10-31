<?php
namespace Modules\Category\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="RenameChildren schema model",
 *     title="RenameChildren model",
 *     required={}
 * )
 */
class RenameChildren
{

    /**
     * @OA\Property(
     *     format="object",
     *     description="",
     *     property="children",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *              ),
     *          )
     *      ),
     * @var object[]
     */
    private $children;


}
