<?php

return [
    'model' => App\Models\Patient::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => ["name","gender","phone","id","status","notes"],

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
        'name' => 'required',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'name' => 'text',
        'gender' => 'text',
        'phone' => 'text',
        'gender' => 'text',
        'status' => 'text',
        'image' => 'file'
    ],

    // Where files will store for inputs
    'store' => [
        'image' => 'images/articles'
    ],

    // which kind of data should be showed in list page
    'show' => ["id","name","gender","phone","status"],
];
