<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RecipeResource;

class CookbookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // app/Http/Resources/CookbookResource.php
public function toArray($request) {
    return [
        'id' => $this->id,
        'name' => $this->name,
        'description' => $this->description,
        'recipes_count' => $this->recipes()->count(),
        // Tạo biến updated_at_human cho React sử dụng
        'updated_at_human' => $this->updated_at->diffForHumans(), 
        'recipes' => RecipeResource::collection($this->whenLoaded('recipes')),
    ];
}
}