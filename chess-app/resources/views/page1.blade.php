<!DOCTYPE html>
<html>
<head>
    <title>Games</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
            word-break: break-all; /* Ensure long words break within the cell */
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .moves-column {
            width: 400px; /* Adjust the width as needed */
        }
        .form-container {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group button {
            padding: 10px 15px;
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div style="color: green; text-align: center; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <h1>Games</h1>
        <table>
            <thead>
                <tr>
                    <th>Black</th>
                    <th>White</th>
                    <th>Winner</th>
                    <th class="moves-column">Moves</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($games as $game)
                    <tr>
                        <td>{{ $game->black }}</td>
                        <td>{{ $game->white }}</td>
                        <td>{{ $game->winner }}</td>
                        <td class="moves-column">{{ $game->moves }}</td>
                        <td>{{ $game->created_at }}</td>
                        <td>{{ $game->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="form-container">
            <h2>Add a New Game</h2>
            <form action="{{ route('games.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="black">Black Player</label>
                    <input type="text" id="black" name="black" required>
                </div>
                <div class="form-group">
                    <label for="white">White Player</label>
                    <input type="text" id="white" name="white" required>
                </div>
                <div class="form-group">
                    <label for="winner">Winner</label>
                    <input type="text" id="winner" name="winner" required>
                </div>
                <div class="form-group">
                    <label for="moves">Moves</label>
                    <textarea id="moves" name="moves" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Add Game</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>