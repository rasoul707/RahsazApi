<?php

namespace Modules\SMS\Entities\Builder;

use App\Models\BaseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SMS\Entities\BulkSmsLog;

class BulkSmsLogBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = BulkSmsLog::query();
    }
}
