<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenom',
        'login',
        'mdp',
        'formation_id',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'mdp'
    ];

    public static function findWithFilter($mots, $categorie){
        $query =  self::select('*');

        if($mots!=null){
            $query = $query->where('login', $mots)
                           ->orWhere('nom', $mots)
                           ->orWhere('prenom', $mots);
        }
        if($categorie!=null){
            $query = $query->where('type', $categorie);
        }
        
        return $query->get();
        
    } 

    public function formation(){

        return $this->belongsTo(Formation::class, 'formation_id');
        
    }

    public function cours_users(){
        return $this->hasMany(CoursUser::class);
    }

    public function cours_enseigant(){
        return $this->hasMany(Cour::class);
    }
}
