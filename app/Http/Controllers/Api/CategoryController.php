<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories =  Category::withCount('books')->get();

        return apiSuccess(__('library.all-categories'), $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:categories',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return apiSuccess("تمت إضافة الصنف", $category);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => "required|max:50|unique:categories,name,$id"
        ]);

        $category = Category::findorfail($id);
        $category->name = $request->name;
        
        $category->save();
        return apiSuccess("تم تعديل الصنف", $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {        
        $category = Category::findorfail($id);
        
        // التحقق من وجود كتب مرتبطة بالصنف
        $booksCount = $category->books()->count();
        if ($booksCount > 0) {
            return apiError("لا يمكن حذف الصنف لوجود $booksCount كتاب مرتبط به");
        }        

        $category->delete();
        return apiSuccess("تم حذف الصنف");
    }
}
