# Lana Forfutdinov
# LLM Service Wrapper
import json
import logging

from flask import Flask, request, jsonify
import requests
from flask_cors import CORS

app = Flask(__name__)

# Hugging Face API
API_URL = "https://api-inference.huggingface.co/models/GRMenon/mental-health-mistral-7b-instructv0.2-finetuned-V2"
API_TOKEN = "Bearer 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"
headers = {"Authorization": f"Bearer {API_TOKEN}"}
CORS(app, resources={r"/query": {"origins": "*"}})

@app.route('/query', methods=['POST'])
def query_proxy():
    """
    request to the Hugging Face API and returns the API's response.
    """
    try:
        data = request.get_json()
        logging.debug(f"Incodming JSON: {data}")
        response = requests.post(API_URL, headers=headers, json=data)
        # Return the Hugging Face API

        return jsonify({
            'statusCode': 200,
            'headers': {
                'Access-Control-Allow-Origin': '*'
            },
            'body': json.dumps({
                'message': response.json()
            })
        })
    except Exception as e:

        return jsonify({
            'statusCode': 500,
            'headers': {
                'Access-Control-Allow-Origin': '*'
            },
            'body': json.dumps({
                'error': str(e)
            })
        })


if __name__ == '__main__':
    # Run the Flask app
    app.run(debug=True, host='0.0.0.0', port=5000)
