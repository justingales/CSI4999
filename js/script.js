document.addEventListener("DOMContentLoaded", function() {
    const messages = document.getElementById('messages');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');

    sendButton.addEventListener('click', function() {
        const message = messageInput.value.trim();
        if (message !== '') {
            const li = document.createElement('li');
            li.textContent = 'You: ' + message;
            messages.appendChild(li);
            messages.scrollTop = messages.scrollHeight;
            messageInput.value = '';
        }
    });

    messageInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            sendButton.click();
        }
    });
});