<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 3</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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
        @if(isset($games))
            <h2>Games for {{ $player }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Game ID</th>
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
            <p>No games found for {{ $player }}.</p>
        @endif

        <h2>Get Game Feedback</h2>
        <form action="{{ route('page3.getGameFeedback') }}" method="POST">
            @csrf
            <input type="number" name="game_id" placeholder="Enter game ID" required>
            <button type="submit">Get Feedback</button>
        </form>
        @if(session('feedback'))
            <h3>Game Feedback</h3>
            <pre>{{ print_r(session('feedback'), true) }}</pre>
        @endif
        @if($errors->any())
            <div class="errors">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <footer>
        <p>&copy; 2023 Chess App</p>
    </footer>
</body>
</html>