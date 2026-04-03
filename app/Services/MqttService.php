<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Exceptions\MqttClientException;
use Illuminate\Support\Facades\Log;

/**
 * MQTT Service - Handle semua operasi MQTT
 * 
 * Fungsi:
 * - Connect ke MQTT broker
 * - Subscribe ke topics (RFID readers)
 * - Publish ke topics (servo, LCD)
 * - Error handling
 */
class MqttService
{
    protected $client;
    protected $connected = false;
    protected $settings;

    /**
     * Constructor - Initialize MQTT client
     */
    public function __construct(?string $clientId = null)
    {
        try {
            $this->initializeClient($clientId);
        } catch (\Exception $e) {
            Log::error('MQTT Service initialization failed: ' . $e->getMessage());
        }
    }

    /**
     * Initialize MQTT client dengan settings dari config
     * @param string|null $clientId Custom client ID (null = pakai dari config)
     */
    private function initializeClient(?string $clientId = null)
    {
        $this->settings = (new ConnectionSettings())
            ->setKeepAliveInterval(config('mqtt.keepalive', 60))
            ->setConnectTimeout(config('mqtt.timeout', 5))
            ->setUseTls(false);

        if (config('mqtt.username') && config('mqtt.password')) {
            $this->settings
                ->setUsername(config('mqtt.username'))
                ->setPassword(config('mqtt.password'));
        }

        $this->client = new MqttClient(
            config('mqtt.broker'),
            config('mqtt.port'),
            $clientId ?? config('mqtt.client_id')
        );
    }

    /**
     * Connect ke MQTT broker
     */
    public function connect(): bool
    {
        try {
            if (!$this->client) {
                $this->initializeClient();
            }

            $this->client->connect($this->settings, true);
            $this->connected = true;

            Log::info('MQTT: Connected to broker ' . config('mqtt.broker'));
            return true;

        } catch (MqttClientException $e) {
            Log::error('MQTT Connection failed: ' . $e->getMessage());
            $this->connected = false;
            return false;
        }
    }

    /**
     * Disconnect dari MQTT broker
     */
    public function disconnect(): bool
    {
        try {
            if ($this->client && $this->connected) {
                $this->client->disconnect();
                $this->connected = false;
                Log::info('MQTT: Disconnected from broker');
                return true;
            }
            return false;
        } catch (MqttClientException $e) {
            Log::error('MQTT Disconnect failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Subscribe ke topic dengan callback
     * 
     * @param string $topic Topic untuk subscribe
     * @param callable $callback Function yang dijalankan saat ada message
     */
    public function subscribe(string $topic, callable $callback): bool
    {
        try {
            if (!$this->connected) {
                $this->connect();
            }

            $qos = config('mqtt.qos.subscribe', 1);

            Log::info("MQTT: Subscribing to topic: $topic");

            $this->client->subscribe($topic, function ($topic, $message) use ($callback) {
                Log::info("MQTT: Message received on $topic: $message");
                $callback($topic, $message);
            }, $qos);

            return true;
        } catch (MqttClientException $e) {
            Log::error("MQTT Subscribe failed for topic $topic: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Subscribe ke multiple topics
     * 
     * @param array $topics Array of topics => callbacks
     */
    public function subscribeMultiple(array $topics): bool
    {
        try {
            if (!$this->connected) {
                $this->connect();
            }

            $qos = config('mqtt.qos.subscribe', 1);

            foreach ($topics as $topic => $callback) {
                Log::info("MQTT: Subscribing to: $topic");
                $this->client->subscribe($topic, $callback, $qos);
            }

            return true;
        } catch (MqttClientException $e) {
            Log::error('MQTT Multiple subscribe failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Publish message ke topic
     * 
     * @param string $topic Topic destination
     * @param string $payload Message payload
     * @param bool $retain Retain message di broker
     */
    public function publish(string $topic, string $payload, bool $retain = false): bool
    {
        try {
            if (!$this->connected) {
                $this->connect();
            }

            $qos = config('mqtt.qos.publish', 1);

            Log::info("MQTT: Publishing to $topic: $payload");

            $this->client->publish($topic, $payload, $qos, $retain);
            return true;
        } catch (MqttClientException $e) {
            Log::error("MQTT Publish failed for topic $topic: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Loop untuk listen messages
     * Gunakan di console command untuk daemon process
     */
    public function loop(): void
    {
        try {
            if (!$this->connected) {
                $this->connect();
            }

            Log::info('MQTT: Starting message loop');

            // v2.x correct usage
            $this->client->loop(true, false);

        } catch (MqttClientException $e) {
            Log::error('MQTT Loop error: ' . $e->getMessage());
        }
    }


    /**
     * Get connected status
     */
    public function isConnected(): bool
    {
        return $this->connected;
    }

    /**
     * Get MQTT client instance
     */
    public function getClient(): ?MqttClient
    {
        return $this->client;
    }

    /**
     * Format topic dengan nama parkir
     * 
     * Contoh:
     * formatTopic('parking/{parkir_name}/entry/rfid')
     * → 'parking/parkir-smart/entry/rfid'
     */
    public static function formatTopic(string $topic): string
    {
        return str_replace(
            '{parkir_name}',
            config('mqtt.parkir_name', 'parkir-smart'),
            $topic
        );
    }

    /**
     * Get formatted entry RFID topic
     */
    public static function getEntryRfidTopic(): string
    {
        return self::formatTopic(config('mqtt.topics.entry_rfid'));
    }

    /**
     * Get formatted exit RFID topic
     */
    public static function getExitRfidTopic(): string
    {
        return self::formatTopic(config('mqtt.topics.exit_rfid'));
    }

    /**
     * Get formatted entry servo topic
     */
    public static function getEntryServoTopic(): string
    {
        return self::formatTopic(config('mqtt.publish.entry_servo'));
    }

    /**
     * Get formatted exit servo topic
     */
    public static function getExitServoTopic(): string
    {
        return self::formatTopic(config('mqtt.publish.exit_servo'));
    }

    /**
     * Get formatted LCD topic
     */
    public static function getLcdTopic(): string
    {
        return self::formatTopic(config('mqtt.publish.lcd_display'));
    }
}