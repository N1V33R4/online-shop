import re


s: str = "['9', '8']"

print(re.sub("[\[\]']", '', s))