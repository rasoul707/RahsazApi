<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryItemLabelSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $parentName = '';
        if(!empty(@$this->parent->name))
            $parentName = '(' . $this->parent->name . ')';
        return [
            'label' => $this->name .' '. $parentName,
            'value' => $this->id,
        ];
    }
}
