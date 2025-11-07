<?php

return [
    'model' => App\Models\Empadvance::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [
        ['emp' => 'name'],
        "details"
    ],

    // Manage actions in crud
    'create' => true,
    'update' => true,
    'delete' => true,

    // If you will set it true it will automatically
    // add `user_id` to create and update action
    'with_auth' => false,

    // Validation in update and create actions
    // It will use Laravel validation system
    'validation' => [
        'emp_id' => 'required',
        'amount' => 'required',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'emp_id' => 'text',
        'amount' => 'text',
        'details' => 'text',
        'date' => 'text',
    ],

 

    // which kind of data should be showed in list page
    'show' => [['emp' => 'name'],'amount', 'details', 'date'],
];
