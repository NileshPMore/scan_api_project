<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayloadDataTable extends Model
{
    protected $table = 'payload_data_table';

    protected $fillable = ['id','scan_id','session_id','operator_id','device_id','action','gps_lat','gps_lng','gps_accuracy','device_timestamp','app_version','created_at'];

}
