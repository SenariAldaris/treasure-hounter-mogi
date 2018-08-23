<?php

use App\Game;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('winner_id')->unsigned()->nullable();
            $table->foreign('winner_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('status');
            $table->integer('items');
            $table->float('price');
            $table->timestamp('started_at');
            $table->timestamp('finished_at');
            $table->json('won_items');
            $table->integer('status_prize');
            $table->string('rand_number');
            $table->timestamps();
        });
        $rand_number = "0.".mt_rand(100000000,999999999).mt_rand(100000000,999999999);
        Game::create(['rand_number' => $rand_number]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games');
    }
}
