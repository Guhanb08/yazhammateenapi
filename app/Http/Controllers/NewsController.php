<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\NewsResource;
use Validator;

class NewsController extends BaseController
{
    public function index()
    {
        $news = News::all();

        return $this->sendResponse(NewsResource::collection($news), 'News retrieved successfully.');
    }
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $news = News::create($input);
        // $news->categories()->attach($input['category']);
        return $this->sendResponse(new NewsResource($news), 'News created successfully.');
    }

    public function show($id)
    {
        $news = News::find($id);

        if (is_null($news)) {
            return $this->sendError('News not found.');
        }

        return $this->sendResponse(new NewsResource($news), 'News retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $news = News::find($id); // Retrieve the user with ID 1
        if ($news) {
            $news->title = $input['title'];
            $news->brief = $input['brief'];
            $news->imageone = $input['imageone'];
            $news->imagetwo = $input['imagetwo'];
            $news->audioone = $input['audioone'];
            $news->audiotwo = $input['audiotwo'];
            $news->description = $input['description'];
            $news->orderby = $input['orderby'];
            
            $news->save();
            // $news->categories()->sync($input['category']);
            return $this->sendResponse(new NewsResource($news), 'News updated successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }


    public function destroy($id)
    {

        $news = News::find($id);
        if ($news) {
            $news->delete();

            return $this->sendResponse(new NewsResource($news),  'News deleted successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }
}
