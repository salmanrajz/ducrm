<?php

namespace App\Console\Commands;

use App\Exports\DailyHWTracker;
use App\Exports\HomeWifiTracker;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class DailyHWTrackerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyHWTracker:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Daily HW Tracker to DU';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        Excel::store(new HomeWifiTracker, 'vocus-daily-hw-tracker.xlsx', 'azure');
        $details = [
            'pdf_location' => 'https://salmanrajzzdiag.blob.core.windows.net/vocus/vocus-daily-hw-tracker.xlsx',
            'subject' => 'Home Wifi Tracker Report ' . Carbon::now()->subDay()->format('F Y'),
            'email_name' => 'Vocus',
            'send_mail' => 'hwtracker@vocus.ae'
            // 'subject' => 'Sales Report Month Year TTF till ' . Carbon::now()->subDay()->format('d F Y'),
        ];
        // \Mail::to(['salmanahmed334@gmail.com'])
        // \Mail::
        \Mail::mailer('smtp2')
        ->to(['azeem@vocus.ae','sales@vocus.ae'])
        // ->to(['parhakooo@gmail.com'])
        ->cc(['salmanahmed334@gmail.com','parhakooo@gmail.com'])
        ->bcc(['salmanahmed334@gmail.com'])
        // ->from('crm.riuman.com','riuman')
        ->send(new \App\Mail\DailyHWTracker($details));
    }
}
