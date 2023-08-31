<?php

namespace App\Http\Controllers;

use App\Models\Bklist;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\BklistResource;
use Validator;

class BklistController extends BaseController
{
    public function index(Request $request)
    {
       $query =  Bklist::whereNull('parent_id');

        if ($request->has('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }
        $query->orderBy('orderby', 'asc');
        $category = $query->get();

        $categoriesWithSubcategories = $this->getCategoriesWithSubcategories($category);

        return $this->sendResponse($categoriesWithSubcategories, 'Category retrieved successfully.');
    }

    private function getCategoriesWithSubcategories($categories)
    {
        //                ->where('status', 'Active')
        return $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
                'slug' => $category->slug,
                'brief' => $category->brief,
                'description' => $category->description,
                'status' => $category->status,
                'orderby' => $category->orderby,
                'categories' => $this->getCategoriesWithSubcategories($category->descendants),
                // ->where('status', 'Active')
            ];
        });
    }
    
    

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            // 'slug' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $category = Bklist::create($input);

        return $this->sendResponse(new BklistResource($category), 'Category created successfully.');
    }

    public function show($id)
    {
        $category = Bklist::find($id);

        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }

        $category->descendants;

        return $this->sendResponse($category, 'Category retrieved successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $categoryExists = Bklist::where('slug', $input['slug'])->where('id', '!=', $id)->first();

        // if (!$categoryExists) {
            $category = Bklist::find($id); // Retrieve the user with ID 1
            if ($category) {
                $category->title = $input['title'];
                $category->slug = $input['slug'];
                $category->status = $input['status'];
                $category->orderby = $input['orderby'];
                $category->brief = $input['brief'];
                $category->type =  $input['type'];
                $category->parent_id = isset($input['parent_id']) ? $input['parent_id'] :    $category->parent_id;
                $category->category_id = isset($input['category_id']) ? $input['category_id'] : $category->category_id;
                $category->save();
                return $this->sendResponse(new BklistResource($category), 'Category updated successfully.');
            } else {
                return $this->sendError('Data Not Found');
            }
       /*  } else {
            return $this->sendError('Slug Already Exists', $validator->errors());
        } */
    }


    public function destroy($id)
    {
        $category = Bklist::find($id);
        if ($category) {
            $category->delete();
            return $this->sendResponse(new BklistResource($category),  'Category deleted successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }

    

    public function getSubCategoriesByCategoryId($id)
    {
        $category = Bklist::with('children')->find($id);
        $subcategories = $category->children;
        return $this->sendResponse($subcategories, 'Category retrieved successfully.');
    }


    public function getBookCategories( Request $request , $catid )
    {

        $query =  Bklist::where('cat_id', $catid);

        if ($request->has('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }
        $query->orderBy('orderby', 'asc');
        $category = $query->get();
        $categoriesWithSubcategories = $this->getCategoriesWithSubcategories($category);
        return $this->sendResponse($categoriesWithSubcategories, 'Category retrieved successfully.');
    }

   
}
