<?php

namespace App\Console\Commands;

use App\Enums\OrderServiceType;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SetOrderDefaultService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-order-default-service';

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
        DB::table('orders')
            ->orderBy('id')
            ->chunkById(100, function (Collection $data) {
                foreach ($data as $datum) {
                    DB::table('orders')
                        ->where('id', $datum->id)
                        ->update(['service' => OrderServiceType::EVISA->value]);
                }
            });
    }
}
