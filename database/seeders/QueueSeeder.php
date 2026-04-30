<?php

namespace Database\Seeders;

use App\Models\Features\Queue;
use App\Models\Features\Counter;
use Illuminate\Database\Seeder;

class QueueSeeder extends Seeder
{
    public function run(): void
    {
        // Seed counters
        $counters = [
            ['name' => 'Counter 1', 'code' => 'C1', 'status' => 'active'],
            ['name' => 'Counter 2', 'code' => 'C2', 'status' => 'active'],
            ['name' => 'Counter 3', 'code' => 'C3', 'status' => 'active'],
            ['name' => 'Counter 4', 'code' => 'C4', 'status' => 'active'],
            ['name' => 'Counter 5', 'code' => 'C5', 'status' => 'busy'],
            ['name' => 'Counter 6', 'code' => 'C6', 'status' => 'closed'],
        ];

        foreach ($counters as $counter) {
            Counter::firstOrCreate(['code' => $counter['code']], $counter);
        }

        // Seed sample queue tickets
        $tickets = [
            ['ticket_number' => 'A001', 'category' => 'A', 'status' => 'done'],
            ['ticket_number' => 'A002', 'category' => 'A', 'status' => 'done'],
            ['ticket_number' => 'B001', 'category' => 'B', 'status' => 'serving', 'counter_id' => 1],
            ['ticket_number' => 'C001', 'category' => 'C', 'status' => 'serving', 'counter_id' => 2],
            ['ticket_number' => 'A003', 'category' => 'A', 'status' => 'waiting'],
            ['ticket_number' => 'A004', 'category' => 'A', 'status' => 'waiting'],
            ['ticket_number' => 'B002', 'category' => 'B', 'status' => 'waiting'],
            ['ticket_number' => 'C002', 'category' => 'C', 'status' => 'waiting'],
        ];

        foreach ($tickets as $ticket) {
            Queue::firstOrCreate(
                ['ticket_number' => $ticket['ticket_number']],
                $ticket
            );
        }
    }
}