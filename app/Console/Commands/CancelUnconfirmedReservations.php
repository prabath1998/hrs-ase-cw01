<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CancelUnconfirmedReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-unconfirmed-reservations';

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
        info('Scheduled Task: Running CancelUnconfirmedReservations.');

        $today = Carbon::now()->toDateString();

        $reservationsToCancel = Reservation::where('check_in_date', $today)
            ->where('status', 'confirmed_no_cc_hold')
            ->get();

        if ($reservationsToCancel->isEmpty()) {
            info('Scheduled Task: No unconfirmed reservations found.');
            return 0;
        }

        $cancelledCount = 0;
        foreach ($reservationsToCancel as $reservation) {
            $reservation->update(['status' => 'cancelled_system']);
            $cancelledCount++;
            info("Reservation #{$reservation->id} cancelled by system.");

            // TODO: dispatch a notification email
        }

        info("Scheduled Task: Cancelled {$cancelledCount} reservation(s).");

        return 0;
    }
}
