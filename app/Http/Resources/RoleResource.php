<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'v'=> $this->id,
            'guard_name'=> $this->guard_name,
            'name'=> $this->name,
            'role_name' => $this->role_name
        ];
    }
}
