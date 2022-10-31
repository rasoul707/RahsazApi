<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomSortDecoder
{
    public $orderBy;
    public $orderType;
    public function decode($phrase)
    {
        $this->orderBy = 'created_at';
        $this->orderType = 'desc';

        if($phrase == 'created_at_desc')
        {
            $this->orderBy = 'created_at';
            $this->orderType = 'desc';
        }

        return $this;
    }
}
