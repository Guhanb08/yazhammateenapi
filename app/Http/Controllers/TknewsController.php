<?php

namespace App\Http\Controllers;

use App\Models\Tknews;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\TknewsResource;


use Validator;


class TknewsController extends BaseController
{
    public function index()
    {
        $news = Tknews::orderBy('orderby', 'asc')->get();

        return $this->sendResponse(TknewsResource::collection($news), 'News retrieved successfully.');
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


        $newsExists = Tknews::where('slug', $input['slug'])->first();

        if (!$newsExists) {
            $news = Tknews::create($input);
            $catid = isset($input['childcategoryid']) ? $input['childcategoryid'] :   $input['subcategoryid'];
            $news->categories()->attach($catid);
            return $this->sendResponse(new TknewsResource($news), 'News created successfully.');
        } else {
            return $this->sendError('Slug Already Exists', $validator->errors());
        }
     
    }

    public function show($id)
    {
        $news = Tknews::find($id);

        if (is_null($news)) {
            return $this->sendError('News not found.');
        }

        return $this->sendResponse(new TknewsResource($news), 'News retrieved successfully.');
    }

    public function getArticlesbyslug($slug)
    {
        $news = Tknews::where('slug', $slug)->first();
        if (is_null($news)) {
            return $this->sendError('News not found.');
        }
        return $this->sendResponse(new TknewsResource($news), 'News retrieved successfully.');
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

        $newsExists = Tknews::where('slug', $input['slug'])->where('id', '!=', $id)->first();
        if (!$newsExists) {
            $news = Tknews::find($id); // Retrieve the user with ID 1
            if ($news) {
                $news->title = $input['title'];
                $news->brief = $input['brief'];
                $news->slug = $input['slug'];
                $news->categoryid = $input['categoryid'] ;
                $news->subcategoryid =  isset($input['subcategoryid']) ? $input['subcategoryid'] :   null;
                $news->childcategoryid = isset($input['childcategoryid']) ? $input['childcategoryid'] :    null;
                $news->imageone = $input['imageone'];
                $news->imagetwo = $input['imagetwo'];
                $news->imagethree = $input['imagethree'];
                $news->imagefour = $input['imagefour'];
                $news->author = $input['author'];
                $news->specname = $input['specname'];
                $news->articledate = $input['articledate'];
                $news->status = $input['status'];
                $news->audioone = $input['audioone'];
                $news->audiotwo = $input['audiotwo'];
                $news->description = $input['description'];
                $news->orderby = $input['orderby'];
                $news->save();
                $catid =  isset($input['childcategoryid']) ? $input['childcategoryid'] :   $input['subcategoryid'];
                $news->categories()->sync($catid);
                return $this->sendResponse(new TknewsResource($news), 'News updated successfully.');
            } else {
                return $this->sendError('Data Not Found');
            }
        } else {
            return $this->sendError('Slug Already Exists', $validator->errors());
        }

     
    }

    public function updateStatus(Request $request, $id)
    {
        $input = $request->all();
        $news = Tknews::find($id); // Retrieve the user with ID 1
        if ($news) {
            $news->status = $input['status'];
            $news->save();
            return $this->sendResponse(new TknewsResource($news), 'News updated successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }


    public function destroy($id)
    {

        $news = Tknews::find($id);
        if ($news) {
            $news->delete();

            return $this->sendResponse(new TknewsResource($news),  'News deleted successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }


}
