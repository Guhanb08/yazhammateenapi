<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\SpecialityResource;
use Validator;

class SpecialityController extends BaseController
{
    public function index()
    {
        $speciality = Speciality::all();

        return $this->sendResponse(SpecialityResource::collection($speciality), 'Speciality retrieved successfully.');
    }

    public function getallsectionnames()
    {
        $banner = Speciality::all();

        $result = [];

        foreach ($banner as $item) {
            $name = $item['name'];
            $value = $item['title'];
            $result[$name] = $value;
        }
        return $this->sendResponse($result, 'Speciality retrieved successfully.');

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

        $speciality = Speciality::create($input);

        return $this->sendResponse(new SpecialityResource($speciality), 'Speciality created successfully.');
    }

    public function show($id)
    {
        $speciality = Speciality::find($id);

        if (is_null($speciality)) {
            return $this->sendError('Speciality not found.');
        }

        return $this->sendResponse(new SpecialityResource($speciality), 'Speciality retrieved successfully.');
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
        $speciality = Speciality::find($id); // Retrieve the user with ID 1
        if ($speciality) {
            $speciality->title = $input['title'];
            $speciality->slug = $input['slug'];
            $speciality->brief =   $input['brief'];
            $speciality->icon = $input['icon'];
            $speciality->orderby = $input['orderby'];
            $speciality->save();
            return $this->sendResponse(new SpecialityResource($speciality), 'Speciality updated successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }


    public function destroy($id)
    {

        $speciality = Speciality::find($id);
        if ($speciality) {
            $speciality->delete();

            return $this->sendResponse(new SpecialityResource($speciality),  'Speciality deleted successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }

    
    public function getArticlesBySpeciality($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $news = $category->news()->orderBy('orderby', 'asc')->paginate(10);
    
        return $this->sendResponse($news, 'Articles retrieved successfully.');
    }
}
