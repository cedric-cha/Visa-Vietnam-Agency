<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SetupFastTrackFeature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-fast-track-feature';

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
        Artisan::call('migrate');
        Artisan::call('db:seed --class=TimeSlotSeeder');

        $fastTrackEntryPorts = [
            'Tan Son Nhat airport - Ho Chi Minh city (SGN)',
            'Noi Bai airport - Hanoi city (HAN)',
            'Da Nang airport - Da Nang city (DAD)',
        ];

        DB::table('entry_ports')
            ->orderBy('id')
            ->chunkById(100, function (Collection $data) use ($fastTrackEntryPorts) {
                foreach ($data as $datum) {
                    if (in_array($datum->name, $fastTrackEntryPorts)) {
                        DB::table('entry_ports')
                            ->where('id', $datum->id)
                            ->update(['is_fast_track' => 1]);
                    }
                }
            });
    }
}
