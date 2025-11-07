<?php

return [
    'model' => App\Models\DebitTransaction::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => [

        'number', 'date', 
        'amount_iqd', 'amount_usd', 'name', 'notes', 'payment_type', 'file',
    ['account' => 'name']

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
        'date' => 'required',
        'amount_iqd' => 'required',
        'amount_usd' => 'required',
        'name' => 'required',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'number' => 'number',
        'date' => 'text',
        'amount_iqd' => 'number',
        'amount_usd' => 'number',
        'name' => 'text',
        'notes' => 'textarea',
        'payment_type' => 'number',
        'file' => 'file',
        'account_id' => 'number',
    ],

    // Where files will store for inputs
    'store' => [
        'file' => 'images/debit'
    ],

    // which kind of data should be showed in list page
    'show' => [
        'number', 'date', 
        'amount_iqd', 'amount_usd', 'name', 'notes', 'payment_type', 'file',
    ['account' => 'name']

],
];
