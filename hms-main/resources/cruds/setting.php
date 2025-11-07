<?php

return [
    'model' => App\Models\Setting::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [],

    // Manage actions in crud
    'create' => false,
    'update' => true,
    'delete' => false,

    // If you will set it true it will automatically
    // add `user_id` to create and update action
    'with_auth' => false,

    // Validation in update and create actions
    // It will use Laravel validation system
    'validation' => [
        'xray' => 'required',
        
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'xray' => 'number',
        'sonar' => 'number',
        'clinic_price' => 'number',
        'doctor_price' => 'number',
        'doctor_id' => 'number',
    ],

    

    // which kind of data should be showed in list page
    'show' => ['xray', 'sonar','clinic_price','doctor_price','doctor_id'],
];
