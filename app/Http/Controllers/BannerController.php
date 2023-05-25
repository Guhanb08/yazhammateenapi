<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\BannerResource;
use Validator;

class BannerController extends BaseController
{
    public function index()
    {
        $banner = Banner::orderBy('orderby', 'asc')->get();

        return $this->sendResponse(BannerResource::collection($banner), 'Banner retrieved successfully.');
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

        $banner = Banner::create($input);

        return $this->sendResponse(new BannerResource($banner), 'Banner created successfully.');
    }

    public function show($id)
    {
        $banner = Banner::find($id);

        if (is_null($banner)) {
            return $this->sendError('Banner not found.');
        }

        return $this->sendResponse(new BannerResource($banner), 'Banner retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $banner = Banner::find($id); // Retrieve the user with ID 1
        if ($banner) {
            $banner->value = $input['value'];

            $banner->save();
            return $this->sendResponse(new BannerResource($banner), 'Banner updated successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }


    public function destroy($id)
    {

        $banner = Banner::find($id);
        if ($banner) {
            $banner->delete();

            return $this->sendResponse(new BannerResource($banner),  'Banner deleted successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }
}
