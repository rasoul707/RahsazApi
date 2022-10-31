<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryItemIndexResource extends JsonResource
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
        if (!empty(@$this->parent->name)) {
            $layer3 = $this->parent->name;
        }

        $layer2 = '';
        if (!empty(@$this->parent->parent->name)) {
            $layer2 = $this->parent->parent->name. ' | ';
        }

        $layer1 = '';
        if (!empty(@$this->parent->parent->parent->name)) {
            $layer1 =  $this->parent->parent->parent->name . ' | ';
        }
        return [
            'id' => @$this->id,
            'name' => @$this->name,
            'order' => @$this->order,
            'icon' => @$this->icon,
            'description' => @$this->description,
            'number_of_subsets' => @$this->number_of_subsets,
            'parent' => [
                'name' =>   $layer1 . $layer2 . $layer3,
                'id'   =>  @$this->parent->id
            ],
            'category' => @$this->category
        ];
    }
}
