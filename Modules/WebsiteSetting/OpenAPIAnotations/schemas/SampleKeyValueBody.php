<?php
namespace Modules\WebsiteSetting\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="SampleKeyValueBody schema model",
 *     title="SampleKeyValueBody model",
 *     required={}
 * )
 */
class SampleKeyValueBody
{

    /**
     * @OA\Property(
     *     example="sample_value",
     *     description="",
     *     title="sample_key",
     * )
     *
     * @var string
     */
    private $sample_key;
}
