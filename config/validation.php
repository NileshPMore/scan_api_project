<?php 

    return [
        'scan_id'=>[
            'max-length' => '100',
            'string' => 'Y'
        ],
         'session_id'=>[
            'max-length' => '100',
            'string' => 'Y'
        ],
         'operator_id'=>[
            'max-length' => '100',
            'string' => 'Y'
        ],
         'device_id'=>[
            'max-length' => '100',
            'string' => 'Y'
        ],
         'action'=>[
            'max-length' => '100',
            'string' => 'Y'
        ],
         'gps_lat'=>[
            'max-length' => '100',
            'string' => 'N'
        ],
        'gps_lng'=>[
            'max-length' => '100',
            'string' => 'N'
        ],
         'gps_accuracy'=>[
            'max-length' => '100',
            'string' => 'N'
        ],
         'device_timestamp'=>[
            'max-length' => '50',
            'string' => 'N'
        ],
        'app_version'=>[
            'max-length' => '100',
            'string' => 'Y'
        ]
    ];
?>