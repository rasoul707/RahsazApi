<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryWithParentLabelSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $layer3 = '';
        if(!empty(@$this->parent->name))
            $layer3 = $this->parent->name;

        $layer2 = '';
        if(!empty(@$this->parent->parent->name))
            $layer2 = $this->parent->parent->name ;

        $layer1 = '';
        if(!empty(@$this->parent->parent->parent->name))
            $layer1 = $this->parent->parent->parent->name;

        return [
            'label' => $this->name . ' ( ' . $layer1 . ' - ' . $layer2 . ' - '. $layer3 .' )',
            'value' => $this->id,
        ];
    }
}
