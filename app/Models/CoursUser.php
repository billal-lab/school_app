<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursUser extends Model
{
    use HasFactory;



    public $guarded=[];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cour(){
        return $this->belongsTo(Cour::class, 'cours_id');
    }

    
}
