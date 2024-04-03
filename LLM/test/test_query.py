# Lana Forfutdinov
# LLM Service Wrapper

import unittest
from flask_testing import TestCase

from app.app import app

class TestMentalHealthChatbot(unittest.TestCase):
    def setUp(self):
        app.config['TESTING'] = True
        self.client = app.test_client()

    # Test case for a general mental health inquiry
    def test_general_inquiry(self):
        # Mocking a response for a general inquiry

        response = self.client.post('/query', json={"inputs": "I've been feeling down lately"})
        self.assertEqual(200, response.status_code)
        self.assertIn("Would you like to talk more about it?", response.json['generated_text'])


if __name__ == '_main_':
    import unittest
    unittest.main()
