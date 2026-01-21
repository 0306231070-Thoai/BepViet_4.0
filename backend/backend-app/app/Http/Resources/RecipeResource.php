<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            // Đảm bảo trả về URL ảnh đầy đủ để React hiển thị được
            'image_url' => $this->image ? asset('storage/' . $this->image) : asset('assets/img/default-food.jpg'),
            'time' => $this->time, // Ví dụ: 30 phút
            'calories' => $this->calories,
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}