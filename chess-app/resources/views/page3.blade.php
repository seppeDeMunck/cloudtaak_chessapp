<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page 3 - Search Player Games & Feedback</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .error-messages {
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Chess App</h1>
    </header>
    <div class="container">
        <h2>Search Player Games</h2>
        <form action="{{ route('page3') }}" method="GET">
            @csrf
            <input type="text" name="player" placeholder="Enter player name" required>
            <button type="submit">Search</button>
        </form>

        <br/><hr/><br/>

        <h2>Request Feedback</h2>
        <form action="{{ route('page3.getGameFeedback') }}" method="GET">
            @csrf
            <input type="text" name="game_id" placeholder="Enter game ID" required>
            <button type="submit">Get Feedback</button>
        </form>

        @if($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($games) && count($games) > 0)
            <h2>Games for {{ $player }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Black</th>
                        <th>White</th>
                        <th>Winner</th>
                        <th>Moves</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($games as $game)
                        <tr>
                            <td>{{ $game['id'] }}</td>
                            <td>{{ $game['black'] }}</td>
                            <td>{{ $game['white'] }}</td>
                            <td>{{ $game['winner'] }}</td>
                            <td>{{ $game['moves'] }}</td>
                            <td>{{ $game['created_at'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif(isset($player))
            <p>No games found for player: {{ $player }}</p>
        @endif

        @if(isset($feedback))
            <br/><hr/><br/>
            <h3>Feedback for Game ID {{ request('game_id') }}</h3>
            <p>{{ $feedback }}</p>
        @endif
    </div>
    <footer>
        <p>&copy; 2023 Chess App</p>
    </footer>
</body>
</html>