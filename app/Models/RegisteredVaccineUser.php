<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredVaccineUser extends Model
{
    use HasFactory;
    protected $table = "RegisteredVaccineUser";
    public $primaryKey = 'Id';
    protected $guarded = [];
    public $timestamps = false;
}
