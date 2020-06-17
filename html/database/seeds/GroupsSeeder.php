<?php

use App\Models\Groups;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('groups')->truncate();

        for ($i = 1; $i < 11; $i++) {
            Groups::create(['label' => "Group #$i"]);
        }
    }
}
