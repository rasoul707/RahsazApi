<?php
namespace Modules\User\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="RegisterBody schema model",
 *     title="UpdateCustomerRequestBody model",
 *     required={}
 * )
 */
class RegisterBody
{
    /**
     * @OA\Property(
     *     format="string",
     *     example="customer",
     *     description="only accept customer",
     *     title="type",
     * )
     *
     * @var string
     */
    private $type;

    /**
     * @OA\Property(
     *     format="string",
     *     example="real_person",
     *     description="values : real_person / coworker / company",
     *     title="role",
     * )
     *
     * @var string
     */
    private $role;

    /**
     * @OA\Property(
     *     format="string",
     *     example="محمد",
     *     description="",
     *     title="first_name",
     * )
     *
     * @var string
     */
    private $first_name;

    /**
     * @OA\Property(
     *     format="string",
     *     example="خادمی",
     *     description="",
     *     title="last_name",
     * )
     *
     * @var string
     */
    private $last_name;


    /**
     * @OA\Property(
     *     format="string",
     *     example="2282610045",
     *     description="",
     *     title="legal_info_melli_code",
     * )
     *
     * @var string
     */
    private $legal_info_melli_code;

    /**
     * @OA\Property(
     *     format="string",
     *     example="09121234567",
     *     description="",
     *     title="phone_number",
     * )
     *
     * @var string
     */
    private $phone_number;

    /**
     * @OA\Property(
     *     format="string",
     *     example="تهران",
     *     description="",
     *     title="state",
     * )
     *
     * @var string
     */
    private $state;

    /**
     * @OA\Property(
     *     format="string",
     *     example="تهران",
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
     *     example="کوچه آزادی",
     *     description="",
     *     title="address",
     * )
     *
     * @var string
     */
    private $address;

    /**
     * @OA\Property(
     *     format="string",
     *     example="as12AS!@",
     *     description="",
     *     title="password",
     * )
     *
     * @var string
     */
    private $password;

    /**
     * @OA\Property(
     *     format="string",
     *     example="12345",
     *     description="",
     *     title="guild_identifier",
     * )
     *
     * @var string
     */
    private $guild_identifier;


    /**
     * @OA\Property(
     *     format="string",
     *     example="َApple",
     *     description="",
     *     title="store_name",
     * )
     *
     * @var string
     */
    private $store_name;


    /**
     * @OA\Property(
     *     format="string",
     *     example="Company Name",
     *     description="",
     *     title="legal_info_company_name",
     * )
     *
     * @var string
     */
    private $legal_info_company_name;



    /**
     * @OA\Property(
     *     format="string",
     *     example="E22223",
     *     description="",
     *     title="legal_info_economical_code",
     * )
     *
     * @var string
     */
    private $legal_info_economical_code;

    /**
     * @OA\Property(
     *     format="string",
     *     example="E22223",
     *     description="",
     *     title="legal_info_registration_number",
     * )
     *
     * @var string
     */
    private $legal_info_registration_number;

    /**
     * @OA\Property(
     *     format="string",
     *     example="تهران",
     *     description="",
     *     title="legal_info_state",
     * )
     *
     * @var string
     */
    private $legal_info_state;

    /**
     * @OA\Property(
     *     format="string",
     *     example="تهران",
     *     description="",
     *     title="legal_info_city",
     * )
     *
     * @var string
     */
    private $legal_info_city;

    /**
     * @OA\Property(
     *     format="string",
     *     example="برج میلاد",
     *     description="",
     *     title="legal_info_address",
     * )
     *
     * @var string
     */
    private $legal_info_address;

    /**
     * @OA\Property(
     *     format="string",
     *     example="51411-553326",
     *     description="",
     *     title="legal_info_postal_code",
     * )
     *
     * @var string
     */
    private $legal_info_postal_code;



    /**
     * @OA\Property(
     *     format="string",
     *     example="0217135266",
     *     description="",
     *     title="legal_info_phone_number",
     * )
     *
     * @var string
     */
    private $legal_info_phone_number;


}
