<?php

namespace App\Jobs;

use App\Models\NotifiedVacancy;
use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $id;
    protected $to;
    protected $items;
    protected $content;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $content, $id = null, $items = null)
    {
        $this->id = $id;
        $this->to = $to;
        $this->items = $items;
        $this->content = $content;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to)->send($this->content);
        if ($this->id && $this->items) {
            foreach ($this->items as $item) {
                NotifiedVacancy::create([
                    'user_id' => $this->id,
                    'vacancy_id' => $item->id,
                ]);
            }
        }
    }
}
