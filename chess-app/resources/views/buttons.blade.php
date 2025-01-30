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

        /* Use a grid for each row: left column for button, right column for explanation */
        .button-item {
            display: grid;
            grid-template-columns: 200px 1fr; /* adjust first column width as desired */
            align-items: center;
            gap: 10px;
        }
        .button-item a button {
            width: 100%; /* make button take full width in the first column */
            text-align: center; /* center-align the button text horizontally */
            padding: 10px; /* add padding for better vertical alignment */
            box-sizing: border-box; /* ensure padding is included in the width */
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
                <a href="{{ route('page1') }}"><button>match history</button></a>
                <p>look up someone's match history</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page2') }}"><button>competition generator</button></a>
                <p>generates swiss tournament for a given group</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page3') }}"><button>game feedback</button></a>
                <p>generates feedback on a game in your match history</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page4') }}"><button>winchance calculator</button></a>
                <p>calculates winchance between 2 players</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page5') }}"><button>chess wiki</button></a>
                <p>learning more about how to play chess</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page6') }}"><button>board evaluation</button></a>
                <p>tells you who is winning when you provide the board</p>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; seppe's schaak app</p>
    </footer>
</body>
</html>