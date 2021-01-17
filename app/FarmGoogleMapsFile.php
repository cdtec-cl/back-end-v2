<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FarmGoogleMapsFile extends Model
{
    protected $fillable = [
        'id_farm',
        'path_file',
    ]; 
}
