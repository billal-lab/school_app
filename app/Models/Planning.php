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

    /**
     * donner le cours qui correspond a un planning ou une séance
     */
    public function cour(){

        return $this->belongsTo(Cour::class, 'cours_id');

    }

    /**
     * afficher tout les séance selon le profil demandé  
     */
    public static function planning_perso($type ,$usertId=null, $coursId=null, $date_debut){

       $query= null;

       if($type === "enseignant"){
            $query = self::planning_enseignant($usertId);
       }

       if($type === "etudiant"){
            $query = self::planning_etudiant($usertId);
       }

       if($coursId!=null){
            $query = $query->where('cours.id',$coursId);
        }
        
        if($date_debut!=null){

            $date_d = clone $date_debut;

            $date_fin = date_add($date_d, date_interval_create_from_date_string('7 days'));
    
            $query = $query->whereBetween('plannings.date_debut', [$date_debut->format('Y-m-d H:i:s'), $date_fin->format('Y-m-d H:i:s')]);

        }

        return $query->get();
    }

    /**
     * planning d'un enseignanat
     */
    private static function planning_enseignant($enseignantId){
        
        $query = DB::table('plannings')
            ->join('cours', 'plannings.cours_id', '=', 'cours.id');
        if($enseignantId!=null){
            $query = $query->where('cours.user_id',$enseignantId);
        }
        
        return $query->select('plannings.id','plannings.date_debut', 'plannings.date_fin', 'cours.intitule', 'cours.id as cours_id');
    }

    /**
     * planning d'un etudiant
     */
    private static function planning_etudiant($etudiantId){

        $query = DB::table('plannings')
            ->join('cours_users','plannings.cours_id',"=", 'cours_users.cours_id')
            ->join('cours', 'cours_users.cours_id', "=", 'cours.id' );
        if($etudiantId!=null){
            $query = $query->where('cours_users.user_id',$etudiantId);
        }
        
        return $query->select('*');
    }
}
