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
                <a href="/page1"><button>Filler1</button></a>
                <p>Explanation for Filler1</p>
            </div>
            <div class="button-item">
                <a href="/page2"><button>Filler2</button></a>
                <p>Explanation for Filler2</p>
            </div>
            <div class="button-item">
                <a href="/page3"><button>Filler3</button></a>
                <p>Explanation for Filler3</p>
            </div>
            <div class="button-item">
                <a href="{{ route('page4') }}"><button>Filler4</button></a>
                <p>Explanation for Filler4</p>
            </div>
            <div class="button-item">
                <a href="/page5"><button>Filler5</button></a>
                <p>Explanation for Filler5</p>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2023 Chess App</p>
    </footer>
</body>
</html>