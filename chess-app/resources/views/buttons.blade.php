<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buttons</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .button-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: flex-start;
        }

        .button-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .button-item button {
            flex-shrink: 0;
        }

        .button-item p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Chess App</h1>
    </header>
    <div class="container">
        <div class="button-container">
            <div class="button-item">
                <a href="{{ route('page1') }}"><button>Page 1</button></a>
                <p>match history</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page2') }}"><button>Page 2</button></a>
                <p>competition setup</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page3') }}"><button>Page 3</button></a>
                <p>game feedback</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page4') }}"><button>Page 4</button></a>
                <p>winchance calculator</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page5') }}"><button>Page 5</button></a>
                <p>chess wiki</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page6') }}"><button>Page 6</button></a>
                <p>board evaluation</p>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; seppe's schaak app</p>
    </footer>
</body>
</html>