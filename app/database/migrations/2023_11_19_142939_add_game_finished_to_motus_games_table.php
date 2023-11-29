<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('motus_games', function (Blueprint $table) {
            $table->boolean('game_finished')->default(false)->after('is_won');
        });
    }

    public function down()
    {
        Schema::table('motus_games', function (Blueprint $table) {
            $table->dropColumn('game_finished');
        });
    }
};
