<?php

namespace App\Console\Commands;

use App\Jobs\SendEmail;
use App\Mail\RecommendationMail;
use App\Models\Keyword;
use App\Models\NotifiedVacancy;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AutoVacancyAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-vacancy-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will send email to user based on their keyword';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Start sending email to user based on their keyword');
        $latestUserNotified = null;
        $latestDelay = 2;
        $minWeight = 0.15;
        $keywords = Keyword::orderBy('created_at', 'desc')->with('user')->get();

        $this->info('Fetching data from database...');
        if ($keywords->count() > 0) {
            foreach ($keywords as $item) {
                // $pages = 0;
                $page = 1;
                $loker = Vacancy::active()
                    ->whereHas('company', function ($query) {
                        $query->whereNotNull('logo');
                    })
                    ->whereDoesntHave('applicants', function ($query) use ($item) {
                        // eliminate vacancy that has been applied by user
                        $query->where('user_id', $item->user_id);
                    })->whereDoesntHave('notifiedUsers', function ($query) use ($item) {
                        // eliminate vacancy that has been notified to user
                        $query->where('user_id', $item->user_id);
                    });

                $lokerBindings = [];
                foreach ($loker->getBindings() as $value) {
                    $lokerBindings[] = "'$value'";
                }
                $lokerQuery = Str::replaceArray('?', $lokerBindings, $loker->toSql());

                $response = Http::get('http://' . env('CBRS_HOST') . ':' . env('CBRS_PORT') . '/search/' . $item->keyword, [
                    'customquery' => $lokerQuery,
                    'min' => $minWeight,
                    'page' => $page
                ])->object();

                if ($response && count($response->data) > 0 && $response->pages > 0) {
                    // $pages = $response->pages;
                    $vacancies = collect();
                    foreach ($response?->data as $vacancy) {
                        $vacancy = Vacancy::where('id', $vacancy->id)->with('company')->first();
                        $vacancies->push($vacancy);
                    }

                    $this->info('Sending email to user...');
                    if ($latestUserNotified == $item->user_id) {
                        $latestDelay += 43;
                    } else {
                        $latestDelay = 2;
                    }
                    $details = new RecommendationMail([
                        'subject' => 'Pekerjaan yang mungkin cocok untuk kamu - Bursa Kerja Khusus',
                        'title' => 'Pekerjaan yang mungkin cocok untuk kamu',
                        'vacancies' => $vacancies,
                    ]);
                    $emailJob = (new SendEmail($item->user->email, $details, $item->user->id, $vacancies))
                        ->delay(Carbon::now()->addMinutes($latestDelay));
                    dispatch($emailJob);
                    // Mail::to($item->user->email)->send(new RecommendationMail([
                    //     'subject' => 'Pekerjaan yang mungkin cocok untuk kamu - Bursa Kerja Khusus',
                    //     'title' => 'Pekerjaan yang mungkin cocok untuk kamu',
                    //     'vacancies' => $vacancies,
                    // ]));
                    $latestUserNotified = $item->user_id;
                }
            }
        }
        $this->info('Email sent successfully');
    }
}
