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

    public function cours($mots=null)
    {
        $query = $this->hasMany(Cour::class)->getQuery();

        if($mots){
            $query = $query->where('intitule', $mots);
        }

        return $query->get();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
