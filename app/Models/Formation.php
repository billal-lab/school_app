<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'intitule',
    ];

    /**
     * donner tout les cours de la formation
     */
    public function cours($mots=null)
    {
        $query = $this->hasMany(Cour::class)->getQuery();

        if($mots){
            $query = $query->where('intitule', $mots);
        }

        return $query->get();
    }

    /**
     * donner tout les etudiant de cet formation
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * suprimmer une formation et tout ce qu'ne dépends (cours)
     */
    public function force_delete(){

        foreach ($this->cours() as $cour) {
            $cour->force_delete();
        }
        
        foreach ($this->users as $user){
            $user->formation_id = null;
            $user->save();
        }

        Formation::destroy($this->id);
    }
}
