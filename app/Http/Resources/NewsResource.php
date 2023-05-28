<?php

namespace App\Http\Resources;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     
    public function toArray(Request $request): array
    {
        $brief = mb_strlen($this->brief, 'UTF-8') > 70 ? mb_substr($this->brief, 0, 70, 'UTF-8') . '...' : $this->brief;

        return [
            "id" => $this->id,
            "title" => $this->title,
            "brief" => $this->brief,
            "limitedbrief" =>  $brief,
            "categoryid" =>   $this->categoryid ,
            "subcategoryid" =>   $this->subcategoryid ,
            "childcategoryid" =>   $this->childcategoryid ,
            "imageone" => $this->imageone,
            "imagetwo" => $this->imagetwo,
            "imagethree" => $this->imagethree,
            "imagefour" => $this->imagefour,
            "author" => $this->author,
            "specname" => $this->specname,
            "articledate" =>  $this->articledate ,
            "audioone" => $this->audioone,
            "audiotwo" => $this->audiotwo,
            "description" => $this->description,
            "slug" => $this->slug,
            "tags" => $this->tags->pluck('title')->toArray(),
            "specialities" =>  $this->speciality->pluck('title')->toArray(),
            "tagsid" => $this->tags->pluck('id')->toArray(),
            "specialitiesid" =>  $this->speciality->pluck('id')->toArray(),
            "orderby" => $this->orderby,
            "status" => $this->status,
            "deleted_at" => $this->deleted_at ? Carbon::parse($this->deleted_at)->format('Y-m-d H:i:s') : null,
            "created_at" => $this->created_at ? Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
            "updated_at" => $this->updated_at ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,

        ];
    }
}

