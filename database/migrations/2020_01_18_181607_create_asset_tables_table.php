<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_tables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('inv_number')->nullable();
            $table->string('erp_number')->nullable();
            $table->text('description1')->nullable();
            $table->text('description2')->nullable();
            $table->string('code')->nullable();
            $table->decimal('price',10,2)->nullable();
            $table->string('location')->nullable();
            $table->string('room')->nullable();
            $table->string('year')->nullable();
            $table->string('user_manage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_tables');
    }
}
