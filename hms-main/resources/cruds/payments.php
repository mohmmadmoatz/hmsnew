<?php

return [
    'model' => App\Models\Payments::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [['user'=>"name"],['Patient'=>"name"],['Patient'=>"id"],'description'],

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
        'payment_type' => 'required',
        'amount' => 'required',
        'description' => 'required',
        'date' => 'required',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'payment_type' => 'text',
        'amount' => 'number',
        'patinet_id' => 'number',
        'description'=>'textarea',
        'date'=>'text'
    ],

    
    // which kind of data should be showed in list page
    'show' => [['user'=>"name"],['Patient'=>"name"],'description','date'],
];
