<?php

return [
    'model' => App\Models\WarehouseExport::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => ["name","date","total","menu_no"],

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
        'name' => 'required',
        'date' => 'required',
        'menu_no' => 'required|unique:warehouse_exports,menu_no',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'name' => 'text',
        'date' => 'text',
        'total' => 'text'
    ],

   

    // which kind of data should be showed in list page
    'show' => ["name","date","total", ['user' => 'name']],
];
