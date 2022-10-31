<?php

namespace Modules\Library\Entities\Builder;

use App\Models\BaseBuilder;
use Modules\Library\Entities\Image;
use Modules\Library\Entities\Video;


class VideoBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = Video::query();
    }
}
