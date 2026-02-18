<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "id" => $this->id ,
            "ISBN" => $this->ISBN ,
            "title" => $this->title ,
            "price" => $this->price ,
            "mortgage" => $this->mortgage ,
            "cover" =>  asset('storage/book-images/' . ($this->cover ?? 'no-image.jpeg')),
            "category" => $this->whenLoaded('category' , fn() => $this->category  ),
            "authors" => $this->whenLoaded('authors' , fn() => $this->authors  ),
        ];
    }
}
