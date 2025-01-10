<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 1</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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
        @if(isset($games))
            <h2>Games for {{ $player }}</h2>
            <table>
                <thead>
                    <tr>
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
                            <td>{{ $game->black }}</td>
                            <td>{{ $game->white }}</td>
                            <td>{{ $game->winner }}</td>
                            <td>{{ $game->moves }}</td>
                            <td>{{ $game->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif
    </div>
    <footer>
        <p>&copy; 2023 Chess App</p>
    </footer>
</body>
</html>