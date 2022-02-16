<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffectedProject extends Model
{
    protected $fillable = [
        'fichier',
        'note'
      ];

      public function setFichierAttribute($value)
      {
        $value = strtolower($value);
        $this->attributes['fichier'] = ucwords($value);
      }

      public function setNoteAttribute($value)
      {
        $value = strtolower($value);
        $this->attributes['note'] = ucwords($value);
      }

      public function users()
      {
          return $this->belongsTo('App\Models\User');
      }

      public function projets()
      {
          return $this->belongsTo('App\Models\Projet');
      }
}
