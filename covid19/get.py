import requests

from json.decoder import JSONDecodeError
from .config import Config

class Req(Config):
    def __init__(self):
        pass

    def get_prefectures(self):
        res = requests.get(
            self.prefectures_url
        ).json()
        return res

    def get_total(self):
        res = requests.get(
            self.total_url
        ).json()
        return res

    def get_history(self):
        res = requests.get(
            self.total_url,
            {'history': 'true'}
        ).json()
        return res

    def get_predict(self):
        res = requests.get(
            self.total_url,
            {'predict': 'true'}
        ).json()
        return res

    def get_positives(self, pref):
        res = requests.get(
            self.positives_url,
            {'prefecture': pref}
        )
        try:
            res = res.json()
        except JSONDecodeError:
            res = {}
        return res

    def get_statistics(self):
        res = requests.get(
            self.statistics_url
        ).json()
        return res
