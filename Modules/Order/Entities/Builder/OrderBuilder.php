<?php

namespace Modules\Order\Entities\Builder;

use App\Models\BaseBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\Entities\Order;

class OrderBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = Order::query();
    }

    public function processStatus($processStatus)
    {
        if(!empty($processStatus))
        {
            $this->_model->where('process_status', $processStatus);
        }
        return $this;
    }

    public function overallStatus($status)
    {
        if(!empty($status))
        {
            $this->_model->where('overall_status', $status);
        }
        return $this;
    }

    public function paidAtBetween($startDate, $endDate)
    {
        if(!empty($startDate) && !empty($endDate))
        {
            $this->_model->whereBetween('paid_at', [
                Carbon::parse($startDate),
                Carbon::parse($endDate)
            ]);
        }
        return $this;
    }

    public function userId($userId)
    {
        if(!empty($userId))
        {
            $this->_model->where('user_id', $userId);
        }

        return $this;
    }

}
