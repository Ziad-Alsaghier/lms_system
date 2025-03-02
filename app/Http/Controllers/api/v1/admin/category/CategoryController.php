<?php

namespace App\Http\Controllers\api\v1\admin\category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // This Function For Create Category
    public function __construct(
        private Category $category
    ){}

    //  This Function For Get All Category
    public function index()
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/category
        $categories = $this->category->all();
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ], 200);
    }

    // This Function For Create Category
    public function store(Request $request)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/category
        $data = $request->all();
        $category = $this->category->create($data);
        return response()->json([
            'status' => 'success',
            'data' => $category
        ], 201);
    }

    // This Function update Category
    public function update(Request $request, $id)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/category/{id}
        $category = $this->category->find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category Not Found'
            ], 404);
        }
        $category->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Category Updated Successfully'
        ], 200);
    }

    // This Function For Delete Category

    public function destroy($id)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/category/{id}
        $category = $this->category->find($id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category Not Found'
            ], 404);
        }
        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Category Deleted Successfully'
        ], 200);
    }
    
}
