<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncryptedApiServiceLog extends Model
{
    protected $fillable = ['scan_id','api_request','api_response','created_at'];
}
