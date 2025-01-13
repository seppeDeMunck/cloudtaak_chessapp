const express = require('express');
const app = express();
const port = 3000;

app.use(express.json());

app.post('/competition', (req, res) => {
    const players = req.body.players;
    if (!Array.isArray(players) || players.length < 2 || players.some(player => typeof player !== 'string')) {
        return res.status(400).send('Provide at least two unique player names as a string array.');
    }

    const rounds = generateRoundRobinRounds(players);
    res.json({ rounds });
});

function generateRoundRobinRounds(players) {
    const rounds = [];
    const numRounds = players.length % 2 === 0 ? players.length - 1 : players.length;
    const numPlayers = players.length;

    // Add a "Bye" if the number of players is odd
    const playerList = players.length % 2 === 0 ? [...players] : [...players, 'Bye'];

    for (let round = 0; round < numRounds; round++) {
        const roundMatches = [];
        for (let i = 0; i < Math.floor(playerList.length / 2); i++) {
            const home = playerList[i];
            const away = playerList[playerList.length - 1 - i];
            if (home !== 'Bye' && away !== 'Bye') {
                roundMatches.push([home, away]);
            }
        }
        rounds.push({ round: round + 1, matches: roundMatches });

        // Rotate players (except the first one)
        const lastPlayer = playerList.pop();
        playerList.splice(1, 0, lastPlayer);
    }

    return rounds;
}

app.listen(port, () => {
    console.log(`Competition service listening at http://localhost:${port}`);
});
