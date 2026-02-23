<?php

/**
 * Konfigurasi MQTT - Sistem Parkir Pintar Berbasis IoT
 * 
 * Sesuai dengan soal UKK dengan topic structure:
 * - parking/{nama}/entry/rfid    (input dari RFID entry)
 * - parking/{nama}/exit/rfid     (input dari RFID exit)
 * - parking/{nama}/entry/servo   (output untuk kontrol servo entry)
 * - parking/{nama}/exit/servo    (output untuk kontrol servo exit)
 * - parking/{nama}/lcd           (output untuk LCD display)
 */

return [
    // MQTT Broker Settings
    'broker' => env('MQTT_BROKER', 'broker.hivemq.com'),
    'port'   => env('MQTT_PORT', 1883),
    'client_id' => env('MQTT_CLIENT_ID', 'laravel-parkir-' . gethostname()),
    
    // Authentication (jika broker memerlukan)
    'username' => env('MQTT_USERNAME', null),
    'password' => env('MQTT_PASSWORD', null),
    
    // Connection Settings
    'keepalive' => env('MQTT_KEEPALIVE', 60),
    'timeout' => env('MQTT_TIMEOUT', 5),
    'clean_session' => env('MQTT_CLEAN_SESSION', true),
    
    // Nama Tempat Parkir (untuk topic)
    'parkir_name' => env('PARKIR_NAME', 'parkir-smart'),
    
    // MQTT Topics - INPUT (dari ESP32)
    'topics' => [
        'entry_rfid' => 'parking/bintang/entry/rfid',
        'exit_rfid'  => 'parking/bintang/exit/rfid',
    ],
    
    // MQTT Topics - OUTPUT (ke ESP32)
    'publish' => [
        'entry_servo' => 'parking/bintang/entry/servo',
        'exit_servo'  => 'parking/bintang/exit/servo',
        'lcd_display' => 'parking/bintang/lcd',
    ],
    
    // QoS Levels
    'qos' => [
        'subscribe' => env('MQTT_QOS_SUB', 1),    // 1 = at least once
        'publish'   => env('MQTT_QOS_PUB', 1),    // 1 = at least once
    ],
    
    // Listener Settings
    'listener' => [
        'enabled' => env('MQTT_LISTENER_ENABLED', true),
        'loop_interval' => env('MQTT_LOOP_INTERVAL', 100), // milliseconds
        'timeout_check' => env('MQTT_TIMEOUT_CHECK', 10),   // seconds
    ],
    
    // Servo Control Payloads
    'servo' => [
        'open' => 'OPEN',      // Perintah buka palang
        'close' => 'CLOSE',    // Perintah tutup palang
    ],
    
    // LCD Message Templates
    'lcd_messages' => [
        'checkin_success' => 'Selamat Datang\n Silakan Masuk',
        'checkout_info' => 'Total: Rp{fee}\n Silakan Bayar',
        'payment_done' => 'Terima Kasih\nSelamat Jalan',
        'error_invalid' => 'Kartu Tidak\n Valid',
        'error_already' => 'Sudah Check-in\nSilakan Keluar',
    ],
];