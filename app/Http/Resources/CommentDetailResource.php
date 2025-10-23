<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "post_id"=> $this->post_id,
            "author"=>$this->whenLoaded('user'),
            "post"=>$this->whenLoaded('post'),
            "user_id"=> $this->user_id,
            "content"=> $this->content,
            "created_at"=> $this->created_at->format('d-m-Y H:i:s'),
        ];
    }
}
