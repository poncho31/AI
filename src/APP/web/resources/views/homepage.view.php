



<?php

use GillesPinchart\Ai\constructors\Html\Html;
use GillesPinchart\Ai\constructors\Html\HtmlImage;

Html::begin("base");
?>


<div class="app-container">
    <div class="sidebar">
        <div class="title-bar">
            <h2>ChatGPT Messenger</h2>
        </div>
        <ul class="contact-list">
            <li class="contact">John Doe</li>
            <li class="contact">Jane Smith</li>
            <!-- Ajoutez plus de contacts ici -->
        </ul>
    </div>

    <div class="chat-container">
        <div class="title-bar">
            <h2>Chat with John Doe</h2>
        </div>
        <div class="chat">
            <div class="message received">
                <p>Hello! How can I help you today?</p>
            </div>
            <div class="message sent">
                <p>Hi! I have a question about ChatGPT.</p>
            </div>
            <!-- Plus de messages ici -->
        </div>

        <form id="message-form">
            <input type="text" id="user-input" placeholder="Type your message...">
            <button type="submit">Send</button>
        </form>

        <div id="output"></div>
    </div>
</div>


<?php Html::end(); ?>