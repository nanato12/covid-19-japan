from .get import Req

class COVID19():
    def __init__(self):
        self.req = Req()

    def get_prefectures_data(self, pref_name=None):
        """
            都道府県別の統計データを取得
        """
        data = {}
        for pref in self.req.get_prefectures():
            data[pref['name_ja']] = {'id': pref['id']}
            for item in ['cases', 'deaths', 'pcr']:
                data[pref['name_ja']][item] = {
                    'count': pref[item],
                    'last_updated': pref['last_updated'][f'{item}_date']
                }
        if pref_name:
            if pref_name in data:
                data = data[pref_name]
            else:
                data = {}
        return data

    def get_total_data(self):
        """
            日本全体での統計データを取得
        """
        return self.req.get_total()

    def get_history_data(self, date=None):
        """
            今までの日付別統計データを取得
            dateはYYYYmmddで指定
        """
        data = self.req.get_history()
        if date:
            data2 = {}
            for item in data:
                if str(item['date']) == date:
                    data2 = item
            if data2:
                data = data2
            else:
                data = {}
        return data

    def get_predict_data(self, date=None):
        """
            機械学習により今後30日間の日付別予測データを取得
            dateはYYYYmmddで指定
        """
        data = self.req.get_predict()
        if date:
            data2 = {}
            for item in data:
                if str(item['date']) == date:
                    data2 = item
            if data2:
                data = data2
            else:
                data = {}
        return data

    def get_positives_data(self, pref):
        """
            都道府県を指定して感染者データを取得
            prefは日本語名  例: 東京
        """
        if pref == '東京':
            pref += '都'
        elif pref in ['大阪', '京都']:
            pref += '府'
        else:
            pref += '県'
        return self.req.get_positives(pref)

    def get_positives_count_last_days(self, pref, days=0):
        """
            都道府県を指定して感染者数データを取得
            prefは日本語名  例: 東京
        """
        data = {}
        for item in self.get_positives_data(pref):
            announce_date = item['announcement_date']
            if announce_date not in data:
                data[announce_date] = 0
            data[announce_date] += 1
        return {day: data[day] for day in list(data)[-days:]}

    def get_statistics_data(self):
        """
            感染者の年齢別統計データを取得
            prefは日本語名  例: 東京都
        """
        return self.req.get_statistics()
