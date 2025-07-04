<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\Reservation;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ProcessNoShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-no-shows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('Scheduled Task: Running ProcessNoShows.');

        $today = Carbon::now()->toDateString();

        $noShowReservations = Reservation::where('check_in_date', $today)
            ->where('status', 'confirmed_guaranteed')
            ->get();

        if ($noShowReservations->isEmpty()) {
            info('Scheduled Task: No no-shows found.');
            return 0;
        }

        $processedCount = 0;
        foreach ($noShowReservations as $reservation) {
            DB::transaction(function () use ($reservation, &$processedCount) {
                $reservation->update(['status' => 'no_show']);

                $reservationService = app('App\Services\ReservationService');

                if (!$reservation->bill) {
                    $reservationService->generateAndGetBill($reservation, 'paid');
                }

                $processedCount++;
                info("Reservation #{$reservation->id} processed as no-show and billed.");
            });
        }

        info("Scheduled Task: Processed {$processedCount} no-show reservation(s).");

        return 0;
    }
}
