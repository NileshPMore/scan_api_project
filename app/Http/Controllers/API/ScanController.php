<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidatedRequest;
use Illuminate\Database\QueryException;
use App\Models\EncryptedApiServiceLog;
use App\Services\ScanValidationService;
use Illuminate\Support\Facades\Log;
use App\Models\PayloadDataTable;
use App\Traits\ValidationCheck;
use Illuminate\Http\Request;
use \Carbon\Carbon;  
use DB;


class ScanController extends Controller
{   
    use ValidationCheck; //trait function

    protected $scanvalidation;

    public function __construct(ScanValidationService $scanvalidation){
        $this->scanvalidation = $scanvalidation;
    }

    public function scanapidata(ValidatedRequest $request){

        try{
            $validatedrequest = $request->validated();
            $requestData = $request->all();
        
            $api_key = isset($requestData['API_KEY']) && $requestData['API_KEY'] !=''?$requestData['API_KEY']:'';

            if(isset($requestData['API_KEY'])){
                unset($requestData['API_KEY']);
            }

            $checkStatus = $this->checkdata($requestData);
            if(isset($checkStatus['status']) && $checkStatus['status'] == 'fail'){
                return json_encode(['status'=>'fail','msg'=>$checkStatus['msg'],'data'=>$checkStatus['data']]);
            }

            if($api_key == env('API_KEY')){
                $requestData['scan_id'] = htmlspecialchars($requestData['scan_id']);

                //here check scanid exists or not
                $checkexists = $this->scanvalidation->checkScanIdExists($requestData['scan_id']);
              
                if(isset($checkexists['status']) && $checkexists['status'] == 'fail'){
                    return json_encode(['status'=>$checkexists['status'],'msg'=>$checkexists['msg'],'data'=>$checkexists['data']]);
                }

                $requestData['session_id'] = htmlspecialchars($requestData['session_id']);
                $requestData['operator_id'] = htmlspecialchars($requestData['operator_id']);
                $requestData['device_id'] = htmlspecialchars($requestData['device_id']);
                $requestData['action'] = htmlspecialchars($requestData['action']);
                $requestData['gps_lat'] = isset($requestData['gps_lat']) && $requestData['gps_lat'] !=''?htmlspecialchars($requestData['gps_lat']):null;
                $requestData['gps_lng'] = isset($requestData['gps_lng']) && $requestData['gps_lng'] != ''?htmlspecialchars($requestData['gps_lng']):null;
                $requestData['gps_accuracy'] = isset($requestData['gps_accuracy']) && $requestData['gps_accuracy'] !=''?htmlspecialchars($requestData['gps_accuracy']):null;
                $requestData['device_timestamp'] = isset($requestData['device_timestamp']) && $requestData['device_timestamp'] != ''?htmlspecialchars($requestData['device_timestamp']):null;
                $requestData['app_version'] = htmlspecialchars($requestData['app_version']);
               
                if($requestData['device_timestamp'] !=''){
                     $requestData['device_timestamp'] = Carbon::parse($requestData['device_timestamp'])->format('d-m-Y hh:ss:mm');
                }

                DB::beginTransaction();
                try{
                    EncryptedApiServiceLog::create(['scan_id'=>$requestData['scan_id'],'api_request'=>json_encode($requestData),'api_response'=>'NA','created_at'=>Carbon::now()]);
                
                    $checkstored = PayloadDataTable::create($requestData);
                    $referid = isset($checkstored['id']) && $checkstored['id'] !='' ?$checkstored['id']:'';

                    DB::commit(); 
                }catch(QueryException  $e){

                    DB::rollBack();
                    $eMessage = $e->getMessage();
                    Log::channel('payload_api_log')->info(Carbon::now().' - Error ->'.$eMessage);
                    return json_encode(['status'=>'fail','msg'=>'Server error please try again later','data'=>[]]);
                }
               
                if($referid){
                    return json_encode(['status'=>'success','msg'=>'Request successfully generated.Please refer below id '.$referid,'data'=>[]]);
                }else{
                    return json_encode(['status'=>'fail','msg'=>'Server error please try again later','data'=>[]]);
                }
            }else{
                return json_encode(['status'=>'fail','msg'=>'Invalid API key provided in the request.','data'=>[]]);
            }
        }catch(\Exception $e){
            $eMessage = $e->getMessage();
            Log::channel('payload_api_log')->info(Carbon::now().' - Error ->'.$eMessage);
            return json_encode(['status'=>'fail','msg'=>'Server error please try again later','data'=>[]]);
        }
    }
}
