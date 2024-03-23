# Lana Forfutdinov
# LLM Service Wrapper

from unittest.mock import patch
from flask_testing import TestCase as FlaskTestCase
from app.app import app


class TestFlaskApi(FlaskTestCase):
    def create_app(self):
        app.config['TESTING'] = True
        return app

    @patch('app.main.requests.post')
    def test_query_proxy_success(self, mock_post):
        # test response
        mock_post.return_value.json.return_value = {"result": "success"}
        mock_post.return_value.status_code = 200

        response = self.client.post('/query', json={"inputs": "test"})
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.json, {"result": "success"})

    @patch('app.main.requests.post')
    def test_query_proxy_failure(self, mock_post):
        # test response for failure
        mock_post.return_value.json.return_value = {"error": "bad request"}
        mock_post.return_value.status_code = 400

        response = self.client.post('/query', json={"inputs": "test"})
        self.assertEqual(response.status_code, 400)
        self.assertEqual(response.json, {"error": "bad request"})

    @patch('app.main.requests.post')
    def test_query_proxy_exception(self, mock_post):
        # test exception
        mock_post.side_effect = Exception("An error occurred")

        response = self.client.post('/query', json={"inputs": "test"})
        self.assertEqual(response.status_code, 500)
        self.assertIn("error", response.json)

    def test_query_proxy_functionality(self):
        # client's request to the Flask app
        mock_payload = {"inputs": "The answer to the universe is [MASK]."}
        response = self.client.post('/query', json=mock_payload)
        self.assertEqual(response.status_code, 200)
        print(response.json[0]["sequence"])

    def test_paris_query_proxy_functionality(self):
        # client's request to the Flask app
        mock_payload = {"inputs": "Paris is the [MASK] of France.."}
        response = self.client.post('/query', json=mock_payload)
        self.assertEqual(response.status_code, 200)
        print(response.json[0]["sequence"])

    def test_feeling_anxious_query(self):
        # Simulates a user expressing feelings of anxiety
        mock_payload = {"inputs": "I've been feeling really [MASK] lately."}
        response = self.client.post('/query', json=mock_payload)
        self.assertEqual(response.status_code, 200)
        self.assertEqual("i've been feeling really really lately.",response.json[0]["sequence"])

    def test_looking_for_support_query(self):
        # Simulates a user looking for support
        mock_payload = {"inputs": "What can I do when I feel [MASK]?"}
        response = self.client.post('/query', json=mock_payload)
        self.assertEqual(response.status_code, 200)
        self.assertEqual("what can i do when i feel sad?",response.json[0]["sequence"])

    def test_coping_strategies_query(self):
        # Simulates a user asking about coping strategies
        mock_payload = {"inputs": "Can you suggest any coping strategies for [MASK]?"}
        response = self.client.post('/query', json=mock_payload)
        self.assertEqual(response.status_code, 200)
        self.assertEqual("can you suggest any coping strategies for depression?",response.json[0]["sequence"])

    def test_experiencing_symptoms_query(self):
        # Simulates a user discussing symptoms
        mock_payload = {"inputs": "Lately, I've been experiencing symptoms of [MASK]."}
        response = self.client.post('/query', json=mock_payload)
        self.assertEqual(response.status_code, 200)
        self.assertEqual("lately, i've been experiencing symptoms of depression.",response.json[0]["sequence"])

    def test_seeking_advice_query(self):
        # Simulates a user seeking advice
        mock_payload = {"inputs": "How should I deal with my feelings of [MASK]?"}
        response = self.client.post('/query', json=mock_payload)
        self.assertEqual(response.status_code, 200)
        self.assertEqual("how should i deal with my feelings of self?",response.json[0]["sequence"])

    def test_mental_health_resources_query(self):
        # Simulates a user asking for mental health resources
        mock_payload = {"inputs": "Are there any resources you recommend for someone dealing with [MASK]?"}
        response = self.client.post('/query', json=mock_payload)
        self.assertEqual(response.status_code, 200)
        self.assertEqual("are there any resources you recommend for someone dealing with diabetes?",response.json[0]["sequence"])


if __name__ == '__main__':
    import unittest

    unittest.main()
