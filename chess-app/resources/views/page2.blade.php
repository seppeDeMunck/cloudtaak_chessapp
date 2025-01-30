<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 2 - Competition</title>
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
        <h1>Chess App - Competition</h1>
    </header>
    <div class="container">
        <h2>Enter Players for Competition</h2>
        <form action="{{ route('page2') }}" method="GET">
            @csrf
            <input type="text" name="players" placeholder="Enter player names, separated by commas" required>
            <button type="submit">Generate Matchups</button>
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

        <!-- Display Rounds -->
        @if(isset($rounds) && count($rounds) > 0)
            @foreach($rounds as $round)
                <h2>Round {{ $round['round'] }}</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Player 1</th>
                            <th>Player 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($round['matches'] as $match)
                            <tr>
                                <td>{{ $match[0] }}</td>
                                <td>{{ $match[1] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @elseif(isset($players))
            <p>No rounds found for players: {{ $players }}</p>
        @endif
    </div>
    <footer>
        <p>&copy; seppe's schaak app</p>
    </footer>
</body>
</html>