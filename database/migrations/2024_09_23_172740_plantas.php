<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornada.plantas', function (Blueprint $table) {
            $table->id();
            $table->string('name_planta')->comment('Nome identificador da planta');
            $table->integer('status')->default(1)->comment('1 Ativo \ 0 Inativo');
            $table->longText('description')->comment('Descrição detalhada da planta')->nullable();
            $table->longText('image_one')->comment('Imagem da planta')->nullable();
            $table->longText('image_two')->comment('Imagem da planta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jornada.plantas');
    }
};
