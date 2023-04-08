<?php

namespace App\Console\Commands;

use App\Models\lead_sale;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BossUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'BossUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::today()->toDateString();
        // return Command::SUCCESS;
        $cc = \App\Models\call_center::where('status', 1)->get();
        foreach ($cc as $c) {
            $hw_cc_wise_month = lead_sale::where('lead_sales.lead_type', 'HomeWifi')
            ->Join(
                'users',
                'users.id',
                'lead_sales.saler_id'
            )
            ->where('users.agent_code', $c->call_center_name)
            ->whereIn('lead_sales.status', ['1.02'])->whereMonth('lead_sales.updated_at', Carbon::now()->month)->get()->count();
            $p2p_cc_wise_month = lead_sale::where('lead_sales.lead_type', 'P2P')
            ->Join(
                'users',
                'users.id',
                'lead_sales.saler_id'
            )
            ->where('users.agent_code', $c->call_center_name)
            ->whereIn('lead_sales.status', ['1.02'])->whereMonth('lead_sales.updated_at', Carbon::now()->month)->get()->count();
            $mnp_cc_wise_month = lead_sale::where('lead_sales.lead_type', 'MNP')
            ->Join(
                'users',
                'users.id',
                'lead_sales.saler_id'
            )
            ->where('users.agent_code', $c->call_center_name)
            ->whereIn('lead_sales.status', ['1.02'])->whereMonth('lead_sales.updated_at', Carbon::now()->month)->get()->count();
            //
            //
            $hw_cc_wise_daily = lead_sale::where('lead_sales.lead_type', 'HomeWifi')
            ->Join(
                'users',
                'users.id',
                'lead_sales.saler_id'
            )
            ->where('users.agent_code', $c->call_center_name)
            ->whereIn('lead_sales.status', ['1.08', '1.02', '1.11'])->whereDate('lead_sales.created_at', Carbon::today())->get()->count();
            $p2p_cc_wise_daily = lead_sale::where('lead_sales.lead_type', 'P2P')
            ->Join(
                'users',
                'users.id',
                'lead_sales.saler_id'
            )
            ->where('users.agent_code', $c->call_center_name)
            ->whereIn('lead_sales.status', ['1.08', '1.02', '1.11'])->whereDate('lead_sales.created_at', Carbon::today())->get()->count();
            $mnp_cc_wise_daily = lead_sale::where('lead_sales.lead_type', 'MNP')
            ->Join(
                'users',
                'users.id',
                'lead_sales.saler_id'
            )
            ->where('users.agent_code', $c->call_center_name)
            ->whereIn('lead_sales.status', ['1.08', '1.02', '1.11'])->whereDate('lead_sales.created_at', Carbon::today())->get()->count();
            // $p2p = lead_sale::where('lead_type', 'P2P')->whereIn('status', ['1.02'])->whereDate('lead_sales.created_at', Carbon::today())->get()->count();
            // $mnp = lead_sale::where('lead_type', 'MNP')->whereIn('status', ['1.02'])->whereDate('lead_sales.created_at', Carbon::today())->get()->count();
            $details_cccwise_month = [
                'wifi_count_monthly' => $hw_cc_wise_month,
                'p2p_count_monthly' => $p2p_cc_wise_month,
                'mnp_count_monthly' => $mnp_cc_wise_month,
                'wifi_count_daily' => $hw_cc_wise_daily,
                'p2p_count_daily' => $p2p_cc_wise_daily,
                'mnp_count_daily' => $mnp_cc_wise_daily,
                'date' => $date,
                'number' => '923121337222,971522221220',
                'cc_name' => $c->call_center_name,
            ];
            \App\Http\Controllers\FunctionController::SendWhatsAppDailyUpdateCCWiseBoss($details_cccwise_month);
        }
    }
}
