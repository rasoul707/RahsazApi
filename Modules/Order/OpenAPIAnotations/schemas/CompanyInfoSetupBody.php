<?php
namespace Modules\WebsiteSetting\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="CompanyInfoSetupBody schema model",
 *     title="CompanyInfoSetupBody model",
 *     required={}
 * )
 */
class CompanyInfoSetupBody
{

    /**
     * @OA\Property(
     *     format="object",
     *     description="",
     *     property="forms",
     *          @OA\Items(
     *              type="object",
     *              @OA\Property(
     *                  property="field_key",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="field_value",
     *                  type="string",
     *              ),
     *          )
     *      ),
     * ),
     *
     * @var object[]
     */
    private $forms;


}
