<?php

return [
    'show_warnings' => false,
    'public_path'   => null,
    'convert_entities' => true,

    'options' => [
        'font_dir'   => storage_path('fonts'),
        'font_cache' => storage_path('fonts'),
        'temp_dir'   => sys_get_temp_dir(),

        // PDF yerelden dosya okuyacak → public köke kilitle
        'chroot' => public_path(),

        'allowed_protocols' => [
            'data://'  => ['rules' => []],
            'file://'  => ['rules' => []],
            'http://'  => ['rules' => []],
            'https://' => ['rules' => []],
        ],

        'enable_font_subsetting' => false,
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'default_paper_size' => 'a4',
        'default_paper_orientation' => 'portrait',
        'default_font' => 'Montserrat',   // yoksa DejaVu Sans’a düşer
        'dpi' => 96,
        'enable_php' => false,
        'enable_javascript' => true,

        // asset() ile http/https kullanacaksan şart; ama yine de aşağıda file:// öneriyorum
        'enable_remote' => true,

        'allowed_remote_hosts' => null,
        'font_height_ratio' => 1.1,
        'enable_html5_parser' => true,
    ],
];
