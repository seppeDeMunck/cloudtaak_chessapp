# filepath: /c:/Users/dmsep/ChessApp/chess-app/RestAPI/winchance.py
from flask import Flask, request, jsonify
import mysql.connector
from decimal import Decimal

app = Flask(__name__)

def get_db_connection():
    connection = mysql.connector.connect(
        host='mysql-db',
        user='username',
        password='password',
        database='chess_db'
    )
    return connection

@app.route('/calculate-win-chance', methods=['POST'])
def calculate_win_chance():
    data = request.get_json()
    player1 = data['player1']
    player2 = data['player2']

    connection = get_db_connection()
    cursor = connection.cursor(dictionary=True)

    # Query games for player1
    cursor.execute("SELECT COUNT(*) as total_games, SUM(CASE WHEN winner = %s THEN 1 ELSE 0 END) as wins FROM games WHERE black = %s OR white = %s", (player1, player1, player1))
    player1_stats = cursor.fetchone()

    # Query games for player2
    cursor.execute("SELECT COUNT(*) as total_games, SUM(CASE WHEN winner = %s THEN 1 ELSE 0 END) as wins FROM games WHERE black = %s OR white = %s", (player2, player2, player2))
    player2_stats = cursor.fetchone()

    cursor.close()
    connection.close()

    # Calculate win rates
    player1_total_games = float(player1_stats['total_games'])
    player2_total_games = float(player2_stats['total_games'])
    player1_wins = float(player1_stats['wins'])
    player2_wins = float(player2_stats['wins'])

    total_games = player1_total_games + player2_total_games
    if total_games > 0:
        player1_win_rate = (player1_wins / total_games) * 100
        player2_win_rate = (player2_wins / total_games) * 100
    else:
        player1_win_rate = 0
        player2_win_rate = 0

    # Normalize win rates to add up to 100%
    total_win_rate = player1_win_rate + player2_win_rate
    if total_win_rate > 0:
        player1_win_rate = (player1_win_rate / total_win_rate) * 100
        player2_win_rate = (player2_win_rate / total_win_rate) * 100

    return jsonify({
        'player1': player1_win_rate,
        'player2': player2_win_rate
    })

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)