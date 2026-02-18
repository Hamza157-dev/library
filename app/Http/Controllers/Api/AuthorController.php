<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();
        return apiSuccess('جميع المؤلفين', $authors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:70',
            'birth_date' => 'nullable|date',
            'country' => 'nullable|string|max:100'
        ]);

        $author = new Author();
        $author->name = $request->name;
        $author->save();

        return apiSuccess("تمت إضافة المؤلف", $author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => "required|max:70",
            'birth_date' => 'nullable|date|before:today',
            'country' => 'nullable|string|max:100'
        ]);

        $author->name = $request->name;
        $author->save();

        return apiSuccess("تم تعديل المؤلف", $author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {

        $author->delete();

        return apiSuccess("تم حذف المؤلف");
    }
}
