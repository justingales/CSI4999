from openai import OpenAI
import time


def send_message_and_start_run(client, assistant_id, content, thread_id):
    message = client.beta.threads.messages.create(
        thread_id=thread_id,
        role="user",
        content=content
    )

    run = client.beta.threads.runs.create(
        thread_id=thread_id,
        assistant_id=assistant_id,
    )
    return run


def fetch_responses_from_thread(client, thread_id, last_timestamp=0):
    """Fetches all new messages from the assistant in a thread since last_timestamp."""
    responses = []
    try:
        
        messages = client.beta.threads.messages.list(thread_id=thread_id)
        for message in messages:
            
            if message.role == 'assistant' and message.created_at > last_timestamp:
                responses.append(message.content)
                last_timestamp = message.created_at
    except Exception as e:
        print("Failed to fetch messages:", e)

    return responses, last_timestamp


def fetch_run_results(client, thread_id, run_id):
    """Continuously fetches the results of a run until it is completed and retrieves associated messages."""
    while True:
        
        run = client.beta.threads.runs.retrieve(thread_id=thread_id, run_id=run_id)
        if run.status == 'completed':
            
            messages = client.beta.threads.messages.list(thread_id=thread_id)
            
            run_messages = [message for message in messages if message.run_id == run_id]
            return run_messages
        time.sleep(1)  

def interact_with_assistant(client, assistant_id, thread_id):
    print("You can start chatting with the assistant. Type 'quit' to exit.")
    while True:
        user_input = input("You: ")
        if user_input.lower() == 'quit':
            print("Exiting chat...")
            break

        
        run = send_message_and_start_run(client, assistant_id, user_input, thread_id)
        print("Waiting for the assistant's response...")

        
        messages = fetch_run_results(client, thread_id, run.id)
        for message in messages:
            if message.role == 'assistant':
                print(f"Assistant: {message.content[0].text.value}")


def start_chat():
    client = OpenAI(api_key="key")
    thread = client.beta.threads.create()
    assistant = client.beta.assistants.retrieve(assistant_id="assistant")

    print("Chat session started. Type 'quit' to exit.")

    interact_with_assistant(client, assistant.id, thread.id)


start_chat()
