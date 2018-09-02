<?php

return [
    'site_name' => 'TBA',
    'currency' => [
        'USD' => ['symbol' => '$', 'name' => 'US Dollors'],
    ],
    'image_path'=>[
            'cart'=>'uploads/cart/',
            'tmp'=>'uploads/tmp/',
            'products'=>'uploads/products/',
            'orders'=>'uploads/orders/',
            'categories'=>'uploads/categories/',
            'contents'=>'uploads/contents/',
    ],
    'currency_default' => 'USD',
    'languages' => [
        'en_uk' => 'English (UK)',
        'en_us' => 'English (Us)',
    ],
    'language_default' => 'en_uk',
    'contentTypes' => [
        'page' => 'Page',
        'email' => 'Email',
        'block' => 'Block',
    ],
    'per_month' => '/month',
    'order_prefix' => "tba",
    'order_email' => 'orders@tba.net',
    'type' => [
        'product' => 'Product',
        'blog' => 'Blog',
        'category' => 'Category',
    ]
];