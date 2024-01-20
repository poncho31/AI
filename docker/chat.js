$(document).ready(function() {
    const chatContainer = $('#chat');
    const messageInput = $('#messageInput');
    const sendButton = $('#sendButton');

    function getChatMessage() {
        $.get('/api/ollama-chat.php', data => {
            chatContainer.html(data);
        });
    }

    function sendChatMessage(message) {
        $.post('/api/ollama-chat.php', JSON.stringify({ message }), () =>
            getChatMessage());
    }

    function startChat() {
        setInterval(() => getChatMessage(), 1000); // Refresh chat every
        second
    }

    sendButton.click(() => sendChatMessage(messageInput.val()));
    messageInput.on('keyup', e => {
        if (e.which === 13) {
            sendChatMessage(messageInput.val());
        }
    });

    startChat();
});