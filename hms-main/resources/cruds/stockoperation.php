<?php

return [
    'model' => App\Models\Stockoperation::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [['stock'=>'name'],'op_type','qty','to_person','to_department','price'],
  
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
        'op_type' => 'required',
        'product_id' => 'required',
        'qty' => 'required',
        
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'op_type' => 'text',
        'product_id' => 'text',
        'to_person' => 'text',
        'to_department' => 'text',
        'price' => 'text',
        'notes' => 'textarea',
        'image' => 'file',
        'qty' => 'text'
    ],

    // Where files will store for inputs
    'store' => [
        'image' => 'images/articles'
    ],

    // which kind of data should be showed in list page
    'show' => [['stock'=>'name'],'op_type','qty',],
];
