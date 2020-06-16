<?php declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Class PlayerSeeder
 */
class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('players')->updateOrInsert(['display_name' => env('DUMMY_PLAYER_DISPLAY_NAME')], [
            'display_name' => env('DUMMY_PLAYER_DISPLAY_NAME'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
