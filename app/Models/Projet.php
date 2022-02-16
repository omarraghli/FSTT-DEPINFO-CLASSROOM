<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $fillable = [
        'type', 'fichier'
      ];
  
      public function setTypeAttribute($value)
      {
        $value = strtolower($value);
        $this->attributes['type'] = ucwords($value);
      }

      public function setFichierAttribute($value)
      {
        $value = strtolower($value);
        $this->attributes['fichier'] = ucwords($value);
      }

      public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function affected_projects()
    {
        return $this->hasMany('App\Models\AffectedProject');
    }
}
