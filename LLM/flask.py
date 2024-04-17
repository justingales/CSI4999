from flask import Flask, request, jsonify
from model import send_message_and_start_run, fetch_run_results
import openai

app = Flask(__name__)
client = openai.OpenAI(api_key="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")

@app.route('/send', methods=['POST'])
def send_message():
    content = request.json['message']
    thread_id = request.json['thread_id']  # Thread ID  per user session
    assistant_id = "asst_d0nr4Yn8IRN4PsNa6STno8ks"
    run = send_message_and_start_run(client, assistant_id, content, thread_id)
    return jsonify({"run_id": run.id})

@app.route('/response', methods=['GET'])
def get_response():
    thread_id = request.args.get('thread_id')
    run_id = request.args.get('run_id')
    messages = fetch_run_results(client, thread_id, run_id)
    return jsonify({"messages": [msg.content for msg in messages if msg.role == 'assistant']})

if __name__ == '__main__':
    app.run(debug=True)
