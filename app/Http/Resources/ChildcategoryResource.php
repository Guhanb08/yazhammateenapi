<?php

namespace App\Http\Resources;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildcategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
            "id" => $this->id,
            "title" => $this->title,
            'subcategory_name' => $this->parent->title,
            'category_name' => $this->parent->parent ? $this->parent->parent->title : null,
            "type" => $this->type,
            "slug" => $this->slug,
            "brief" => $this->brief,
            "description" => $this->description,
            "parent_id" => $this->parent_id,
            "category_id" => $this->category_id,
            "status" => $this->status,
            "deleted_at" => $this->deleted_at ? Carbon::parse($this->deleted_at)->format('Y-m-d H:i:s') : null,
            "created_at" => $this->created_at ? Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
            "updated_at" => $this->updated_at ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,

        ];
    }
}
