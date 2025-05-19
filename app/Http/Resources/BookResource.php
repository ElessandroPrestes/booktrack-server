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
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'publisher'        => $this->publisher,
            'edition'          => $this->edition,
            'publication_year' => $this->publication_year,
            'authors'          => AuthorResource::collection($this->whenLoaded('authors')),
            'subjects'         => SubjectResource::collection($this->whenLoaded('subjects')),
            'created_at'       => $this->created_at?->toDateTimeString(),
            'updated_at'       => $this->updated_at?->toDateTimeString(),
        ];
    }
}
