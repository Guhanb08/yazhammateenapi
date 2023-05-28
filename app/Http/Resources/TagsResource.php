<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\NewsResource;

class TagsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);


        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'brief' => $this->brief,
            'icon' => $this->icon,
            'orderby' => $this->orderby,
            'isgeneral' => $this->isgeneral,
            'status' => $this->status,
            'news' =>  NewsResource::collection($this->news),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format('d/m/Y') : null,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
