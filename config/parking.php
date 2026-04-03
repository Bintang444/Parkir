<?php

/**
 * Konfigurasi Sistem Parkir
 * 
 * Tarif dan setting sistem parkir disimpan di sini
 * untuk memudahkan perubahan tanpa edit kode controller
 */

return [
    // Tarif parkir per jam (dalam Rupiah)
    'tarif_per_jam' => 2000,

    // Durasi minimum (dalam jam) - minimal charge 1 jam
    'durasi_minimum' => 1,

    // Nama tempat parkir (untuk MQTT topic)
    'nama_parkir' => 'parkir-smart',

    // MQTT Settings (jika integrase dengan IoT ESP32)
    'mqtt' => [
        'broker' => 'broker.hivemq.com',
        'port'   => 1883,
    ],
];