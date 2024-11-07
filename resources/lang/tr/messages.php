<?php

return [
    'company' => [
        'create' => [
            'success' => 'Firma başarıyla eklendi',
        ],
        'update' => [
            'success' => 'Firma bilgileri başarıyla düzenlendi',
        ],
        'destroy' => [
            'success' => 'Firma başarıyla silindi',
            'error' => 'Firma verisi silinirken hata meydana geldi, lütfen daha sonra tekrar deneyiniz veya sistem yetkilileri ile iletişime geçiniz',
        ],
        'state' => [
            'active' => 'Firma başarıyla aktif edildi',
            'always_active' => 'Firma zaten aktif',
            'passive' => 'Firma başarıyla pasifleştirildi',
            'always_passive' => 'Firma zaten pasif',
        ],
        'defaults' => [
            'survey_title' => 'Bizi Değerlendirin',
            'fields_title' => 'Takipte Kalın',
            'address_link_title' => 'Yol tarifi almak için tıklayınız',
        ]
    ],
    'field' => [
        'create' => [
            'success' => 'Alan başarıyla eklendi',
        ],
        'update' => [
            'success' => 'Alan bilgileri başarıyla düzenlendi',
        ],
        'destroy' => [
            'success' => 'Alan başarıyla silindi',
            'error' => 'Alan verisi silinirken hata meydana geldi, lütfen daha sonra tekrar deneyiniz veya sistem yetkilileri ile iletişime geçiniz',
        ],
    ],
];
