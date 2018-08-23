<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('img');
            $table->float('price');
        });
        \App\Ticket::create([
            'name' => 'Карточка на 315 руб',
            'img'  => 'assets/img/tickets/card_1.png',
            'price' => 315
        ]);
        \App\Ticket::create([
            'name' => 'Карточка на 630 руб',
            'img'  => 'assets/img/tickets/card_2.png',
            'price' => 630
        ]);
        \App\Ticket::create([
            'name' => 'Карточка на 1575 руб',
            'img'  => 'assets/img/tickets/card_3.png',
            'price' => 1575
        ]);
        \App\Ticket::create([
            'name' => 'Карточка на 3150 руб',
            'img'  => 'assets/img/tickets/card_4.png',
            'price' => 3150
        ]);
        \App\Ticket::create([
            'name' => 'Карточка на 6300 руб',
            'img'  => 'assets/img/tickets/card_5.png',
            'price' => 6300
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tickets');
    }
}
