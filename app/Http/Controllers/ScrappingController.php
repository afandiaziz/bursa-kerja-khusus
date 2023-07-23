<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vacancy;
use App\Models\Company;
use App\Models\Criteria;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VacancyCriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ScrappingController extends Controller
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

    // private function setBodyRequest($type, $param)
    // {
    //     if ($type == 'get-jobs') {
    //         $valueQueryAllJobs = 'query getJobs($country: String, $locale: String, $keyword: String, $createdAt: String, $jobFunctions: [Int], $categories: [String], $locations: [Int], $careerLevels: [Int], $minSalary: Int, $maxSalary: Int, $salaryType: Int, $candidateSalary: Int, $candidateSalaryCurrency: String, $datePosted: Int, $jobTypes: [Int], $workTypes: [String], $industries: [Int], $page: Int, $pageSize: Int, $companyId: String, $advertiserId: String, $userAgent: String, $accNums: Int, $subAccount: Int, $minEdu: Int, $maxEdu: Int, $edus: [Int], $minExp: Int, $maxExp: Int, $seo: String, $searchFields: String, $candidateId: ID, $isDesktop: Boolean, $isCompanySearch: Boolean, $sort: String, $sVi: String, $duplicates: String, $flight: String, $solVisitorId: String) {\n  jobs(\n    country: $country\n    locale: $locale\n    keyword: $keyword\n    createdAt: $createdAt\n    jobFunctions: $jobFunctions\n    categories: $categories\n    locations: $locations\n    careerLevels: $careerLevels\n    minSalary: $minSalary\n    maxSalary: $maxSalary\n    salaryType: $salaryType\n    candidateSalary: $candidateSalary\n    candidateSalaryCurrency: $candidateSalaryCurrency\n    datePosted: $datePosted\n    jobTypes: $jobTypes\n    workTypes: $workTypes\n    industries: $industries\n    page: $page\n    pageSize: $pageSize\n    companyId: $companyId\n    advertiserId: $advertiserId\n    userAgent: $userAgent\n    accNums: $accNums\n    subAccount: $subAccount\n    minEdu: $minEdu\n    edus: $edus\n    maxEdu: $maxEdu\n    minExp: $minExp\n    maxExp: $maxExp\n    seo: $seo\n    searchFields: $searchFields\n    candidateId: $candidateId\n    isDesktop: $isDesktop\n    isCompanySearch: $isCompanySearch\n    sort: $sort\n    sVi: $sVi\n    duplicates: $duplicates\n    flight: $flight\n    solVisitorId: $solVisitorId\n  ) {\n    total\n    totalJobs\n    relatedSearchKeywords {\n      keywords\n      type\n      totalJobs\n    }\n    solMetadata\n    suggestedEmployer {\n      name\n      totalJobs\n    }\n    queryParameters {\n      key\n      searchFields\n      pageSize\n    }\n    experiments {\n      flight\n    }\n    jobs {\n      id\n      adType\n      sourceCountryCode\n      isStandout\n      companyMeta {\n        id\n        advertiserId\n        isPrivate\n        name\n        logoUrl\n        slug\n      }\n      jobTitle\n      jobUrl\n      jobTitleSlug\n      description\n      employmentTypes {\n        code\n        name\n      }\n      sellingPoints\n      locations {\n        code\n        name\n        slug\n        children {\n          code\n          name\n          slug\n        }\n      }\n      categories {\n        code\n        name\n        children {\n          code\n          name\n        }\n      }\n      postingDuration\n      postedAt\n      salaryRange {\n        currency\n        max\n        min\n        period\n        term\n      }\n      salaryVisible\n      bannerUrl\n      isClassified\n      solMetadata\n    }\n  }\n}\n';
    //         $body = '{"query": "' . $valueQueryAllJobs . '", ' . substr(json_encode([
    //             "variables" => [
    //                 "keyword" => "",
    //                 "jobFunctions" => [],
    //                 "locations" => [],
    //                 "salaryType" => 1,
    //                 "jobTypes" => [],
    //                 "createdAt" => null,
    //                 "careerLevels" => [],
    //                 "page" => $param,
    //                 "country" => "id",
    //                 "sVi" => "",
    //                 "solVisitorId" => "dbc3abb5-c92d-4c41-a443-e2df61849330",
    //                 "categories" => [],
    //                 "workTypes" => [],
    //                 "userAgent" => "Mozilla/5.0%20(Windows%20NT%2010.0;%20Win64;%20x64)%20AppleWebKit/537.36%20(KHTML,%20like%20Gecko)%20Chrome/114.0.0.0%20Safari/537.36",
    //                 "industries" => [],
    //                 "locale" => "id",
    //             ]
    //         ]), 1, -1) . '}';
    //     } else {
    //         $valueQueryAllJobs = 'query getJobDetail($jobId: String, $locale: String, $country: String, $candidateId: ID, $solVisitorId: String, $flight: String) {\n  jobDetail(\n    jobId: $jobId\n    locale: $locale\n    country: $country\n    candidateId: $candidateId\n    solVisitorId: $solVisitorId\n    flight: $flight\n  ) {\n    id\n    pageUrl\n    jobTitleSlug\n    applyUrl {\n      url\n      isExternal\n    }\n    isExpired\n    isConfidential\n    isClassified\n    accountNum\n    advertisementId\n    subAccount\n    showMoreJobs\n    adType\n    header {\n      banner {\n        bannerUrls {\n          large\n        }\n      }\n      salary {\n        max\n        min\n        type\n        extraInfo\n        currency\n        isVisible\n      }\n      logoUrls {\n        small\n        medium\n        large\n        normal\n      }\n      jobTitle\n      company {\n        name\n        url\n        slug\n        advertiserId\n      }\n      review {\n        rating\n        numberOfReviewer\n      }\n      expiration\n      postedDate\n      postedAt\n      isInternship\n    }\n    companyDetail {\n      companyWebsite\n      companySnapshot {\n        avgProcessTime\n        registrationNo\n        employmentAgencyPersonnelNumber\n        employmentAgencyNumber\n        telephoneNumber\n        workingHours\n        website\n        facebook\n        size\n        dressCode\n        nearbyLocations\n      }\n      companyOverview {\n        html\n      }\n      videoUrl\n      companyPhotos {\n        caption\n        url\n      }\n    }\n    jobDetail {\n      summary\n      jobDescription {\n        html\n      }\n      jobRequirement {\n        careerLevel\n        yearsOfExperience\n        qualification\n        fieldOfStudy\n        industryValue {\n          value\n          label\n        }\n        skills\n        employmentType\n        languages\n        postedDate\n        closingDate\n        jobFunctionValue {\n          code\n          name\n          children {\n            code\n            name\n          }\n        }\n        benefits\n      }\n      whyJoinUs\n    }\n    location {\n      location\n      locationId\n      omnitureLocationId\n    }\n    sourceCountry\n  }\n}\n';
    //         $body = '{"query": "' . $valueQueryAllJobs . '", ' . substr(json_encode([
    //             "variables" => [
    //                 "jobId" => $param,
    //                 "country" => "id",
    //                 "locale" => "id",
    //                 "candidateId" => "",
    //                 "solVisitorId" => "dbc3abb5-c92d-4c41-a443-e2df61849330",
    //             ]
    //         ]), 1, -1) . '}';
    //     }
    //     return $body;
    // }

    // public function scrapping(Request $request)
    // {
    //     // max execution time increase
    //     ini_set('max_execution_time', 3000);
    //     $start = $request->start;
    //     $end = $request->end;
    //     // $totalPages = 1;
    //     $skills = [];
    //     $benefits = [];
    //     $careerLevels = [];
    //     $qualifications = [];
    //     $employmentTypes = [];
    //     // Company::whereNotNull('id')->forceDelete();

    //     // $pageIterated = 0;
    //     $vacancyIterated = 0;
    //     for ($i = intval($start); $i <= intval($end); $i++) {
    //         $response = Http::withBody($this->setBodyRequest('get-jobs', intval($i)), 'application/json')
    //             ->post('https://xapi.supercharge-srp.co/job-search/graphql?country=id&isSmartSearch=true')
    //             ->object()->data?->jobs;
    //         // $totalPages = intval(ceil($response->totalJobs / 30));
    //         foreach ($response->jobs as $index => $job) {
    //             if ($job->id) {
    //                 $detail = Http::withBody($this->setBodyRequest('get-job-detail', $job->id), 'application/json')
    //                     ->post('https://xapi.supercharge-srp.co/job-search/graphql?country=id&isSmartSearch=true')
    //                     ->object()
    //                     ->data?->jobDetail;
    //                 if ($detail) {
    //                     if ($detail->jobDetail->jobRequirement->careerLevel && !in_array($detail->jobDetail->jobRequirement->careerLevel, $careerLevels)) {
    //                         array_push($careerLevels, $detail->jobDetail->jobRequirement->careerLevel);
    //                     }

    //                     if ($detail->jobDetail->jobRequirement->qualification && !in_array($detail->jobDetail->jobRequirement->qualification, $qualifications)) {
    //                         array_push($qualifications, $detail->jobDetail->jobRequirement->qualification);
    //                     }

    //                     if ($detail->jobDetail->jobRequirement->employmentType && !in_array($detail->jobDetail->jobRequirement->employmentType, $employmentTypes)) {
    //                         array_push($employmentTypes, $detail->jobDetail->jobRequirement->employmentType);
    //                     }

    //                     if ($detail->jobDetail->jobRequirement->skills && !in_array($detail->jobDetail->jobRequirement->skills, $skills)) {
    //                         array_push($skills, $detail->jobDetail->jobRequirement->skills);
    //                     }

    //                     if ($detail->jobDetail->jobRequirement->benefits && count($detail->jobDetail->jobRequirement->benefits)) {
    //                         foreach ($detail->jobDetail->jobRequirement->benefits as $benefit) {
    //                             if (!in_array($benefit, $benefits)) {
    //                                 array_push($benefits, $benefit);
    //                             }
    //                         }
    //                     }

    //                     $jobType = $detail->jobDetail->jobRequirement->employmentType;
    //                     if ($detail->jobDetail->jobRequirement->employmentType == 'Paruh Waktu') {
    //                         $jobType = 'Part-time';
    //                     } else if ($detail->jobDetail->jobRequirement->employmentType == 'Magang') {
    //                         $jobType = 'Internship';
    //                     } else if ($detail->jobDetail->jobRequirement->employmentType == 'Temporer') {
    //                         $jobType = 'Temporary';
    //                     } else if ($detail->jobDetail->jobRequirement->employmentType == 'Kontrak') {
    //                         $jobType = 'Contract';
    //                     } else if ($detail->jobDetail->jobRequirement->employmentType == 'Penuh Waktu') {
    //                         $jobType = 'Full-time';
    //                     }

    //                     $company = Company::firstOrCreate([
    //                         'name' => $detail->header->company->name,
    //                         'email' => 'hr@' . Str::slug($detail->header->company->name) . '.co.id',
    //                     ], [
    //                         'logo' => $detail->header->logoUrls->normal,
    //                         'address' => fake('id_ID')->streetAddress() . ', ' . $detail->location[0]->location,
    //                     ]);
    //                     if ($company->id) {
    //                         $deadline = explode('T', $detail->jobDetail->jobRequirement->closingDate)[0];
    //                         $created_at = explode('T', $detail->header->postedAt)[0];
    //                         $vacancy = Vacancy::create([
    //                             'company_id' => $company->id,
    //                             'position' => $detail->header->jobTitle,
    //                             'description' => $detail->jobDetail->jobDescription->html,
    //                             'deadline' => $deadline,
    //                             'created_at' => $created_at,
    //                             'job_type' => $jobType,
    //                         ]);

    //                         if ($vacancy->id) {
    //                             $random = fake()->numberBetween(4, 9);
    //                             $selectedId = [];
    //                             $criteriaRequired = Criteria::select('id')->where('required', 1)->where('active', 1)->whereNull('parent_id')->get();
    //                             foreach ($criteriaRequired as $item) {
    //                                 array_push($selectedId, $item->id);
    //                                 VacancyCriteria::create([
    //                                     'vacancy_id' => $vacancy->id,
    //                                     'criteria_id' => $item->id,
    //                                 ]);
    //                             }
    //                             for ($iterateVacancyCriteria = 0; $iterateVacancyCriteria < $random; $iterateVacancyCriteria++) {
    //                                 $criteriaId = Criteria::where('required', 0)->where('active', 1)->whereNull('parent_id')->whereNotIn('id', $selectedId)->inRandomOrder()->first()->id;
    //                                 if (!in_array($criteriaId, $selectedId)) {
    //                                     array_push($selectedId, $criteriaId);
    //                                     VacancyCriteria::create([
    //                                         'vacancy_id' => $vacancy->id,
    //                                         'criteria_id' => $criteriaId,
    //                                     ]);
    //                                 }
    //                             }
    //                         }
    //                         $vacancyIterated++;
    //                         // $iterated += ($index + 1);
    //                     }
    //                 }
    //             }
    //             //     // break;
    //         }
    //         // break;
    //     }
    //     if (count($employmentTypes)) {
    //         foreach ($employmentTypes as $value) {
    //             DB::table('jobtypes')->updateOrInsert([
    //                 'type' => $value,
    //             ], [
    //                 'type' => $value,
    //             ]);
    //         }
    //     }
    //     if (count($skills)) {
    //         foreach ($skills as $value) {
    //             DB::table('skills')->updateOrInsert([
    //                 'name' => $value,
    //             ], [
    //                 'name' => $value,
    //             ]);
    //         }
    //     }
    //     if (count($benefits)) {
    //         foreach ($benefits as $value) {
    //             DB::table('benefits')->updateOrInsert([
    //                 'name' => $value,
    //             ], [
    //                 'name' => $value,
    //             ]);
    //         }
    //     }
    //     if (count($careerLevels)) {
    //         foreach ($careerLevels as $value) {
    //             DB::table('careerlevels')->updateOrInsert([
    //                 'name' => $value,
    //             ], [
    //                 'name' => $value,
    //             ]);
    //         }
    //     }
    //     if (count($qualifications)) {
    //         foreach ($qualifications as $value) {
    //             DB::table('qualifications')->updateOrInsert([
    //                 'name' => $value,
    //             ], [
    //                 'name' => $value,
    //             ]);
    //         }
    //     }

    //     $pageIterated = $start . ' - ' . $end;

    //     return response()->json([
    //         'pageIterated' => $pageIterated,
    //         'vacancyIterated' => $vacancyIterated,
    //     ], 200);
    //     // dd(
    //     //     $iterated,
    //     //     // $skills,
    //     //     // $benefits,
    //     //     // $careerLevels,
    //     //     // $qualifications,
    //     //     // $employmentTypes
    //     // );
    // }
}
