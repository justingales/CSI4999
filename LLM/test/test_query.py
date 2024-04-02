# Lana Forfutdinov
# LLM Service Wrapper

from unittest.mock import patch
from flask_testing import TestCase
from app import app  

class TestMentalHealthChatbot(TestCase):
    def create_app(self):
        # Configure the Flask app for testing
        app.config['Testing'] = True
        return app

    # Test case for a general mental health inquiry
    @patch('requests.post')
    def test_general_inquiry(self, mock_post):
        # Mocking a response for a general inquiry
        mock_response = {
            "generated_text": "It sounds like you're going through a tough time. Would you like to talk more about it?"
        }
        mock_post.return_value.json.return_value = mock_response
        mock_post.return_value.status_code = 200

        response = self.client.post('/api/query', json={"inputs": "I've been feeling down lately"})
        self.assertEqual(response.status_code, 200)
        self.assertIn("Would you like to talk more about it?", response.json['generated_text'])

    # Test case for specific symptoms or concerns
    @patch('requests.post')
    def test_specific_concern(self, mock_post):
        # Mocking a response for a specific concern
        mock_response = {
            "generated_text": "It sounds like you might be experiencing symptoms of anxiety. Have you felt this way before?"
        }
        mock_post.return_value.json.return_value = mock_response
        mock_post.return_value.status_code = 200

        response = self.client.post('/api/query', json={"inputs": "I feel anxious all the time and can't seem to relax."})
        self.assertEqual(response.status_code, 200)
        self.assertIn("symptoms of anxiety", response.json['generated_text'])

    # Test case for detecting urgency or a crisis
    @patch('requests.post')
    def test_urgency_detection(self, mock_post):
        # Mocking a response for an urgent help request
        mock_response = {
            "generated_text": "It seems like you're in need of immediate support. It's important to reach out to someone you can trust or a professional."
        }
        mock_post.return_value.json.return_value = mock_response
        mock_post.return_value.status_code = 200

        response = self.client.post('/api/query', json={"inputs": "I can't handle this anymore. I don't know what to do."})
        self.assertEqual(response.status_code, 200)
        self.assertIn("immediate support", response.json['generated_text'])

if __name__ == '__main__':
    import unittest
    unittest.main()
