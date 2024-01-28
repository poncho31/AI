<?php

namespace GillesPinchart\Ai\constructors\Css;

class Css
{

    public  static  function base(): string
    {
        return "
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
        ";
    }
    public static function error404(): string
    {
        return "<style>
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
    </style>";
    }
}