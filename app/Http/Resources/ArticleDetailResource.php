<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleDetailResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image,
            'content' => $this->content,
            'synopsis' => $this->synopsis,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            'user_id' => $this->user_id,
            'writer' => $this->writer,
        ];
    }
}
