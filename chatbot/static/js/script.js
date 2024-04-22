const form = document.getElementById('message-form');
const chatBox = document.getElementById('chat-box');

// Function to send a message
async function sendMessage(message) {
    const response = await fetch('/send_message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            user_input: message
        })
    });
    return response.text();
}

// Function to add a message to the chat
function addMessage(role, content) {
    if (content.trim() !== '') {
        const messageElement = document.createElement('div');
        messageElement.textContent = `${role}: ${content}`;
        chatBox.appendChild(messageElement);

        // Add a blank line separator
        const separatorElement = document.createElement('div');
        separatorElement.className = 'message-separator'; // Add a class for styling
        chatBox.appendChild(separatorElement);
    }
}

// Event listener for form submission
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const userInput = document.getElementById('user-input').value;
    const response = await sendMessage(userInput);
    addMessage('You', userInput);
    addMessage('MendMate', response);
    document.getElementById('user-input').value = '';
    // Scroll chat box to bottom
    chatBox.scrollTop = chatBox.scrollHeight;
});

// Send the first message when the page loads
window.addEventListener('load', async () => {
    const initialMessage = "Hello and welcome! I'm MendMate your personal health companion. I'm here to offer you a safe space to explore your feelings, provide support, and connect you with resources to help you feel better. Whether you're just looking for someone to talk to, tips on managing your mental health, or just some resources, I'm here for you. How can I assist you today?";
    const response = await sendMessage(initialMessage);
    addMessage('MendMate', initialMessage);
});

document.querySelector('.quotechatButton').addEventListener('click', function () {
    fetchQuote();
});

async function fetchQuote() {
    try {
        const response = await fetch('/static/quotes.csv');
        const data = await response.text();
        const quotesArray = parseCSV(data);
        const randomIndex = Math.floor(Math.random() * quotesArray.length);
        const quote = quotesArray[randomIndex];
        appendToChat(`${quote[1]} - ${quote[0]}`);
    } catch (error) {
        console.error('Error fetching quote:', error);
    }
}

function parseCSV(csv) {
    const lines = csv.split('\n');
    const quotesArray = [];
    for (let i = 0; i < lines.length; i++) {
        const parts = lines[i].split(',');
        if (parts.length >= 2) {
            quotesArray.push([parts[0], parts.slice(1).join(',')]);
        }
    }
    return quotesArray;
}

function appendToChat(message) {
    const messageElement = document.createElement('div');
    messageElement.textContent = message;
    chatBox.appendChild(messageElement);
}


//Generates random number for how much to shift input string
function getRandomInt(min, max) {
    const minimum = Math.ceil(min);
    const maximum = Math.floor(max);
    return Math.floor(Math.random() * (maximum - minimum) + minimum);
}

//function to encrypt input string
function encryptMsg(str, shift) {
    let encreptedStr = " ";

    for (let i = 0; i < str.length; i++) {
        let charCode = str.charCodeAt(i);

        if (charCode >= 65 && charCode <= 90) {
            // uppercase letters
            encreptedStr += String.fromCharCode(
                ((charCode - 65 + shift) % 26) + 65
            );
        } else if (charCode >= 97 && charCode <= 122) {
            // lowercase letters
            encreptedStr += String.fromCharCode(
                ((charCode - 97 + shift) % 26) + 97
            );
        } else {
            // non-alphabetic characters
            encreptedStr += str.charAt(i);
        }
    }
    return encreptedStr;
}

//encrypted input that will go into a database
const encryptedMessage = encryptMsg(
    messageInput.value.trim(),
    getRandomInt(2, 24)
);
