<?php

return [
    'model' => App\Models\LabStockExpiryNotification::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => ['stock_item.name','notification_type','message'],

    // Manage actions in crud
    'create' => false, // Notifications are created automatically
    'update' => false, // Notifications should not be editable
    'delete' => true,  // Allow deleting notifications

    // If you will set it true it will automatically
    // add `user_id` to create and update action
    'with_auth' => false,

    // Validation in update and create actions
    // It will use Laravel validation system
    'validation' => [
        // No validation needed since CRUD operations are disabled
    ],

    // Write every fields in your db which you want to have a input
    // Available types : "ckeditor", "text", "file", "textarea", "password", "number", "email", "select"
    'fields' => [
        // No fields needed since CRUD operations are disabled
    ],

    // which kind of data should be showed in list page
    'show' => ['stock_item.name','notification_type','days_until_expiry','expiry_date','is_read','created_at'],
];
