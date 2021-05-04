<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursUser extends Model
{
    use HasFactory;



    public $guarded=[];

    public $timestamps = false;


    /**
     * donner l'untilisateur qui s'est inscrit a cours donné
     */
    public function user(){

        return $this->belongsTo(User::class, 'user_id');

    }



    
    /**
     * donner le cours auquel cet utilisateur s'est inscrit
     */
    public function cour(){

        return $this->belongsTo(Cour::class, 'cours_id');

    }
    
}
