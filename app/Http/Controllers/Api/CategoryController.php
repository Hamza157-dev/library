<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $categories =  Category::all();
        // $categories =  Category::withAvg('books' , 'price')->get();
        $categories =  Category::withCount('books')->get();

        //    return ResponseHelper::success(trans('library.all-categories'),$categories);
        return ResponseHelper::success(__('library.all-categories'), $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:categories',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048'
        ]);
        $category = new Category();
        $category->name = $request->name;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            Storage::putFileAs('category-images', $file, $filename);
            // حفظ اسم الملف في قاعدة البيانات
            $category->image = $filename;
        }

        $category->save();

        return ResponseHelper::success("تمت إضافة الصنف", $category);
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

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            Storage::putFileAs('category-images', $file, $filename);
            if ($category->image)                
                Storage::delete("category-images/$category->image");
            // حفظ اسم الملف في قاعدة البيانات
            $category->image = $filename;
        }
        $category->save();
        return ResponseHelper::success("تم تعديل الصنف", $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {        
        $category = Category::findorfail($id);
        if ($category->image)                
                Storage::delete("category-images/$category->image");
        $category->delete();
        return ResponseHelper::success("تم حذف الصنف");
    }
}
