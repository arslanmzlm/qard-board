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
            'platforms_title' => 'Takipte Kalın',
            'banks_title' => 'Banka Hesaplarımız',
            'address_link_title' => 'Yol tarifi almak için tıklayınız',
        ]
    ],
    'bank' => [
        'create' => [
            'success' => 'Banka başarıyla eklendi',
        ],
        'update' => [
            'success' => 'Banka bilgileri başarıyla düzenlendi',
        ],
        'destroy' => [
            'success' => 'Banka başarıyla silindi',
            'error' => 'Banka verisi silinirken hata meydana geldi, lütfen daha sonra tekrar deneyiniz veya sistem yetkilileri ile iletişime geçiniz',
        ],
    ],
    'platform' => [
        'create' => [
            'success' => 'Platform başarıyla eklendi',
        ],
        'update' => [
            'success' => 'Platform bilgileri başarıyla düzenlendi',
        ],
        'destroy' => [
            'success' => 'Platform başarıyla silindi',
            'error' => 'Platform verisi silinirken hata meydana geldi, lütfen daha sonra tekrar deneyiniz veya sistem yetkilileri ile iletişime geçiniz',
        ],
    ],
];
