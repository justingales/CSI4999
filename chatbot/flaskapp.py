from flask import Flask, render_template, request
from openai import OpenAI
import time

app = Flask(__name__)
# OpenAI secret API key
client = OpenAI(api_key="key")
# OpenAI Assistant ID
assistant = client.beta.assistants.retrieve(assistant_id="id")

thread_id = None
last_timestamp = 0

def send_message_and_start_run(content):
    global thread_id
    global last_timestamp

    message = client.beta.threads.messages.create(
        thread_id=thread_id,
        role="user",
        content=content
    )

    run = client.beta.threads.runs.create(
        thread_id=thread_id,
        assistant_id=assistant.id,
    )

    return run

# Function to fetch responses
def fetch_responses_from_thread():
    global last_timestamp
    global thread_id

    responses = []
    try:
        messages = client.beta.threads.messages.list(thread_id=thread_id)
        for message in messages:
            if message.role == 'assistant' and message.created_at > last_timestamp:
                responses.append(message.content)
                last_timestamp = message.created_at
    except Exception as e:
        print("Failed to fetch messages:", e)

    return responses


def fetch_run_results(run_id):
    global thread_id

    while True:
        run = client.beta.threads.runs.retrieve(thread_id=thread_id, run_id=run_id)
        if run.status == 'completed':
            messages = client.beta.threads.messages.list(thread_id=thread_id)
            run_messages = [message for message in messages if message.run_id == run_id]
            return run_messages
        time.sleep(0.5) # Wait time before checking

# Route for the chatbot page
@app.route("/")
def index():
    return render_template("chatbot.html")

# Route for sending messages
@app.route("/send_message", methods=["POST"])
def send_message():
    global thread_id

    user_input = request.form["user_input"]
    if user_input.lower() == 'quit':
        return "Exiting chat..."

    run = send_message_and_start_run(user_input)
    messages = fetch_run_results(run.id)
    assistant_response = ""
    for message in messages:
        if message.role == 'assistant':
            assistant_response = message.content[0].text.value

    return assistant_response # Return's chatbot response


if __name__ == "__main__":
    # Create a new thread for the chat
    thread = client.beta.threads.create()
    thread_id = thread.id

    # Run the Flask app
    app.run(debug=True)