<?php


namespace Modules\Order\Services;

use App\Models\TimeHelper;
use Modules\Order\Entities\Order;
use Modules\Order\Http\Requests\UpdateOrCreateOrderRequest;

class OrderServices
{
    public function updateOrCreate(UpdateOrCreateOrderRequest $request, Order $order)
    {
        if (!empty($request->user_id)) {
            $order->user_id = $request->user_id;
        }
        if (!empty($request->address_id)) {
            $order->address_id = $request->address_id;
        }
        if (!empty($request->coupon_id)) {
            $order->coupon_id = $request->coupon_id;
        }
        if (!empty($request->delivery_type)) {
            $order->delivery_type = $request->delivery_type;
        }
        if (!empty($request->overall_status)) {
            $order->overall_status = $request->overall_status;
        }
        if (!empty($request->process_status)) {
            $order->process_status = $request->process_status;
        }
        if (!empty($request->paid_at)) {
            $order->paid_at = TimeHelper::jalali2georgian($request->paid_at);
        }
        if (!empty($request->paid_amount)) {
            $order->paid_amount = $request->paid_amount;
        }
        if (!empty($request->payment_type)) {
            $order->payment_type = $request->payment_type;
        }
        if (!empty($request->delivery_amount)) {
            $order->delivery_amount = $request->delivery_amount;
        }
        if (!empty($request->document_created_at)) {
            $order->document_created_at = TimeHelper::jalali2georgian($request->document_created_at);
        }
        if (!empty($request->bank_receipt_number)) {
            $order->bank_receipt_number = $request->bank_receipt_number;
        }
        if (!empty($request->last_four_digit_of_card)) {
            $order->last_four_digit_of_card = $request->last_four_digit_of_card;
        }
        if (!empty($request->issue_tracking_number)) {
            $order->issue_tracking_number = $request->issue_tracking_number;
        }
        if (!empty($request->reference_number)) {
            $order->reference_number = $request->reference_number;
        }
        if (!empty($request->transaction_number)) {
            $order->transaction_number = $request->transaction_number;
        }
        if (!empty($request->bank_name)) {
            $order->bank_name = $request->bank_name;
        }
        if (!empty($request->bank_receipt_image_id)) {
            $order->bank_receipt_image_id = $request->bank_receipt_image_id;
        }
        if (!empty($request->bijak_image_id)) {
            $order->bijak_image_id = $request->bijak_image_id;
        }
        if (!empty($request->bijak_note)) {
            $order->bijak_note = $request->bijak_note;
        }
        $order->save();
    }
}
