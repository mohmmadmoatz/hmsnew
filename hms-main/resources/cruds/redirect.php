<?php

return [
    'model' => App\Models\Redirect::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [
        ['Patient'=>"name"],
        ['stage'=>"name"]
    ],

    // Manage actions in crud
    'create' => true,
    'update' => true,
    'delete' => true,

    // If you will set it true it will automatically
    // add `user_id` to create and update action
    //'with_auth' => true,

    // Validation in update and create actions
    // It will use Laravel validation system
    'validation' => [
        'pat_id' => 'required',
        'redirect_id' => 'required',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'pat_id' => 'number',
        'redirect_id' => 'number',
        'redirect_doctor_id' => 'number',
    ],

    

    // which kind of data should be showed in list page
    'show' => [
        "pat_id",
        "redirect_id",
        "redirect_doctor_id",
        'created_at'

    ],
];
