# Lana Forfutdinov
# LLM Service Wrapper

from flask import Flask, request, jsonify
import requests

# Initialize Flask app
app = Flask(__name__)

# Hugging Face API
API_URL = "https://api-inference.huggingface.co/models/nlp4good/psych-search"
API_TOKEN = "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"
headers = {"Authorization": f"Bearer {API_TOKEN}"}

@app.route('/query', methods=['POST'])
def query_proxy():
    """
    request to the Hugging Face API and returns the API's response.
    """
    try:
        data = request.get_json()
        response = requests.post(API_URL, headers=headers, json=data)
        # Return the Hugging Face API

        return jsonify(response.json()), response.status_code
    except Exception as e:

        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    # Run the Flask app
    app.run(debug=True, host='0.0.0.0', port=5000)
