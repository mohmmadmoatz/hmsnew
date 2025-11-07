<?php

return [
    'model' => App\Models\LabStockCategory::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => ['name','code'],

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
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:255|unique:lab_stock_categories,code',
        'description' => 'nullable|string',
        'color' => 'nullable|string|max:7',
        'icon' => 'nullable|string|max:255',
        'sort_order' => 'nullable|integer|min:0',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'name' => 'text',
        'code' => 'text',
        'description' => 'textarea',
        'color' => 'text',
        'icon' => 'text',
        'sort_order' => 'number',
    ],

    // which kind of data should be showed in list page
    'show' => ['name','code','items_count'],
];
