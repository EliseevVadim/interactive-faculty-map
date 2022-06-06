<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecondaryObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secondary_objects', function (Blueprint $table) {
            $table->id();
            $table->string('object_name')->nullable();
            $table->json('position_info');
            $table->unsignedBigInteger('floor_id');
            $table->timestamps();
            $table->foreign('floor_id')
                ->references('id')
                ->on('floors')
                ->cascadeOnDelete()
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
        Schema::dropIfExists('secondary_objects');
    }
}
