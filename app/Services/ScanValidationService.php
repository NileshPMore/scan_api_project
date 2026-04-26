<?php 

namespace App\Services;
use App\Models\PayloadDataTable;
use Illuminate\Database\QueryException;

class ScanValidationService 
{
    public function checkScanIdExists($scanId){
        try{
            $check = PayloadDataTable::where('scan_id',$scanId)->count();
            if($check > 0){
                return ['status' => 'fail','msg'=>'Scan ID already exists.','data'=>[]];
            }
            return ['status' => 'success','msg'=>'Process to the next flow','data'=>[]];

        }catch(QueryException $e){
            $eMessage = $e->getMessage();
            Log::channel('payload_api_log')->info(Carbon::now().' - Error ->'.$eMessage);
            return ['status'=>'fail','msg'=>'Server error please try again later','data'=>[]];
        }
    }
}


?>