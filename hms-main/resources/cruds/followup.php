<?php

return [
    'model' => App\Models\FollowUp::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [['pat'=>"name"],'treatment'],

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
        'pat_id' => 'required',
        'date' => 'required',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'bp' => 'text',
        'pr' => 'text',
        'drain' => 'text',
        'itake' => 'text',
        'spo2' => 'text',
        'Temp' => 'text',
        'treatment' => 'text',
        'pat_id'=>"number",
        'date' => 'text',
    ],

   

    // which kind of data should be showed in list page
    'show' => [
       'bp', 
       'pr', 
       'drain','itake', 'spo2','Temp','treatment','date',
    ['user' => 'name'],['pat'=>"name"]
    ],
];
