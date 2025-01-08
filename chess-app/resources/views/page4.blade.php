<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 4</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header>
        <h1>Chess App</h1>
    </header>
    <div class="container">
        <h2>Calculate Win Chance</h2>
        <form action="{{ route('calculate.win.chance') }}" method="POST">
            @csrf
            <input type="text" name="player1" placeholder="Enter first player name" required>
            <input type="text" name="player2" placeholder="Enter second player name" required>
            <button type="submit">Calculate Win Chance</button>
        </form>
        @if(isset($winChance))
            <h2>Win Chance Results</h2>
            <p>{{ $player1 }} win chance: {{ $winChance['player1'] }}%</p>
            <p>{{ $player2 }} win chance: {{ $winChance['player2'] }}%</p>
        @endif
    </div>
    <footer>
        <p>&copy; 2023 Chess App</p>
    </footer>
</body>
</html>