<?php

return [
    'model' => App\Models\Saveaccount::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [
        "amount_iqd",
        "amount_usd",
        "date",
        "details"
    ],

    // Manage actions in crud
    'create' => true,
    'update' => true,
    'delete' => true,

    // If you will set it true it will automatically
    // add `user_id` to create and update action
    'with_auth' => true,

    // Validation in update and create actions
    // It will use Laravel validation system
    'validation' => [
        'type' => 'required',
        'amount_iqd' => 'required',
        'amount_usd' => 'required',
        "date"=>"required",
       
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'type' => 'number',
        'amount_iqd' => 'number',
        'amount_usd' => 'number',
        "date"=>"text",
        "details"=>"text",
        
    ],

    

    // which kind of data should be showed in list page
    'show' => ['type', 'amount_iqd','amount_usd','date','details', ['user' => 'name']],
];
