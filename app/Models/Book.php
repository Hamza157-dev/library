<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

     protected $fillable = ['ISBN' , 'title' , 'price' , 'mortgage' ,'pages',
    'borrow_duration','total_copies','stock','authorship_date' ,'category_id'];
 
    //  protected $guraded = [];


    function category(){
        return $this->belongsTo(Category::class);
    }
    function authors(){
        return $this->belongsToMany(Author::class);
    }
}
