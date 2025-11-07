<?php

return [
    'model' => App\Models\Warehouse::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => ["supplier_name","date","menu_no","address","phone"],

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
        'supplier_name' => 'required',
        'date' => 'required',
        'menu_no' => 'required'
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'supplier_name' => 'text',
        'date' => 'text',
        'menu_no' => 'text',
        'phone' => 'number',
        'address' => 'textarea',
        'image' => 'file'
    ],

    // Where files will store for inputs
    'store' => [
        'image' => 'images/warehouse'
    ],

    // which kind of data should be showed in list page
    'show' => ["supplier_name","date","menu_no","address","phone",['user' => 'name']],
];
