<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fcfcfc; /* Couleur plus chaleureuse */
        }

        .app-container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto; /* Centrer le contenu */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            width: 200px;
            background-color: #333;
            color: #fff;
        }

        .title-bar, .contact-list {
            padding: 10px;
        }

        .contact-list {
            list-style-type: none;
            padding: 0;
        }

        .contact {
            margin: 5px 0;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .contact:hover {
            background-color: #555;
        }

        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
        }

        .title-bar {
            background-color: #4CAF50;
            color: #fff;
            width: 100%;
            text-align: center;
            padding: 10px;
        }

        .chat {
            background-color: #fff;
            border-radius: 8px;
            overflow-y: auto;
            max-width: 400px;
            width: 100%;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message {
            margin: 10px;
            padding: 10px;
            border-radius: 8px;
            max-width: 70%;
        }

        .received {
            background-color: #e0f2f1; /* Couleur plus douce pour les messages reçus */
            align-self: flex-start;
        }

        .sent {
            background-color: #0084ff;
            color: #fff;
            align-self: flex-end;
        }

        #message-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        #user-input {
            flex: 1;
            padding: 15px; /* Augmenter la taille du champ de saisie */
            margin-bottom: 15px; /* Espacement du bas */
            border: none;
            border-radius: 8px; /* Coins plus arrondis */
            max-width: 400px;
            width: 100%;
            font-size: 16px; /* Taille du texte */
        }

        #output {
            max-width: 400px;
            width: 100%;
            text-align: center;
            margin-bottom: 15px; /* Espacement du bas */
        }

        button {
            background-color: #0084ff;
            color: #fff;
            border: none;
            padding: 15px 20px; /* Augmenter la taille du bouton */
            cursor: pointer;
            border-radius: 8px;
            font-size: 16px; /* Taille du texte */
        }

        button:focus {
            outline: none;
        }

        input:focus {
            outline: none;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function makeApiRequest() {
            $.ajax({
                url: 'http://localhost:666/src/api/ollama_api.php',
                type: 'POST',
                dataType: 'json', // Attend une réponse JSON du serveur
                success: function (data) {
                    // Traitement des données reçues
                    console.log(data); // Afficher dans la console à titre de démo
                    // Faites ce que vous devez faire avec les données ici
                },
                error: function (error) {
                    console.error('Erreur lors de la requête AJAX:', error);
                }
            });
        }

        // Appeler la fonction pour effectuer la requête au chargement de la page, ou à un autre moment selon vos besoins
        $(document).ready(function () {
            makeApiRequest();
        });

        document.addEventListener('DOMContentLoaded', function () {
            const messageForm = document.getElementById('message-form');
            const userInput = document.getElementById('user-input');
            const chat = document.querySelector('.chat');
            const output = document.getElementById('output');

            messageForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const userMessage = userInput.value.trim();

                if (userMessage !== '') {
                    displayMessage('sent', userMessage);

                    try {
                        // Effectuer une requête vers l'API PHP
                        const response = await fetch('../src/api/ollama_api.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ message: userMessage }),
                        });

                        console.log(userMessage);
                        if (!response.ok) {
                            throw new Error('API request failed');
                        }

                        const responseData = await response;
                        console.log(responseData);

                        displayMessage('received', responseData.message);
                    } catch (error) {
                        displayError(error);
                    }
                }

                userInput.value = ''; // Réinitialise le champ de saisie après l'envoi du message
            });

            function displayMessage(type, text) {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message', type);
                messageDiv.innerHTML = `<p>${text}</p>`;
                chat.appendChild(messageDiv);

                // Faites défiler automatiquement la conversation vers le bas pour afficher les nouveaux messages
                chat.scrollTop = chat.scrollHeight;
            }

            function displayError(error) {
                output.innerHTML = `<p style="color: red;">Error: ${error.message}</p>`;
            }
        });
    </script>
    <title>ChatGPT Messenger</title>
</head>
<body>
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
</body>
</html>