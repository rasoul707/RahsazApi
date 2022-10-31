<?php
namespace Modules\User\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="Customer_UpdatePassword schema model",
 *     title="Customer_UpdatePassword model",
 *     required={}
 * )
 */
class Customer_UpdatePassword
{
    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="old_password",
     * )
     *
     * @var string
     */
    private $old_password;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="new_password",
     * )
     *
     * @var string
     */
    private $new_password;

    /**
     * @OA\Property(
     *     format="string",
     *     description="",
     *     title="new_password",
     * )
     *
     * @var string
     */
    private $new_password_confirmation;
}
