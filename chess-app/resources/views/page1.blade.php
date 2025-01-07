<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess App</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header>
        <h1>Chess App</h1>
    </header>
    <div class="container">
        <form action="{{ route('games.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="black">Black Player</label>
                <input type="text" id="black" name="black" required placeholder="Enter black player">
            </div>
            <div class="form-group">
                <label for="white">White Player</label>
                <input type="text" id="white" name="white" required placeholder="Enter white player">
            </div>
            <div class="form-group">
                <label for="winner">Winner</label>
                <input type="text" id="winner" name="winner" required placeholder="Enter winner">
            </div>
            <div class="form-group">
                <label for="moves">Moves</label>
                <textarea id="moves" name="moves" rows="4" required placeholder="Enter moves"></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Add Game</button>
            </div>
        </form>

        <h2>Games List</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Black Player</th>
                        <th>White Player</th>
                        <th>Winner</th>
                        <th>Moves</th>
                        <th>Played At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($games as $game)
                        <tr>
                            <td>{{ $game->black }}</td>
                            <td>{{ $game->white }}</td>
                            <td>{{ $game->winner }}</td>
                            <td>{{ $game->moves }}</td>
                            <td>{{ $game->created_at ? \Carbon\Carbon::parse($game->created_at)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <footer>
        <p>&copy; 2023 Chess App</p>
    </footer>
</body>
</html>