<?php

namespace App\Models;

use App\Models\User;
use App\Models\Formation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cour extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'intitule',
        'user_id',
        'formation_id'
    ];

    public static function findWithFilter($intitule, $enseignant_id){

        $query = Cour::select('*');

        if($intitule!=null){
            $query = $query->where('intitule', $intitule);
        }

        if($enseignant_id!=null){
            $query = $query->where('user_id', $enseignant_id);
        }

        return $query->get();
    }

    public function enseignant(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function formation(){
        return $this->belongsTo(Formation::class,'formation_id');
    }

    public function cours_users()
    {
        return $this->hasMany(CoursUser::class, 'cours_id');
    }
}
