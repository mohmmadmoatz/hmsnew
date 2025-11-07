<?php

return [
    'model' => App\Models\Lab::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [['patient' => 'name']],

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
        'patient_id' => 'required'
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'patient_id' => 'number',
        'notes' => 'textarea',
        'image' => 'file'
    ],

    // Where files will store for inputs
    'store' => [
        'image' => 'images/labs'
    ],

    // which kind of data should be showed in list page
    'show' => [['patient' => 'name'],'notes'],
];
