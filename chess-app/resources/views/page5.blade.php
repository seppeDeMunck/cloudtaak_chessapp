<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page 5</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>Chess App</h1>
    </header>
    <div class="container">
        <h2>Get Wiki Data</h2>
        <form id="wikiForm">
            @csrf
            <div>
                <label>
                    <input type="checkbox" name="dataType" value="opening"> Opening
                </label>
                <label>
                    <input type="checkbox" name="dataType" value="midgame"> Midgame
                </label>
                <label>
                    <input type="checkbox" name="dataType" value="endgame"> Endgame
                </label>
            </div>
            <button type="submit">Get Wiki Data</button>
        </form>
        <div id="result"></div>
    </div>
    <footer>
        <p>&copy; 2023 Chess App</p>
    </footer>

    <script>
        $(document).ready(function() {
            $('#wikiForm').on('submit', function(event) {
                event.preventDefault();
                var dataTypes = [];
                $('input[name="dataType"]:checked').each(function() {
                    dataTypes.push($(this).val());
                });

                if (dataTypes.length === 0) {
                    $('#result').html('<p>Please select at least one data type.</p>');
                    return;
                }

                var queryFields = dataTypes.join(' ');
                var query = `query { ${queryFields} }`;

                $.ajax({
                    url: '/api/get-wiki-data',
                    method: 'POST',
                    data: {
                        query: query,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Response:', response); // Log the response
                        var resultHtml = '';
                        if (dataTypes.includes('opening')) {
                            resultHtml += '<p><strong>Opening:</strong> ' + response.data.opening + '</p>';
                        }
                        if (dataTypes.includes('midgame')) {
                            resultHtml += '<p><strong>Midgame:</strong> ' + response.data.midgame + '</p>';
                        }
                        if (dataTypes.includes('endgame')) {
                            resultHtml += '<p><strong>Endgame:</strong> ' + response.data.endgame + '</p>';
                        }
                        $('#result').html(resultHtml);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                        console.log('Status:', status);
                        console.log('Response:', xhr.responseText);
                        $('#result').html('<p>An error occurred while fetching the data.</p>');
                    }
                });
            });
        });
    </script>
</body>
</html>