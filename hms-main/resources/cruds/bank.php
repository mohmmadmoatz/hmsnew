<?php

return [
    'model' => App\Models\Bank::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => ['wasl_number','date', 'description'],

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
        'wasl_number' => 'required',
        'description' => 'required',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'wasl_number' => 'number',
        'description' => 'textarea',
        'amount_iqd' => 'number',
        'amount_usd' => 'number',
        'date'=>'text'
        
    ],

    

    // which kind of data should be showed in list page
    'show' => ['wasl_number','date', 'description','amount_iqd','amount_usd'],
];
