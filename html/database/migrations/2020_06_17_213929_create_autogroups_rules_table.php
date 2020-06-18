<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateAutogroupsRulesTable
 */
class CreateAutogroupsRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autogroups_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable(false);
            $table->unsignedSmallInteger('weight')->nullable(false)->default(0);
            $table->timestamp('created_at', 0)->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autogroups_rules');
    }
}
