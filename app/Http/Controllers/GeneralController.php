<?php

namespace App\Http\Controllers;

use App\Models\General;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GeneralResource;
use Validator;


class GeneralController extends BaseController
{
    public function index()
    {
        $banner = General::orderBy('orderby', 'asc')->get();

        return $this->sendResponse(GeneralResource::collection($banner), 'Data retrieved successfully.');
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

        $banner = General::create($input);

        return $this->sendResponse(new GeneralResource($banner), 'Data created successfully.');
    }

    public function show($id)
    {
        $banner = General::find($id);

        if (is_null($banner)) {
            return $this->sendError('General not found.');
        }

        return $this->sendResponse(new GeneralResource($banner), 'Data retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $banner = General::find($id); // Retrieve the user with ID 1
        if ($banner) {
            $banner->value = $input['value'];

            $banner->save();
            return $this->sendResponse(new GeneralResource($banner), 'Data updated successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }


    public function destroy($id)
    {

        $banner = General::find($id);
        if ($banner) {
            $banner->delete();

            return $this->sendResponse(new GeneralResource($banner),  'Data deleted successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }
}