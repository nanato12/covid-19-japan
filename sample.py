from covid19 import COVID19
import json

covid = COVID19()
data = covid.get_positives_count_last_days('東京', 5)

json.dump(data, open('sample.json', 'w'))
