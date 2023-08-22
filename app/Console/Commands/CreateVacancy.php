<?php

namespace App\Console\Commands;

use App\Jobs\Preprocessing;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CreateVacancy extends Command
{
    public function __construct()
    {
        parent::__construct();
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-vacancy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $vacancies = DB::table('vacancies_copy1')->whereRaw('id NOT IN (SELECT id FROM vacancies)')->where('added', 0)->limit(2)->get();
        foreach ($vacancies as $vacancy) {
            $tr = new GoogleTranslate();
            $tr->setSource();
            $tr->setTarget('id');
            $description = $tr->translate($vacancy->description);
            $data = Vacancy::create([
                'company_id' => $vacancy->company_id,
                'position' => $vacancy->position,
                'job_type' => $vacancy->job_type,
                'description' => $description,
                'information' => $vacancy->information,
                'max_applicants' => $vacancy->max_applicants,
                'status' => $vacancy->status,
                'deadline' => Carbon::now()->addDays(rand(3, 20))->format('Y-m-d'),
            ]);
            Preprocessing::dispatch($data->id);
            DB::table('vacancies_copy1')->where('id', $vacancy->id)->update(['added' => 1]);
        }
    }
}
