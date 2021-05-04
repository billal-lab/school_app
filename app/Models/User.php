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

    /**
     * lister les users en les filterant(nom, prenom, type, login)
     */
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

    /**
     * donner la formation auquel l'etudiant est inscrit
     */
    public function formation(){

        return $this->belongsTo(Formation::class, 'formation_id');
        
    }

    /**
     * donner tout les inscription d'un etudaint a un cours de sa formation
     */
    public function cours_users(){
        return $this->hasMany(CoursUser::class);
    }

    /**
     * donner tout les cours dont le enseignant est reponsable
     */
    public function cours_enseigant(){
        return $this->hasMany(Cour::class);
    }

    /**
     * suprimmer un utilisateur et tout ce qu'ne dépends (cours dont il est reponsable, et ses inscription au cours)
    */
    public function force_delete(){


        foreach ($this->cours_enseigant as $cour) {
            $cour->force_delete();
        }

        foreach($this->cours_users as $cour_user){
            CoursUser::where('user_id', $this->id)->delete();
        }

        User::destroy($this->id);
        
    }
}
