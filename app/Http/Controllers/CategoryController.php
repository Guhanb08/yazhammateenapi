<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ChildcategoryResource;
use App\Http\Resources\SubcategoryResource;

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
                'slug' => $category->slug,
                'brief' => $category->brief,
                'description' => $category->description,
                'status' => $category->status,
                'categories' => $this->getCategoriesWithSubcategories($category->descendants),
            ];
        });
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'slug' => 'required',
            'type' => 'required',
            // 'status' => 'required',
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
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $category = Category::find($id); // Retrieve the user with ID 1
        if ($category) {
            $category->title = $input['title'];
            $category->slug = $input['slug'];
            $category->brief = $input['brief'];
            $category->type =  $input['type'];
            $category->parent_id = isset($input['parent_id']) ? $input['parent_id'] : null;
            $category->category_id = isset($input['category_id']) ? $input['category_id'] : null;

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

    public function getCategories()
    {
        $categories = Category::where('type', 'category')->get();
        return $this->sendResponse($categories, 'Category retrieved successfully.');
    }

    public function getSubCategories()
    {
        $categories = Category::where('type', 'Subcategory')->with('parent')->get();
        return $this->sendResponse( SubcategoryResource::collection($categories), 'Category retrieved successfully.');
    }

    public function getChildCategories()
    {
        $categories = Category::where('type', 'Childcategory')->with('ancestors')->get();
        return $this->sendResponse(ChildcategoryResource::collection($categories), 'Category retrieved successfully.');
    }

    public function getSubCategoriesByCategoryId($id)
    {
        $category = Category::with('children')->find($id);
        $subcategories = $category->children;
        return $this->sendResponse($subcategories, 'Category retrieved successfully.');
    }

}
