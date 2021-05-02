<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Planning extends Model
{
    use HasFactory;

    public $fillable = [
        'cours_id',
        'date_debut',
        'date_fin'
    ];

    public $timestamps = false;

    public function cour(){

        return $this->belongsTo(Cour::class, 'cours_id');

    }

    public static function planning_perso($type ,$usertId=null){
       
       if($type === "enseignant"){
            return self::planning_enseignant($usertId);
       }

       if($type === "etudiant"){
            return self::planning_etudiant($usertId);
       }
    }


    private static function planning_enseignant($enseignantId){
        
        $query = DB::table('plannings')
            ->join('cours', 'plannings.cours_id', '=', 'cours.id');
        if($enseignantId!=null){
            $query = $query->where('cours.user_id',$enseignantId);
        }
        
        return $query->select('*')->get();
    }

    private static function planning_etudiant($etudiantId){

        $query = DB::table('plannings')
            ->join('cours_users','plannings.cours_id',"=", 'cours_users.cours_id')
            ->join('cours', 'cours_users.cours_id', "=", 'cours.id' );
        if($etudiantId!=null){
            $query = $query->where('cours_users.user_id',$etudiantId);
        }
        
        return $query->select('*')->get();
    }
}
