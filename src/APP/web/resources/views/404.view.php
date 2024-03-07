<?php

use php\ai\constructors\Html\Html;
use php\ai\constructors\Html\HtmlImage;

    Html::begin("error");
?>


<div class="container">

    <img class="illustration" src="<?php HtmlImage::add("404.png"); ?>" alt="Page Not Found Illustration">
    <h1>404 - Page Not Found</h1>
    <p>Oops! Looks like you're lost. Let's get you back on track.</p>
    <a href="/">Go to the Home Page</a>
</div>


<?php Html::end(); ?>