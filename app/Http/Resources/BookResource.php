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
            "authorship_date" => $this->authorship_date,
            "pages" => $this->pages,
            "total_copies" => $this->total_copies,
            "stock" => $this->stock,
            "borrow_duration" => $this->borrow_duration,

            "cover" => asset('storage/' . ($this->cover ? ('book-images/' . $this->cover) :  'no-image.png')),

            "category_name" => $this->whenLoaded('category' , $this->category->name  ),
            "authors" => $this->whenLoaded('authors' ,  $this->authors  ),
            'createdAt' => $this->created_at->format('Y-m-d'),
            "rating" => $this->rating ?? 0,
        ];
    }
}
