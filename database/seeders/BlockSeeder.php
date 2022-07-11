<?php

namespace Database\Seeders;

use App\Models\Block;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = Room::all();

        Block::factory(50)->make()->each(function($block) use ($rooms) {
            $block->room_id = $rooms->random()->id;
            $block->save();
        });
    }
}
