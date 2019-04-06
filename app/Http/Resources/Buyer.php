<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Buyer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'document' => $this->document,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'street' => $this->street,
            'city' => $this->city,
            'mobile' => $this->mobile,
            'document_type_id' => $this->document_type_id,
            'created_at' => $this->created_at
        ];
    }
}
