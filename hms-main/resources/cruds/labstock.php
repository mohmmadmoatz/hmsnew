<?php

return [
    'model' => App\Models\LabStockItem::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => ['name','code','category','supplier','batch_number'],

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
        'code' => 'required|string|max:255|unique:lab_stock_items,code',
        'category' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
        'min_quantity' => 'required|integer|min:0',
        'unit_price' => 'required|numeric|min:0',
        'supplier' => 'nullable|string|max:255',
        'purchase_date' => 'required|date',
        'expiry_date' => 'required|date|after:purchase_date',
        'batch_number' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'days_before_expiry_notification' => 'required|integer|min:1',
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        'name' => 'text',
        'code' => 'text',
        'category' => 'text',
        'description' => 'textarea',
        'quantity' => 'number',
        'min_quantity' => 'number',
        'unit_price' => 'number',
        'supplier' => 'text',
        'purchase_date' => 'text',
        'expiry_date' => 'text',
        'batch_number' => 'text',
        'location' => 'text',
        'notes' => 'textarea',
        'days_before_expiry_notification' => 'number',
    ],

    // Where files will store for inputs
    'store' => [
        // 'image' => 'images/articles'
    ],

    // which kind of data should be showed in list page
    'show' => ['name','code','category','quantity','expiry_date','status'],
];
