<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            margin-top: 20px;
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

        <h2>Get Player Feedback</h2>
        <form action="{{ route('page3') }}" method="GET">
            @csrf
            <input type="text" name="player_id" placeholder="Enter player ID" required>
            <button type="submit">Get Feedback</button>
        </form>

        <!-- Display Error Messages -->
        @if($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Display Games -->
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
                        <th>Time Played</th>
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

        <!-- Display Feedback -->
        @if(isset($feedback))
            <br/><hr/><br/>
            <h3>Feedback for Game ID {{ request('player_id') }}</h3>
            <p>{{ $feedback }}</p>
        @endif

        <!-- Display Raw Response for Debugging -->
        @if(isset($response))
            <br/><hr/><br/>
            <h3>Raw SOAP Response</h3>
            <pre>{{ print_r($response, true) }}</pre>
        @endif
    </div>
    <footer>
        <p>&copy; seppe's schaak app</p>
    </footer>
</body>
</html>