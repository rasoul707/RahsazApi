<?php

namespace Modules\Form\Entities\Builder;

use App\Models\BaseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Form\Entities\Form;

class FormBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = Form::query();
    }
}
