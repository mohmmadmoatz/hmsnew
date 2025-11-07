<?php

return [
    'model' => App\Models\OperationHold::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => ["operation_name","patinet_id",['patient'=>"name"]],

    // Manage actions in crud
    'create' => false,
    'update' => false,
    'delete' => true,

    // If you will set it true it will automatically
    // add `user_id` to create and update action
    'with_auth' => true,

    // Validation in update and create actions
    // It will use Laravel validation system
    'validation' => [
        'title' => 'required',
        'content' => 'required|min:30',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'title' => 'text',
        'content' => 'textarea',
        'image' => 'file'
    ],

  
    // which kind of data should be showed in list page
    'show' => ['patinet_id','doctor_id','operation_price','operation_name','doctorexp','helper','m5dr','helperm5dr','operation_type'],
];
