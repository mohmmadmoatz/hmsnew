<?php

return [
    'model' => App\Models\Salary::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [],

    // Manage actions in crud
    'create' => false,
    'update' => false,
    'delete' => false,

    // If you will set it true it will automatically
    // add `user_id` to create and update action
    'with_auth' => false,

    // Validation in update and create actions
    // It will use Laravel validation system
    'validation' => [
    
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
      
    ],

  

    // which kind of data should be showed in list page
    'show' => [],
];
