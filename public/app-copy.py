import re
import sys
import math
import pandas as pd
import mysql.connector
from datetime import date
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.feature_extraction.text import TfidfVectorizer
from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory

# Connect to the database
connection = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="bkk"
)
keyword = sys.argv[1]

today = date.today().strftime("%Y-%m-%d")
sql = "select `vacancies`.*, (select count(*) from `applicants` where `vacancies`.`id` = `applicants`.`vacancy_id` and `verified` = '1' and `applicants`.`deleted_at` is null) as `applicants_count` from `vacancies` where `deadline` >= '" + today + \
    "' and (`max_applicants` is null and exists (select * from `companies` where `vacancies`.`company_id` = `companies`.`id` and `status` = '1' and `companies`.`deleted_at` is null) or `max_applicants` is not null and (select count(*) from `applicants` where `vacancies`.`id` = `applicants`.`vacancy_id` and `verified` = 1 and `applicants`.`deleted_at` is null) < max_applicants) and `vacancies`.`deleted_at` is null order by `deadline` desc, `updated_at` desc"
itemPerPage = 5
page = 1
minWeight = 0

# Create a cursor object to interact with the database
cursor = connection.cursor()

# Execute a query
cursor.execute(sql)
vacancies = []
for vacancy in cursor.fetchall():
    # vacancy[0] is id
    # vacancy[2] is position
    # vacancy[4] is description
    vacancies.append([vacancy[0], vacancy[2], vacancy[4]])

df = pd.DataFrame(vacancies, columns=["id", "position", "desc"])
df = df.dropna()

# menghapus stop words (kata-kata umum yang sering muncul dan biasanya tidak memiliki makna penting dalam analisis teks)
stopword = StopWordRemoverFactory().create_stop_word_remover()
for i, kalimat in enumerate(df.iterrows()):
    html_pattern = re.compile('<.*?>')
    df.at[i, "desc"] = stopword.remove(
        html_pattern.sub(r'', df.loc[i, 'desc'].lower())
    )
    df.at[i, "position"] = stopword.remove(
        html_pattern.sub(r'', df.loc[i, 'position'].lower())
    )

dfCombine = df['position'] + " " + df["desc"]
# print(type(dfCombine))
vectorizer = TfidfVectorizer()
tfidf_matrix = vectorizer.fit_transform(dfCombine)
new_tfidf_vector = vectorizer.transform([keyword])
similarity_scores = cosine_similarity(new_tfidf_vector, tfidf_matrix)

vacanciesWeighted = similarity_scores[0]
sortedIndexVacancies = vacanciesWeighted.argsort()[::-1]

# eliminate minimum weight
for index, vacancyScore in enumerate(vacanciesWeighted[sortedIndexVacancies]):
    if(vacancyScore < minWeight):
        # delete element from index 0 to index (but not including this index less than minWeight)
        sortedIndexVacancies = sortedIndexVacancies[0:index]
        break

data = []
pages = math.ceil(len(sortedIndexVacancies) / itemPerPage)
if page == 1 or page == 0:
    start_index = 0
    end_index = itemPerPage
else:
    start_index = (page - 1) * itemPerPage
    if page >= pages:
        end_index = len(sortedIndexVacancies)
    else:
        end_index = page * itemPerPage

for index in sortedIndexVacancies[start_index:end_index]:
    data.append({
        "id": vacancies[index][0],
        "score": vacanciesWeighted[index]
    })

print(data)
