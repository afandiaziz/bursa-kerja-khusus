<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\Vacancy;
// use Smalot\PdfParser\Parser;
use Phpml\Math\Distance\Cosine;
use Phpml\Dataset\ArrayDataset;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;

use App\Cbrs;
use Sastrawi\Stemmer\StemmerFactory;
use Sastrawi\StopWordRemover\StopWordRemoverFactory;

class ContentBasedFilteringController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     Carbon::setLocale('id');
    // }

    // public function exec()
    // {
    //     $python_script = public_path('app.py');
    //     exec('python "' . $python_script . '" "Data Analyst"', $output);
    //     $result = json_decode(str_replace("'", '"', $output[0]));
    //     print_r($result);
    // }

    // private function preProcess($text)
    // {
    //     $stemmerFactory = new StemmerFactory();
    //     $stemmer  = $stemmerFactory->createStemmer();
    //     $stopWordRemoverFactory = new StopWordRemoverFactory();
    //     $stopword = $stopWordRemoverFactory->createStopWordRemover();

    //     $text = strtolower(strip_tags($text));
    //     $text = $stemmer->stem($text);
    //     $text = $stopword->remove($text);
    //     return $text;
    // }

    // public function search($keyword)
    // {
    //     // $vacancies = Vacancy::active()->get()->toArray();
    //     // $arrayVacancies = [];
    //     // foreach ($vacancies as $vacancy) {
    //     //     array_push($arrayVacancies, [$vacancy['id'], $vacancy['position'], $vacancy['description']]);
    //     // }
    //     // Membuat DataFrame menggunakan data
    //     // dd($arrayVacancies);

    //     // $hotel = [
    //     //     'Ini adalah contoh dokumen pertama.',
    //     //     'Ini adalah contoh dokumen kedua.',
    //     //     'Ini adalah contoh dokumen ketiga.',
    //     //     'Ini adalah contoh dokumen keempat.',
    //     //     'Saya suka makan nasi goreng',
    //     //     'Nasi goreng adalah makanan favorit saya',
    //     //     'Saya makan nasi goreng setiap hari',
    //     // ];

    //     // ['adalah contoh dokumen pertama.',
    //     // 'adalah contoh dokumen kedua.',
    //     // 'adalah contoh dokumen ketiga.',
    //     // 'adalah contoh dokumen keempat.',
    //     // 'suka makan nasi goreng',
    //     // 'nasi goreng makanan favorit',
    //     // 'makan nasi goreng hari']

    //     $data = [
    //         "web developer sedang mencari seorang web developer berpengalaman bergabung tim kami. tanggung jawab akan mencakup pengembangan front-end back-end, memastikan keberlanjutan performa tinggi situs web kami. kualifikasi:  pengalaman html, css, javascript pemahaman baik desain responsif pengalaman pengembangan situs web menggunakan cms wordpress kemampuan bekerja tim ",
    //         "data scientist mencari seorang data scientist handal berpengalaman bergabung tim kami. tugas akan meliputi analisis data, pengembangan model prediktif, penemuan wawasan berharga set data kompleks. kualifikasi:  pengalaman analisis data menggunakan python r pemahaman kuat statistik metode analisis data pengalaman penggunaan alat-alat sql pandas kemampuan komunikasi baik menyampaikan hasil analisis jelas ",
    //         "ui/ux designer sedang mencari seorang ui/ux designer kreatif berbakat bergabung tim kami. tanggung jawab akan meliputi merancang antarmuka pengguna menarik fungsional, melakukan pengujian pengguna iterasi desain. kualifikasi:  pengalaman merancang antarmuka pengguna menarik pemahaman prinsip-prinsip desain ui/ux kemampuan menggunakan alat desain adobe xd sketch kemampuan bekerja tim berkolaborasi pengembang ",
    //         "front-end developer mencari seorang front-end developer berpengalaman bergabung tim pengembangan kami. akan bertanggung jawab mengembangkan antarmuka pengguna interaktif menggunakan html, css, javascript memastikan kinerja optimal responsif situs web kami. kualifikasi:  pengalaman pengembangan antarmuka pengguna menggunakan html, css, javascript pemahaman baik desain responsif pengujian lintas browser pengalaman kerangka kerja (framework) react vue.js kemampuan bekerja tim berkolaborasi desainer ui/ux ",
    //         "front-end web developer  deskripsi:  mengembangkan antarmuka pengguna (ui) menarik responsif website. mengimplementasikan desain web menggunakan html, css, javascript. memastikan kesesuaian lintas browser (cross-browser compatibility) antarmuka pengguna. optimasi kinerja website responsif cepat diakses pengguna. kolaborasi tim pengembang desainer menghasilkan pengalaman pengguna terbaik. menggunakan framework alat pengembangan front-end react, angular, vue.js.  kualifikasi:  pemahaman kuat html, css, javascript. pengalaman framework front-end react, angular, vue.js merupakan nilai tambah. kemampuan desain responsif lintas browser compatibility. kemampuan pemecahan masalah pemikiran kreatif menghadapi tantangan pengembangan front-end. kemampuan kerja tim baik komunikasi efektif.  ",
    //         "back-end web developer  deskripsi:  memiliki tanggung jawab pengembangan logika aplikasi web sisi server. integrasi antarmuka pengguna (ui) elemen-elemen sisi depan. mengembangkan api (application programming interface) komunikasi aplikasi lain. mengelola basis data memastikan keamanan efisiensi pengaksesan data. menerapkan praktik keamanan pengembangan aplikasi web. pemecahan masalah debugging sisi server.  kualifikasi:  pemahaman kuat bahasa pemrograman sisi server java, python, php. pengalaman pengembangan api (application programming interface). pengalaman pengelolaan basis data sql. pemahaman praktik keamanan pengembangan aplikasi web. kemampuan pemecahan masalah pemikiran analitis. kemampuan kerja tim komunikasi baik.  "
    //     ];

    //     // $hotel = array();
    //     // $hotel[1] = "Hotel Modern yang Terjangkau";
    //     // $hotel[2] = "Akomodasi modern, nyaman, dan tenang";
    //     // $hotel[3] = "Hotel bintang 3 yang mewah namun dengan harga yang terjangkau";
    //     // $hotel[4] = "hotel tenang, strategis, dan nyaman";
    //     // $hotel[5] = "lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua";

    //     // foreach ($hotel as $key => $item) {
    //     //     $hotel[$key] = $this->preProcess($item);
    //     // }

    //     // $keyword = $this->preProcess('nyaman, tenang, modern, damai dan mewah juga');

    //     $cbrs = new Cbrs();
    //     $cbrs->create_index($data);
    //     // $cbrs->idf();
    //     dd($cbrs->idf());
    //     $w = $cbrs->weight();

    //     // $r = $cbrs->search($keyword);
    //     // $r = $cbrs->similarity(1);
    //     dd($w);
    // }

    // public function searchByLibrary($keyword)
    // {
    //     // Contoh data dokumen
    //     // $documents = [
    //     //     'Ini adalah contoh dokumen pertama.',
    //     //     'Ini adalah contoh dokumen kedua.',
    //     //     'Ini adalah contoh dokumen ketiga.',
    //     //     'Ini adalah contoh dokumen keempat.',
    //     //     'Saya suka makan nasi goreng',
    //     //     'Nasi goreng adalah makanan favorit saya',
    //     //     'Saya makan nasi goreng setiap hari',
    //     // ];
    //     $documents = [
    //         'Ini adalah contoh dokumen pertama.',
    //         'Ini adalah contoh dokumen kedua.',
    //         'Ini adalah contoh dokumen ketiga.',
    //         'Ini adalah contoh dokumen keempat.',
    //         'Saya suka makan nasi goreng',
    //         'Nasi goreng adalah makanan favorit saya',
    //         'Saya makan nasi goreng setiap hari',
    //     ];
    //     // stopword
    //     foreach ($documents as $index => $document) {
    //         $document = $this->preProcess($document);
    //         $documents[$index] = $document;
    //     }

    //     // Proses tokenisasi
    //     $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
    //     $vectorizer->fit($documents);
    //     $vectorizer->transform($documents);

    //     // dd($documents);

    //     $tfIdfMatrix = new TfIdfTransformer($documents);
    //     $tfIdfMatrix->transform($documents);

    //     dd($tfIdfMatrix);

    //     // Menampilkan hasil tf-idf
    //     foreach ($tfIdfMatrix->idf as $documentIndex => $documentFeatures) {
    //         echo 'Dokumen #' . ($documentIndex + 1) . PHP_EOL;
    //         foreach ($documentFeatures as $term => $tfIdfValue) {
    //             echo $term . ': ' . $tfIdfValue . PHP_EOL;
    //         }
    //         echo PHP_EOL;
    //     }
    // }
}
