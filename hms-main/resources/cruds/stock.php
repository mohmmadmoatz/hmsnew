<?php

return [
    'model' => App\Models\Stock::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => ['name','price','qty','qr','notes'],

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
        'price' => 'required',
        'qty' => 'required',
     
    ],
    
    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'name' => 'text',
        'price' => 'text',
        'qty' => 'text',
        'notes' => 'textarea',
        'image' => 'file'
    ],

    // Where files will store for inputs
    'store' => [
        'image' => 'images/articles'
    ],

    // which kind of data should be showed in list page
    'show' => ['name','price','qty','qr','notes'],
];
