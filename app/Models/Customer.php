<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model{
    use HasFactory;
    protected $fillable = ['name' ,'gender','DOB','phone' , 'avatar'];
    function user(){
        return $this->belongsTo(User::class);
    }
}
