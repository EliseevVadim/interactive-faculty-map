<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditoriumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditoriums', function (Blueprint $table) {
            $table->id();
            $table->string('auditorium_name');
            $table->json('position_info');
            $table->unsignedBigInteger('floor_id');
            $table->unsignedBigInteger('holder_id')->nullable();
            $table->timestamps();
            $table->foreign('floor_id')
                ->references('id')
                ->on('floors')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreign('holder_id')
                ->references('id')
                ->on('teachers')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auditoria');
    }
}
