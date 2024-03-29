<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class BksubcategoryResource extends JsonResource
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
            'category_name' => $this->parent->title,
            "type" => $this->type,
            "slug" => $this->slug,
            "brief" => $this->brief,
            "image" => $this->image,
            "bookflag" => $this->bookflag,
            "orderby" => $this->orderby,
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
