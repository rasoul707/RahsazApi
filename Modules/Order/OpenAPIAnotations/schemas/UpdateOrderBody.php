<?php
namespace Modules\Order\OpenAPIAnotations\schemas;
/**
 * @OA\Schema(
 *     description="UpdateOrderBody schema model",
 *     title="UpdateOrderBody model",
 *     required={}
 * )
 */
class UpdateOrderBody
{
    /**
     * @OA\Property(
     *     example="waiting_for_confirmation",
     *     description="",
     *     title="process_status",
     * )
     *
     * @var string
     */
    private $process_status;

    /**
     * @OA\Property(
     *     example="2021-11-11 00:23:27",
     *     description="",
     *     title="created_at",
     * )
     *
     * @var string
     */
    private $created_at;

    /**
     * @OA\Property(
     *     example="1",
     *     description="",
     *     title="user_id",
     * )
     *
     * @var string
     */
    private $user_id;

    /**
     * @OA\Property(
     *     example="1",
     *     description="",
     *     title="address_id",
     * )
     *
     * @var string
     */
    private $address_id;

    /**
     * @OA\Property(
     *     example="store_room_door",
     *     description="",
     *     title="delivery_type",
     * )
     *
     * @var string
     */
    private $delivery_type;

}
