<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pairs', function (Blueprint $table) {
            $table->id();
            $table->string('pair_name');
            $table->unsignedBigInteger('pair_info_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('auditorium_id')->nullable();
            $table->unsignedBigInteger('discipline_id');
            $table->unsignedBigInteger('day_of_week_id');
            $table->unsignedBigInteger('repeating_id');
            $table->timestamps();
            $table->foreign('pair_info_id')
                ->references('id')
                ->on('pair_infos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreign('auditorium_id')
                ->references('id')
                ->on('auditoriums')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreign('discipline_id')
                ->references('id')
                ->on('disciplines')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreign('day_of_week_id')
                ->references('id')
                ->on('days_of_week')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('repeating_id')
                ->references('id')
                ->on('pair_repeatings')
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
        Schema::dropIfExists('pairs');
    }
}
