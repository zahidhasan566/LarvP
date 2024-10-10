<?php

namespace App\Http\Controllers\CovidVaccine;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\RegisteredVaccineUser;
use App\Models\VaccineCenter;
use App\Services\RoleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function vaccineSupportingData(Request $request){

        //Vaccine Supporting Data
        return response()->json([
            'status' => 'success',
            'vaccineCenters' => VaccineCenter::select('VaccineCenterCode','VaccineCenterName')->get()
        ],200);
    }
    public function checkVaccineCenterCapacity($vaccineCenterCode,$appointmentDay){

       //Check Booking
       $alreadyBooked = RegisteredVaccineUser::where('VaccineCenterCode',$vaccineCenterCode)
            ->where('AppointmentDay',$appointmentDay )->count();

       //Check Capacity
        $checkPerDayVacCapacity = VaccineCenter::select('PerDayCapacity')->where('VaccineCenterCode',$vaccineCenterCode)->first();
        $capactiy=0;
        if($checkPerDayVacCapacity){
            $capactiy = $checkPerDayVacCapacity->PerDayCapacity;
        }

        return response()->json([
            'status' => 'success',
            'alreadyBooked' => $alreadyBooked,
            'capactiy' => $capactiy,
        ],200);
    }

    public function checkNid($nid){

        //Check Already Registered Or Not
        $alreadyRegisteredNid = RegisteredVaccineUser::where('NID',$nid)->count();
        return response()->json([
            'status' => 'success',
            'alreadyRegisteredNid' => $alreadyRegisteredNid
        ],200);
    }
    public function checkNidHistory($nid){

        //Search By DB raw To Optimize query
        $results = DB::select(DB::raw("SELECT rvt.*, vct.VaccineCenterName FROM RegisteredVaccineUser rvt INNER JOIN VaccineCenter vct
                    on vct.VaccineCenterCode= rvt.VaccineCenterCode WHERE NID = $nid"));

        if ($results) {
            return response()->json([
                'status' => 'success',
                'results' => $results
            ],200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'NID Not Found ! Please Register First'
            ], 200);
        }
    }

    public function storeVaccineUser(Request $request){

        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string',
            'email' => 'required|string',
            'nid' => 'required|min:6',
            'phone' => 'required',
            'vaccineCenter' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        DB::beginTransaction();
        try{
            //Store Vaccine User Data
            $vaccineUser = new RegisteredVaccineUser();
            $vaccineUser->NID= $request->nid;
            $vaccineUser->FullName= $request->fullName;
            $vaccineUser->Age= $request->age;
            $vaccineUser->Email= $request->email;
            $vaccineUser->Phone= $request->phone;
            $vaccineUser->VaccineCenterCode= $request->vaccineCenter['VaccineCenterCode'];
            $vaccineUser->AppointmentDay= $request->selectedAppointmentDate;
            $vaccineUser->EntryDate= Carbon::now();
            $vaccineUser->IpAddress= $request->ip();
            $vaccineUser->save();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Registered'
            ],200);


        }
        catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage() . '-' . $exception->getLine()
            ], 500);
        }
    }
}
