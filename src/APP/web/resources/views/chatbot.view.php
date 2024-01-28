<?php

use GillesPinchart\Ai\constructors\Html\Html;

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
            <div id="sse-data">

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

    <script>
        const eventSource = new EventSource("http://localhost:666/ai/api/mistral");

        eventSource.onmessage = function(event) {
            // Manipulation des données reçues
            const data = event.data;
            console.log(data);

            // Vous pouvez mettre à jour le DOM avec les données
            // Exemple : document.getElementById('myElement').textContent = data;
        };

        eventSource.onerror = function(error) {
            console.error("Erreur SSE :", error);
        };

        eventSource.onopen = function(event) {
            console.log("Connexion SSE établie");
        };

        eventSource.addEventListener('end', function(event) {
            // Événement personnalisé pour indiquer la fin du flux
            console.log("Fin du flux SSE");
            eventSource.close(); // Fermer la connexion SSE
        });

    </script>

<?php Html::end("base"); ?>