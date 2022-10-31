<?php

namespace Modules\Currency\Entities;

use App\Models\BaseBuilder;
use Modules\Product\Entities\Currency;

class CurrencyBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = Currency::query();
    }
}
