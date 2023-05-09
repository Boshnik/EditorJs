<?php

return [
    'templates_url' => [
        'xtype' => 'textfield',
        'value' => 'core/components/editorjs/elements/templates/default/',
        'area' => 'editorjs_main',
    ],
    'templates_custom_url' => [
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'editorjs_main',
    ],
    'placeholder' => [
        'xtype' => 'textfield',
        'value' => 'Let`s write an awesome story!',
        'area' => 'editorjs_main',
    ],
    'media_source' => [
        'xtype' => 'modx-combo-source',
        'value' => 1,
        'area' => 'editorjs_main',
    ],
    'image_path' => [
        'xtype' => 'textfield',
        'value' => '/assets/images/{resource_id}/',
        'area' => 'editorjs_main',
    ],
];