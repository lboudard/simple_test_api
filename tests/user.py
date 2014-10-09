# -*- coding: utf-8 -*-
import json
import requests
import unittest


class TestUserApi(unittest.TestCase):
    '''
    A simple class to functional test user songs api
    '''

    def create_user(self):
        r = requests.post('http://localhost:8080/user',
                            data={'name' : 'api_test', 'email': 'unittest@test.com'})
        return r.json()

    # TODO proper setup and teardown with features
    def test_001_get_user_list(self):
        r = requests.get('http://localhost:8080/user')
        self.assertEquals([{"name":"spongebob","email":"spongebob@bikinibottom.com"},
                {"name":"patrick","email":"patrick@bikinibottom.com"},
                {"name":"plankt","email":"plankt@bikinibottom.com"}],
                [{k: v for k, v in user.iteritems() if k not in ['user_id']}
                for user in r.json()])

    def test_002_create_get_delete_user(self):
        data = self.create_user()
        self.assertIn('user_id', data)
        r2 = requests.get('http://localhost:8080/user/' + data['user_id'])
        self.assertEquals(r2.json(),
                            {'user_id': data['user_id'], 'name': 'api_test', 'email': 'unittest@test.com'})
        r3 = requests.delete('http://localhost:8080/user/' + data['user_id'])
        self.assertEquals(r3.json(), True)

    def test_003_user_get_add_remove_songs(self):
        data = self.create_user()
        r1 = requests.post('http://localhost:8080/user/' + data['user_id'] + '/songs', data={'song_id': 31})
        r2 = requests.post('http://localhost:8080/user/' + data['user_id'] + '/songs', data={'song_id': 32})
        self.assertEquals(r1.json(), '31')
        self.assertEquals(r2.json(), '32')
        r3 = requests.get('http://localhost:8080/user/' + data['user_id'] + '/songs')
        self.assertEquals(r3.json(), [{'album': '0', 'duration': '00:03:40', 'song_id': '31', 'title': 'prelude'},
                                        {'album': '0', 'duration': '00:02:30', 'song_id': '32', 'title': 'rondo'}])
        r4 = requests.delete('http://localhost:8080/user/' + data['user_id'] + '/songs/31')
        self.assertEquals(r4.json(), '31')
        r5 = requests.get('http://localhost:8080/user/' + data['user_id'] + '/songs')
        self.assertEquals(r5.json(), [{'album': '0', 'duration': '00:02:30', 'song_id': '32', 'title': 'rondo'}])
        r6 = requests.delete('http://localhost:8080/user/' + data['user_id'] + '/songs/32')
        self.assertEquals(r6.json(), '32')
        requests.delete('http://localhost:8080/user/' + data['user_id'])

if __name__ == '__main__':
    unittest.main()
