<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineCenter extends Model
{
    use HasFactory;
    protected $table = "VaccineCenter";
    public $primaryKey = 'Id';
    protected $guarded = [];
    public $timestamps = false;
}
