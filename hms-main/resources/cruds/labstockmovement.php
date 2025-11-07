<?php

return [
    'model' => App\Models\LabStockMovement::class,

    // searchable fields, if you dont want search feature, remove it
    'search' => ['reference_number','reason','performed_by'],

    // Manage actions in crud
    'create' => false, // Movements are created automatically
    'update' => false, // Movements should not be editable
    'delete' => false, // Movements should not be deletable

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
    'show' => ['stock_item.name','movement_type','quantity','previous_quantity','current_quantity','movement_date','performed_by'],
];
