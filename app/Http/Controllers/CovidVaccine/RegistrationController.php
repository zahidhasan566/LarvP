<?php

namespace App\Http\Controllers\CovidVaccine;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\RegisteredVaccineUser;
use App\Models\VaccineCenter;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function vaccineSupportingData(Request $request){
        return response()->json([
            'status' => 'success',
            'vaccineCenters' => VaccineCenter::select('VaccineCenterCode','VaccineCenterName')->get()
        ],200);
    }
    public function checkVaccineCenterCapacity($vaccineCenterCode){

        $checkPerDayVaccapacity = RegisteredVaccineUser::where('VaccineCenterCode',$vaccineCenterCode)->count();


        return response()->json([
            'status' => 'success',
            'vaccineCenters' => VaccineCenter::select('VaccineCenterCode','VaccineCenterName')->get()
        ],200);
    }
}
