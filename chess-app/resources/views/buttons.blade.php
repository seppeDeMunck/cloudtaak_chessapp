<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buttons</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .button-container {
            text-align: center;
        }

        .button-container a {
            margin: 10px;
            display: inline-block;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 32px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <a href="/page1"><button>Filler1</button></a>
        <a href="/page2"><button>Filler2</button></a>
        <a href="/page3"><button>Filler3</button></a>
        <a href="/page4"><button>Filler4</button></a>
        <a href="/page5"><button>Filler5</button></a>
    </div>
</body>
</html>
