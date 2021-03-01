<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return [
//            'id' => $this->id,
//            'name' => $this->name,
//            'category_id' => $this->category_id,
//            'category' => $this->category,
//            'cost_price' => $this->cost_price,
//            'sale_price' => $this->sale_price,
//            'units_stock' => $this->units_stock,
//            'photo' => $this->photo && $this->photo !== '[]' ? "data:$mimetype;base64," . base64_encode($product_photo) : null,
//            'active' => $this->active,
//        ];

    }
}
