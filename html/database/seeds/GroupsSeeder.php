<?php

use App\Models\Groups;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    private const DUMMY_CONST_COUNT = 30;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('groups')->truncate();

        for ($i = 1; $i < (self::DUMMY_CONST_COUNT + 1); $i++) {
            Groups::create(['label' => "Group #$i"]);
        }
    }
}
