<?php

namespace App\Console\Commands;

use App\Exports\P2PTracker as ExportsP2PTracker;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class P2PTracker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyP2PTracker:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Daily P2P Tracker to DU';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        // return Command::SUCCESS;
        Excel::store(new ExportsP2PTracker, 'vocus-daily-p2p-tracker.xlsx', 'azure');
        $details = [
            'pdf_location' => 'https://salmanrajzzdiag.blob.core.windows.net/vocus/vocus-daily-p2p-tracker.xlsx',
            'subject' => 'Home Wifi Tracker Report ' . Carbon::now()->subDay()->format('F Y'),
            'email_name' => 'Vocus',
            'send_mail' => 'hwtracker@vocus.ae'
            // 'subject' => 'Sales Report Month Year TTF till ' . Carbon::now()->subDay()->format('d F Y'),
        ];
        // \Mail::to(['salmanahmed334@gmail.com'])
        // \Mail::
        \Mail::mailer('smtp2')
        // ->to(['azeem@vocus.ae', 'sales@vocus.ae'])
        ->to(['parhakooo@gmail.com'])
        ->cc(['salmanahmed334@gmail.com', 'parhakooo@gmail.com'])
        ->bcc(['salmanahmed334@gmail.com'])
        // ->from('crm.riuman.com','riuman')
        ->send(new \App\Mail\DailyHWTracker($details));
    }
}
