<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePlayersTable
 */
class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('players', static function (Blueprint $table): void {
            $table->id();
            $table->string('display_name')->unique()->nullable(false);
            $table->unsignedBigInteger('autogroup_id')->nullable(true)->default(null);
            $table->timestamps();

            $table->index('autogroup_id', 'autogroup_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
}
