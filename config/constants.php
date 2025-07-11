<?php

/*
|--------------------------------------------------------------------------
| Application Constants
|--------------------------------------------------------------------------
|
| This file is used to define static, global values that are shared
| across the application. You can store configuration constants here
| such as default values, limits, or system flags.
|
| Example:
|   'default_timezone' => 'Asia/Tokyo',
|   'max_upload_size' => 2048,
|
*/
return [
    'default_seeder_count' => 10,
    'validation' => [
        'default_max_chars' => 30,
        'max_email_address_chars' => 40,
        'max_address_chars' => 255,
        'min_password_chars' => 8,
        'max_username_chars' => 10,
    ],
    'user_register_code_length' => 6,
    'suggested_company_count' => 5,
    'recent_user_application_count' => 5,
    'file_path' => [
        'resume' => 'user/resume/',
    ],
    'pagination' => [
        'default' => 10,
        'jobs' => 10,
    ],
];
