<!-- filepath: /c:/chessApp/cloudtaak_chessapp/chess-app/resources/views/page1.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 1</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* Optional: Additional styling for better table appearance */
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
        .success-message {
            color: green;
            margin-top: 20px;
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
        <form action="{{ route('page1') }}" method="GET">
            @csrf
            <input type="text" name="player" placeholder="Enter player name" required>
            <button type="submit">Search</button>
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

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($games) && count($games) > 0)
            <h2>Games for {{ $player }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th> <!-- Added ID Column -->
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
                            <td>{{ $game->id }}</td> <!-- Displaying ID -->
                            <td>{{ $game->black }}</td>
                            <td>{{ $game->white }}</td>
                            <td>{{ $game->winner }}</td>
                            <td>{{ $game->moves }}</td>
                            <td>{{ $game->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif(isset($player))
            <p>No games found for player: {{ $player }}</p>
        @endif

        <h2>Add New Game</h2>
        <form action="{{ route('page1.store') }}" method="POST">
            @csrf
            <input type="text" name="black" placeholder="Black player" required>
            <input type="text" name="white" placeholder="White player" required>
            <input type="text" name="winner" placeholder="Winner" required>
            <textarea name="moves" placeholder="Moves" required></textarea>
            <button type="submit">Add Game</button>
        </form>
    </div>
    <footer>
        <p>&copy; seppe's schaak app</p>
    </footer>
</body>
</html>