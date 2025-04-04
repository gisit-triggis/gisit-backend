<?php

namespace App\Http\Resources\Api\v1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedUserResource extends JsonResource
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
            'email' => $this->email,
            'name' => $this->name ?? "Незнакомец",
            'surname' => $this->surname ?? "",
            'full_name' => $this->full_name != '' ? $this->full_name : "Незнакомец",
            'avatar_url'=> $this->avatar_url ?? ""
        ];
    }
}
