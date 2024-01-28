<?php

namespace GillesPinchart\Ai\constructors\Javascript;

class Javascript
{
    public static function base(): string
    {
        return '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
    }

    public static function chat(): string
    {
        $js = <<<JS
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
                            })
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
                                messageDiv.innerHTML = `<p>zdzdzd</p>`;
                                chat.appendChild(messageDiv);
                
                                // Faites défiler automatiquement la conversation vers le bas pour afficher les nouveaux messages
                                chat.scrollTop = chat.scrollHeight;
                            }
                
                            function displayError(error) {
                                output.innerHTML = `<p style="color: red;">Error: zdzdzd</p>`;
                            }
                        });
                    </script>
        JS;
        return $js;
    }

    public static function sse(): string
    {
        $js = <<<JS
           
        JS;
        return $js;

    }
}