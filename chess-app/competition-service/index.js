const express = require('express');
const mqtt = require('mqtt');
const app = express();
const port = 3000;

// Connect to MQTT broker using Docker service name
const client = mqtt.connect('mqtt://mqtt-broker:1883');

client.on('connect', () => {
    console.log('Competition Service connected to MQTT broker');
    client.subscribe('competition/players', (err) => {
        if (!err) {
            console.log('Subscribed to competition/players');
        } else {
            console.error('Subscription error:', err);
        }
    });
});

// Listen for incoming MQTT messages
client.on('message', (topic, message) => {
    if (topic === 'competition/players') {
        console.log('Received players:', message.toString());

        // Parse the received players
        let playersData;
        try {
            playersData = JSON.parse(message.toString());
            if (!playersData.players || !Array.isArray(playersData.players)) {
                throw new Error('Invalid players data');
            }
        } catch (error) {
            console.error('Error parsing players data:', error);
            return;
        }

        const players = playersData.players;
        try {
            const rounds = generateRoundRobinRounds(players);
            console.log('Generated rounds:', JSON.stringify(rounds));

            // Publish the rounds to 'competition/rounds'
            client.publish('competition/rounds', JSON.stringify({ rounds }), (err) => {
                if (!err) {
                    console.log('Published rounds to competition/rounds');
                } else {
                    console.error('Publish error:', err);
                }
            });
        } catch (error) {
            console.error('Error generating rounds:', error);
        }
    }
});

// Function to generate round-robin rounds
function generateRoundRobinRounds(players) {
    const rounds = [];
    const numPlayers = players.length;
    const isOdd = numPlayers % 2 !== 0;
    const playerList = isOdd ? [...players, 'fill'] : [...players];
    const totalRounds = isOdd ? numPlayers : numPlayers - 1;

    for (let round = 0; round < totalRounds; round++) {
        const matches = [];
        for (let i = 0; i < playerList.length / 2; i++) {
            const home = playerList[i];
            const away = playerList[playerList.length - 1 - i];
            if (away !== 'fill'&& home !== 'fill') {
                matches.push([home, away]); // Push array of player names
            }
        }
        rounds.push({ round: round + 1, matches });

        // Rotate players for next round, keeping the first player static
        playerList.splice(1, 0, playerList.pop());
    }
    return rounds;
}

// Start Express server
app.listen(port, () => {
    console.log(`Competition service listening at http://localhost:${port}`);
});