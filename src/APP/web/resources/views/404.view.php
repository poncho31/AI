<?php

use GillesPinchart\Ai\constructors\Html\Html;
use GillesPinchart\Ai\constructors\Html\HtmlImage;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        .illustration {
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 3em;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">

    <img class="illustration" src="<?php HtmlImage::add("404.png"); ?>" alt="Page Not Found Illustration">
    <h1>404 - Page Not Found</h1>
    <p>Oops! Looks like you're lost. Let's get you back on track.</p>
    <a href="/">Go to the Home Page</a>
</div>
</body>
</html>
