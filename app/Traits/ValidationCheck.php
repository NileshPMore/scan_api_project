<?php

namespace App\Traits;

trait ValidationCheck
{
    public function checkdata($getdataArray){
   
        foreach($getdataArray as $key => $value){
            $checkfield = config('validation.'.$key);
            if(isset($checkfield['string']) && ($checkfield['string'] == 'Y')){
                if($checkfield['max-length'] <= strlen($value)){
                    return ['status' =>'fail','msg'=>'Maximum length allowed is '.$checkfield['max-length'],'data'=>$key];
                }
            }
        }
    
        return ['status' =>'success','msg'=>'Process the below flow','data'=>[]];
    }
}

?>