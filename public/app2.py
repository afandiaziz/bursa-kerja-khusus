import re
import sys
import math
import pandas as pd
from datetime import date
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.feature_extraction.text import CountVectorizer
from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory


print()
print()

data = [
    'hotel santika jangkau strategis dekat stasiun mall apartment pasar',
    'hotel margonda strategis dekat stasiun dan kampus mewah dan nyaman',
    'hotel aviary bintaro hotel bintang 4 mewah bersih nyaman layan baik',
    'hotel swiss-belhotel mewah nyaman dan tenang',
]
# countVectorizer = CountVectorizer()
# vectorizer = CountVectorizer()
vectorizer = TfidfVectorizer(use_idf=True, smooth_idf=True)
# tokenizer = vectorizer.build_tokenizer()
# tfidf_matrix = vectorizer.fit(data)
tfidf_matrix = vectorizer.fit_transform([
    "Saya suka kucing",
    "Saya suka anjing dan kucing"
])
terms = vectorizer.get_feature_names_out()
for i, doc in enumerate([
    "Saya suka kucing",
    "Saya suka anjing dan kucing"
]):
    print("Dokumen:", i+1)
    for j, term in enumerate(terms):
        tfidf_score = tfidf_matrix[i, j]
        print("  ", term, ":", tfidf_score)
vocab = vectorizer.vocabulary_

print()
print()
print(tfidf_matrix.toarray())
print()
# kalimat_pertama = data[0]
# tokens = tokenizer(kalimat_pertama)

# Menampilkan hasil pemisahan kata
# print("Kalimat asli:", kalimat_pertama)
# print("Token:", tokens)
# hotel_index = vocab.get('hotel')

# kalimat_pertama_index = 0
# word_counts = tfidf_matrix[kalimat_pertama_index].toarray().sum(axis=0)

# # Menampilkan hasil
# for word, count in zip(vocab, word_counts):
#     print(f"Kata '{word}' muncul sebanyak: {count}")

# df_hotel = vectorizer.idf_[hotel_index]
print(vectorizer.idf_)
# print("Dokumen Frekuensi (df) dari kata 'hotel' adalah:", df_hotel)

# for i, document in enumerate(data):
# tf_hotel = tfidf_matrix.toarray()[0, hotel_index]
# print()
# print('tf fit_transform kata "hotel": ', tf_hotel)

# Access the IDF values
# tf_matrix = new_tfidf_vector.toarray()
# idf_values = vectorizer.idf_

print()
print()
# print(tfidf_matrix.toarray())
# print(feature_names)

# for i, name in enumerate(feature_names):
#     print(i, name)

# for doc_index, doc in enumerate(data):
#     print(f"Dokumen {doc_index+1}:")
#     for feature_name_index, feature_name in enumerate(feature_names):
#         print(
#             f"  - {feature_name}: {new_tfidf_vector[doc_index, feature_name_index]}")
# #     for feature_index in tfidf_matrix[doc_index].indices:
# #         print(
# #             f"{feature_names[feature_index]}: {tfidf_matrix[doc_index, feature_index]}")
#     print()
# for doc_index, doc in enumerate(data):
#     print(f"Dokumen {doc_index+1}:")
#     # for feature_name_index, feature_name in enumerate(feature_names):
#     #     print(
#     #         f"  - {feature_name}: {new_tfidf_vector[doc_index, feature_name_index]}")
#     for feature_index in tfidf_matrix[doc_index].indices:
#         print(
#             f"{feature_names[feature_index]}: {tfidf_matrix[doc_index, feature_index]}")
#     print()

print()
print()

# new_tfidf_vector = vectorizer.transform([keyword])
# similarity_scores = cosine_similarity(new_tfidf_vector, tfidf_matrix)

# vacanciesWeighted = similarity_scores[0]
# sortedIndexVacancies = vacanciesWeighted.argsort()[::-1]

# # eliminate minimum weight
# for index, vacancyScore in enumerate(vacanciesWeighted[sortedIndexVacancies]):
#     if(vacancyScore < minWeight):
#         # delete element from index 0 to index (but not including this index less than minWeight)
#         sortedIndexVacancies = sortedIndexVacancies[0:index]
#         break

# data = []
# pages = math.ceil(len(sortedIndexVacancies) / itemPerPage)
# if page == 1 or page == 0:
#     start_index = 0
#     end_index = itemPerPage
# else:
#     start_index = (page - 1) * itemPerPage
#     if page >= pages:
#         end_index = len(sortedIndexVacancies)
#     else:
#         end_index = page * itemPerPage

# for index in sortedIndexVacancies[start_index:end_index]:
#     data.append({
#         "id": vacancies[index][0],
#         "score": vacanciesWeighted[index]
#     })

# print(data)
