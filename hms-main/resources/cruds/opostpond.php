<?php

return [
    'model' => App\Models\Opostpond::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [
        'date',
        'reason',
        'status',

    ],

    // Manage actions in crud
    'create' => true,
    'update' => false,
    'delete' => true,

    // If you will set it true it will automatically
    // add `user_id` to create and update action
    'with_auth' => false,

    // Validation in update and create actions
    // It will use Laravel validation system
    'validation' => [
        'date' => 'required',
        'reason' => 'required|min:30',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'operationhold_id' => 'number',
        'date' => 'text',
        'reason' => 'textarea',
       
    ],

    // Where files will store for inputs
    'store' => [
        'image' => 'images/articles'
    ],

    // which kind of data should be showed in list page
    'show' => ['date', 'reason', 'status'],
];
