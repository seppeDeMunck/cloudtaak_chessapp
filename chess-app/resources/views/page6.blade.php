<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyze Position</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>Chess App</h1>
    </header>
    <div class="container">
        <h2>Analyze Position</h2>
        <form id="analyzeForm">
            @csrf
            <div>
                <label for="fen">FEN:</label>
                <input type="text" id="fen" name="fen" placeholder="Enter FEN" required>
            </div>
            <button type="submit">Analyze</button>
        </form>
        <div id="result"></div>
    </div>
    <footer>
        <p>&copy; seppe's schaak app</p>
    </footer>

    <script>
        $(document).ready(function() {
            $('#analyzeForm').on('submit', function(event) {
                event.preventDefault();
                var fen = $('#fen').val();
                $.ajax({
                    url: '/api/analyze-position',
                    method: 'POST',
                    data: {
                        fen: fen,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Response:', response); // Log the response
                        var resultHtml = '<p><strong>Score:</strong> ' + response.score + '</p>';
                        $('#result').html(resultHtml);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                        console.log('Status:', status);
                        console.log('Response:', xhr.responseText);
                        $('#result').html('<p>An error occurred while analyzing the position.</p>');
                    }
                });
            });
        });
    </script>
</body>
</html>