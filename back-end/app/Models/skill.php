<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class skill extends Model
{
    use HasFactory;
    protected $table = 'tbl_skills';
    protected $primaryKey = 'indexSkills';
    public $timestamps = false;
}
