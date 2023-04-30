<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\TagsResource;
use Validator;

class TagsController extends BaseController
{
    public function index()
    {
        $tags = Tags::all();

        return $this->sendResponse(TagsResource::collection($tags), 'Tags retrieved successfully.');
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

        $tags = Tags::create($input);

        return $this->sendResponse(new TagsResource($tags), 'Tags created successfully.');
    }

    public function show($id)
    {
        $tags = Tags::find($id);

        if (is_null($tags)) {
            return $this->sendError('Tags not found.');
        }

        return $this->sendResponse(new TagsResource($tags), 'Tags retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'status' => 'required'

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $tags = Tags::find($id); // Retrieve the user with ID 1
        if ($tags) {
            $tags->title = $input['title'];
            $tags->status = $input['status'];
            $tags->save();
            return $this->sendResponse(new TagsResource($tags), 'Tags updated successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }


    public function destroy($id)
    {

        $tags = Tags::find($id);
        if ($tags) {
            $tags->delete();

            return $this->sendResponse(new TagsResource($tags),  'Tags deleted successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }
}
