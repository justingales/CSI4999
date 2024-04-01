document.addEventListener("DOMContentLoaded", function() {
    const messages = document.getElementById('messages');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');

sendButton.addEventListener('click', function() {
    const message = messageInput.value.trim();
    if (message !== '') {
        // Create list item to show the message
        const li = document.createElement('li');
        li.textContent = 'You: ' + message;
        messages.appendChild(li);
        messages.scrollTop = messages.scrollHeight;

        // Prepare the payload to send in the POST request
        const payload = {
            inputs: message
        };

        // Make a POST request to the server
        fetch('http://127.0.0.1:5000/query', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Access-Control-Allow-Origin': '*'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json()) // Assuming the server responds with JSON
        .then(data => {
            console.log('Success:', data);
            // Handle the server's response here
            // E.g., add another list item to display the server's response
            const serverResponseLi = document.createElement('li');

            //TODO: Fix this code parsing of the answer
            serverResponseLi.textContent = 'Server: ' + data.body; // Adjust depending on the actual response structure
            messages.appendChild(serverResponseLi);
            messages.scrollTop = messages.scrollHeight;
        })
        .catch((error) => {
            console.error('Error:', error);
            // Handle any errors here, such as displaying an error message to the user
        });

        // Clear the input box
        messageInput.value = '';
    }
});

    messageInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            sendButton.click();
        }
    });
});