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
    public function index(Request $request)
    {
       $query =  Category::whereNull('parent_id');

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
        return $categories->where('status', 'Active')->map(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
                'slug' => $category->slug,
                'brief' => $category->brief,
                'description' => $category->description,
                'status' => $category->status,
                'orderby' => $category->orderby,
                'categories' => $this->getCategoriesWithSubcategories($category->descendants)->where('status', 'Active'),
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
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // $category = Category::create($input);

        $categoryExists = Category::where('slug', $input['slug'])->first();

        if (!$categoryExists) {
            $category = Category::create($input);
        } else {
            return $this->sendError('Slug Already Exists', $validator->errors());
        }

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
            'type' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $categoryExists = Category::where('slug', $input['slug'])->where('id', '!=', $id)->first();

        if (!$categoryExists) {
            $category = Category::find($id); // Retrieve the user with ID 1
            if ($category) {
                $category->title = $input['title'];
                $category->slug = $input['slug'];
                $category->status = $input['status'];
                $category->orderby = $input['orderby'];
                $category->brief = $input['brief'];
                $category->image = $input['image'];
                $category->bookflag = $input['bookflag'];
                $category->type =  $input['type'];
                $category->parent_id = isset($input['parent_id']) ? $input['parent_id'] :    $category->parent_id;
                $category->category_id = isset($input['category_id']) ? $input['category_id'] : $category->category_id;
                $category->save();
                return $this->sendResponse(new CategoryResource($category), 'Category updated successfully.');
            } else {
                return $this->sendError('Data Not Found');
            }
        } else {
            return $this->sendError('Slug Already Exists', $validator->errors());
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
        $categories = Category::where('type', 'category')->orderBy('orderby', 'asc')->get();
        return $this->sendResponse($categories, 'Category retrieved successfully.');
    }

    public function getSubCategories()
    {
        // ->with('parent')
        $categories = Category::where('type', 'Subcategory')->orderBy('orderby', 'asc')->get();
        return $this->sendResponse(SubcategoryResource::collection($categories), 'Category retrieved successfully.');
    }

    public function getChildCategories()
    {
        // ->with('ancestors')
        $categories = Category::where('type', 'Childcategory')->orderBy('orderby', 'asc')->get();
        return $this->sendResponse(ChildcategoryResource::collection($categories), 'Category retrieved successfully.');
    }

    public function getSubCategoriesByCategoryId($id)
    {
        $category = Category::with('children')->find($id);
        $subcategories = $category->children;
        return $this->sendResponse($subcategories, 'Category retrieved successfully.');
    }


    public function getArticlesbyslug($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $category->parenttitle = $category->parent->title ?? null;
            $category->grandtitle = $category->parent->parent->title ?? null;
        }
        $news = $category->news()->where('status', 'Active')->orderBy('orderby', 'asc')->paginate(10);
        

        $response = [
            'category' => $category,
            'news' => $news,
        ];

        

        return $this->sendResponse($response, 'Articles retrieved successfully.');
    }
}
