<?php

return [
    'model' => App\Models\FdebitTransaction::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [
        ['category' => 'name'],
        'number',
        'name',
        'amount_iqd',
        'amount_usd',
        'exchange_rate',
        'notes',
        'date',
    ],

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
        'category_id' => 'required',
        'number' => 'required',
        'date' => 'required',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'category_id' => 'number',
        'number' => 'text',
        'name' => 'text',
        'amount_iqd' => 'number',
        'amount_usd' => 'number',
        'exchange_rate' => 'text',
        'notes' => 'text',
        'date' => 'text',
    ],

    

    // which kind of data should be showed in list page
    'show' => [
        
        ['category' => 'name'],
        'number',
        'name',
        'amount_iqd',
        'amount_usd',
        'exchange_rate',
        'notes',
        'date',

],

];
