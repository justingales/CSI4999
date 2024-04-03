document.querySelector('.quotechatButton').addEventListener('click', function() {
  fetchQuote();
});

async function fetchQuote() {
  try {
    const response = await fetch('quotes.csv');
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
  const outputBox = document.getElementById('message-output');
  outputBox.value += (outputBox.value === '' ? '' : '\n') + message;
}

document.addEventListener("DOMContentLoaded", function() {
    const outputBox = document.getElementById('message-output');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-output');

    sendButton.addEventListener('click', function() {
        sendMessage();
    });

    messageInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });

    function sendMessage() {
        const message = messageInput.value.trim();
        if (message !== '') {
            outputBox.value += (outputBox.value === "" ? "" : "\n") + "You: " + message;
            messageInput.value = '';
        }
    }
});

