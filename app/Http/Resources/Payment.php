<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Payment extends JsonResource
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
            'reference' => $this->reference,
            'description' => $this->description,
            'currency' => $this->currency,
            'total' => (double)$this->total,
            'allow_partial' => (bool)$this->allow_partial,
            'created_at' => (string)$this->created_at
        ];
    }
}
