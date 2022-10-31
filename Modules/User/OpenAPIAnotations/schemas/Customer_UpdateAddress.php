<?php
namespace Modules\User\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="Customer_UpdateAddress schema model",
 *     title="Customer_UpdateAddress model",
 *     required={}
 * )
 */
class Customer_UpdateAddress
{
    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="location",
     * )
     *
     * @var string
     */
    private $location;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="country",
     * )
     *
     * @var string
     */
    private $country;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="city",
     * )
     *
     * @var string
     */
    private $city;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="longitude",
     * )
     *
     * @var string
     */
    private $longitude;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="latitude",
     * )
     *
     * @var string
     */
    private $latitude;
}
