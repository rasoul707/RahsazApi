<?php

namespace App\Models;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class TimeHelper
{
    public static function jalali2georgian($jalaliTimestamp)
    {
        $persianVertaStartDate = new Verta(Verta::parse($jalaliTimestamp));
        $georgianArray = Verta::getGregorian($persianVertaStartDate->year, $persianVertaStartDate->month, $persianVertaStartDate->day); // [2015,12,25]
        return Carbon::create($georgianArray[0],$georgianArray[1],$georgianArray[2]);
    }
}
