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

    /**
     * trouver les cours en filtrant selon intitule/enseignant
     */
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

    /**
     * trouver enseignants d'un cour
     */
    public function enseignant(){
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * trouver la formation d'un cours
     */
    public function formation(){
        return $this->belongsTo(Formation::class,'formation_id');
    }

    /**
     * trouver les inscription a ce cours
     */
    public function cours_users()
    {
        return $this->hasMany(CoursUser::class, 'cours_id');
    }

    /**
     * trouver le plannings d'un cours
     */
    public function plannings()
    {
        return $this->hasMany(Planning::class, 'cours_id');
    }

    /**
     * suprimer un cour et tout ce qu'en dépend (planning, suscription)
     */
    public function force_delete(){

        foreach($this->plannings as $planning){

            Planning::destroy($planning->id);

        }

        foreach($this->cours_users as $cours_user){

            CoursUser::where('cours_id',$this->id)->delete();
            
        }

        $this->delete();

    }
}
