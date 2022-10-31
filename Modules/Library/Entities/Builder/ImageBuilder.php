<?php

namespace Modules\Library\Entities\Builder;

use App\Models\BaseBuilder;
use Modules\Library\Entities\Image;


class ImageBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = Image::query();
    }
}
