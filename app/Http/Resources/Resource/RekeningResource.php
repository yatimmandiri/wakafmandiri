<?php

namespace App\Http\Resources\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RekeningResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
            'bank' => $this->bank,
            'provider' => $this->provider,
            'token' => $this->token,
            'icon' => $this->icon,
            'status' => $this->status,
            'group' => $this->group,
            'recomendation' => $this->recomendation,
            'relationship' => [],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
