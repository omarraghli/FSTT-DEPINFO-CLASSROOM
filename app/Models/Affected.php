<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affected extends Model
{
    protected $fillable = [
        'project_id', 'user_id'
      ];
}
