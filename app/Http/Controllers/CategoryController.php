<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\CategoryResource;
use Validator;

class CategoryController extends BaseController
{
    public function index()
    {
        $category = Category::whereNull('parent_id')->get();

        $categoriesWithSubcategories = $this->getCategoriesWithSubcategories($category);

        return $this->sendResponse($categoriesWithSubcategories, 'Category retrieved successfully.');
    }

    private function getCategoriesWithSubcategories($categories)
    {
        return $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
                'brief' => $category->brief,
                'description' => $category->description,
                'categories' => $this->getCategoriesWithSubcategories($category->descendants),
            ];
        });
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'parent_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $category = Category::create($input);

        return $this->sendResponse(new CategoryResource($category), 'Category created successfully.');
    }

    public function show($id)
    {
        $category = Category::find($id);

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
            'parent_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $category = Category::find($id); // Retrieve the user with ID 1
        if ($category) {

            $category->title = $input['title'];
            $category->brief = $input['brief'];
            $category->description = $input['description'];
            $category->parent_id = $input['parent_id'];
            $category->status = $input['status'];
            $category->save();
            return $this->sendResponse(new CategoryResource($category), 'Category updated successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }


    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return $this->sendResponse(new CategoryResource($category),  'Category deleted successfully.');
        } else {
            return $this->sendError('Data Not Found');
        }
    }
}
