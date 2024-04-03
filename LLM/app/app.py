# Lana Forfutdinov
# LLM Service Wrapper
import json
import logging

from flask import Flask, request, jsonify
import requests
from flask_cors import CORS

app = Flask(__name__)

# Hugging Face API
# API_URL = "https://api-inference.huggingface.co/models/nlp4good/psych-search"
API_URL = "https://api-inference.huggingface.co/models/GRMenon/mental-health-mistral-7b-instructv0.2-finetuned-V2"
API_TOKEN = "Bearer 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"
headers = {"Authorization": f"Bearer {API_TOKEN}"}
CORS(app, resources={r"/query": {"origins": "*"}})

@app.route('/query', methods=['POST'])
def query_proxy():

    try:
        data = request.get_json()
        logging.debug(f"Incoming JSON: {data}")
        response = requests.post(API_URL, headers=headers, json=data)
        # Return the Hugging Face API

        if response.status_code == 200:
            return jsonify({
                'statusCode': 200,
                'headers': {
                    'Access-Control-Allow-Origin': '*'
                },
                'body': json.dumps(response.json())
                })
              #  'body': json.dumps({
              #      'message': response.json()
              #  })
          #  })

        elif response.status_code == 400:
            # TODO:
            logging.error("Model is not available, using mocking data")
            user_input = data['inputs']

            if 'sad' in user_input:
                answer = "Tell me why you feel this way..."

            else:
                answer = "What can I do for you?"

            return jsonify({
                'statusCode': 200,
                'headers': {
                    'Access-Control-Allow-Origin': '*'
                },
                'body': json.dumps({
                    'message': answer
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
