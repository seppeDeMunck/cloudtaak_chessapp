<?php

require 'vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Exceptions\MqttClientException;

try {
    // Define connection settings without authentication
    $connectionSettings = (new ConnectionSettings)
        ->setUsername(null) // Set if authentication is required
        ->setPassword(null) // Set if authentication is required
        ->setKeepAliveInterval(60)
        ->setLastWillTopic(null)
        ->setLastWillMessage(null)
        ->setLastWillQualityOfService(0);

    // Initialize MQTT client
    $mqtt = new MqttClient('localhost', 1883, 'laravel-client');
    $mqtt->connect($connectionSettings); // Connect with settings
    echo "Connected to MQTT broker\n";

    // Subscribe to the competition/players topic
    $mqtt->subscribe('competition/players', function ($topic, $message) {
        echo "Received message on {$topic}: {$message}\n";
    }, 1); // QoS 1 for guaranteed delivery

    // Subscribe to the competition/rounds topic
    $mqtt->subscribe('competition/rounds', function ($topic, $message) {
        echo "Received message on {$topic}: {$message}\n";
    }, 1); // QoS 1 for guaranteed delivery

    // Publish a test message to competition/players
    $mqtt->publish('competition/players', 'jan,jeff', 1); // QoS 1
    echo "Message published to competition/players\n";

    // Start the MQTT loop to listen for incoming messages with a timeout
    $mqtt->loop(true, true, 10); // Run loop for 10 seconds
    echo "MQTT loop completed\n";

    // Disconnect from the MQTT broker
    $mqtt->disconnect();
    echo "Disconnected from MQTT broker\n";

} catch (MqttClientException $e) {
    echo "MQTT Client Exception: " . $e->getMessage() . "\n";
}