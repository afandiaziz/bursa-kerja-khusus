import re
import sys
import math
import pandas as pd
from datetime import date
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.feature_extraction.text import TfidfVectorizer
from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory


print()
print()
# data = [
#     "Web Developer <p>Kami sedang mencari seorang Web Developer yang berpengalaman untuk bergabung dengan tim kami. Tanggung jawab Anda akan mencakup pengembangan front-end dan back-end, serta memastikan keberlanjutan dan performa tinggi dari situs web kami.</p> <h2>Kualifikasi:</h2> <ul> <li>Pengalaman dalam HTML, CSS, dan JavaScript</li> <li>Pemahaman yang baik tentang desain responsif</li> <li>Pengalaman dalam pengembangan situs web menggunakan CMS seperti WordPress</li> <li>Kemampuan untuk bekerja dalam tim</li> </ul>",
#     "Data Scientist <p>Kami mencari seorang Data Scientist yang handal dan berpengalaman untuk bergabung dengan tim kami. Tugas Anda akan meliputi analisis data, pengembangan model prediktif, dan penemuan wawasan berharga dari set data yang kompleks.</p> <h2>Kualifikasi:</h2> <ul> <li>Pengalaman dalam analisis data menggunakan Python atau R</li> <li>Pemahaman yang kuat tentang statistik dan metode analisis data</li> <li>Pengalaman dalam penggunaan alat-alat seperti SQL dan Pandas</li> <li>Kemampuan komunikasi yang baik untuk menyampaikan hasil analisis dengan jelas</li> </ul>",
#     "UI/UX Designer <p>Kami sedang mencari seorang UI/UX Designer yang kreatif dan berbakat untuk bergabung dengan tim kami. Tanggung jawab Anda akan meliputi merancang antarmuka pengguna yang menarik dan fungsional, serta melakukan pengujian pengguna dan iterasi desain.</p> <h2>Kualifikasi:</h2> <ul> <li>Pengalaman dalam merancang antarmuka pengguna yang menarik</li> <li>Pemahaman tentang prinsip-prinsip desain UI/UX</li> <li>Kemampuan menggunakan alat desain seperti Adobe XD atau Sketch</li> <li>Kemampuan untuk bekerja dalam tim dan berkolaborasi dengan pengembang</li> </ul>",
#     "Front-end Developer <p>Kami mencari seorang Front-end Developer yang berpengalaman untuk bergabung dengan tim pengembangan kami. Anda akan bertanggung jawab dalam mengembangkan antarmuka pengguna interaktif menggunakan HTML, CSS, dan JavaScript serta memastikan kinerja optimal dan responsif dari situs web kami.</p> <h2>Kualifikasi:</h2> <ul> <li>Pengalaman dalam pengembangan antarmuka pengguna menggunakan HTML, CSS, dan JavaScript</li> <li>Pemahaman yang baik tentang desain responsif dan pengujian lintas browser</li> <li>Pengalaman dengan kerangka kerja (framework) seperti React atau Vue.js</li> <li>Kemampuan untuk bekerja dalam tim dan berkolaborasi dengan desainer UI/UX</li> </ul>",
#     "Front-end Web Developer <ul> <li><strong>Deskripsi:</strong></li> <ul> <li>Mengembangkan antarmuka pengguna (UI) yang menarik dan responsif untuk website.</li> <li>Mengimplementasikan desain web menggunakan HTML, CSS, dan JavaScript.</li> <li>Memastikan kesesuaian lintas browser (cross-browser compatibility) pada antarmuka pengguna.</li> <li>Optimasi kinerja website agar responsif dan cepat diakses oleh pengguna.</li> <li>Kolaborasi dengan tim pengembang dan desainer untuk menghasilkan pengalaman pengguna terbaik.</li> <li>Menggunakan framework dan alat pengembangan front-end seperti React, Angular, atau Vue.js.</li> </ul> <li><strong>Kualifikasi:</strong></li> <ul> <li>Pemahaman yang kuat tentang HTML, CSS, dan JavaScript.</li> <li>Pengalaman dengan framework front-end seperti React, Angular, atau Vue.js merupakan nilai tambah.</li> <li>Kemampuan dalam desain responsif dan lintas browser compatibility.</li> <li>Kemampuan pemecahan masalah dan pemikiran kreatif dalam menghadapi tantangan pengembangan front-end.</li> <li>Kemampuan kerja dalam tim yang baik dan komunikasi yang efektif.</li> </ul> </ul>",
#     "Back-end Web Developer <ul> <li><strong>Deskripsi:</strong></li> <ul> <li>Memiliki tanggung jawab dalam pengembangan logika aplikasi web sisi server.</li> <li>Integrasi antarmuka pengguna (UI) dengan elemen-elemen sisi depan.</li> <li>Mengembangkan API (Application Programming Interface) untuk komunikasi dengan aplikasi lain.</li> <li>Mengelola basis data dan memastikan keamanan serta efisiensi dalam pengaksesan data.</li> <li>Menerapkan praktik keamanan dalam pengembangan aplikasi web.</li> <li>Pemecahan masalah dan debugging pada sisi server.</li> </ul> <li><strong>Kualifikasi:</strong></li> <ul> <li>Pemahaman yang kuat tentang bahasa pemrograman sisi server seperti Java, Python, atau PHP.</li> <li>Pengalaman dengan pengembangan API (Application Programming Interface).</li> <li>Pengalaman dengan pengelolaan basis data dan SQL.</li> <li>Pemahaman tentang praktik keamanan dalam pengembangan aplikasi web.</li> <li>Kemampuan pemecahan masalah dan pemikiran analitis.</li> <li>Kemampuan kerja dalam tim dan komunikasi yang baik.</li> </ul> </ul>",
# ]
# data = [
#     "Hotel Santika. terjangkau, strategis, Dekat Stasiun, Mall, Apartment, Pasar",
#     "Hotel Margonda. strategis, dekat Stasiun, dan Kampus, Mewah dan nyaman",
#     "Hotel Aviary Bintaro. Hotel bintang 4. Mewah, bersih, nyaman, pelayanan terbaik",
#     "Hotel Swiss-belhotel. Mewah, nyaman dan tenang",
# ]
data = [
    'hotel santika jangkau strategis dekat stasiun mall apartment pasar',
    'hotel margonda strategis dekat stasiun dan kampus mewah dan nyaman',
    'hotel aviary bintaro hotel bintang 4 mewah bersih nyaman layan baik',
    'hotel swiss-belhotel mewah nyaman dan tenang',
]
# keyword = sys.argv[1]

# minWeight = 0

# df = pd.DataFrame(data, columns=["documents"])
# df = df.dropna()

# menghapus stop words (kata-kata umum yang sering muncul dan biasanya tidak memiliki makna penting dalam analisis teks)
# stopword = StopWordRemoverFactory().create_stop_word_remover()
# for i, kalimat in enumerate(df.iterrows()):
#     html_pattern = re.compile('<.*?>')
#     df.at[i, "documents"] = stopword.remove(
#         html_pattern.sub(r'', df.loc[i, 'documents'].lower())
#     )

# print(df['documents'])

vectorizer = TfidfVectorizer()
# tfidf_matrix = vectorizer.fit_transform(df['documents'])
vectorizer.fit_transform(data)
# Mengambil indeks kata "hotel" dalam daftar fitur
hotel_index = vectorizer.vocabulary_.get('hotel')
# Menghitung TF untuk kata "hotel" dalam setiap dokumen
for i, document in enumerate(data):
    # Mengubah dokumen menjadi representasi vektor TF-IDF
    tfidf_vector = vectorizer.transform([document])

    # Mengambil nilai TF untuk kata "hotel" dalam dokumen
    tf_hotel = tfidf_vector.toarray()[0, hotel_index]
    # print(tf_hotel)

    # Menghitung total jumlah term dalam dokumen
    # total_terms = len(document.split())
    print(count_hotel)

    # Menghitung nilai TF(t, d) = (jumlah kemunculan term t dalam dokumen d) / (total jumlah term dalam dokumen d)
    # tf = tf_hotel / total_terms

    # print("TF kata 'hotel' dalam dokumen", i+1, "adalah:", tf)


# tfidf_matrix = vectorizer.fit_transform(data)
# new_tfidf_vector = vectorizer.transform(["hotel", "mewah", "nyaman"])
# new_tfidf_vector = vectorizer.transform(["hotel mewah nyaman"])
# feature_names = vectorizer.get_feature_names_out()

# Access the IDF values
# tf_matrix = new_tfidf_vector.toarray()
# idf_values = vectorizer.idf_

# print(tfidf_matrix.toarray())
# print()
# print()
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
