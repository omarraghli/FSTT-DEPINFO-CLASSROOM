<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffectedAssignement extends Model
{
    protected $fillable = [
        'fichier'
      ];
  
      public function setFichierAttribute($value)
      {
        $value = strtolower($value);
        $this->attributes['fichier'] = ucwords($value);
      }


       public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function assignments()
    {
        return $this->belongsTo('App\Models\Assignment');
    }
}
