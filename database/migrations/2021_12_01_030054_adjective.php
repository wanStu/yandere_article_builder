<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Adjective extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjective', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->charset = 'utf8mb3';
             $table->collation = 'utf8mb3_general_ci';
            // CONTENT
            $table->increments('id')->nullable(false)->comment('');
			$table->string('content', 20)->nullable()->default(null)->comment('');
			$table->bigInteger('create_time')->nullable()->default(null)->comment('');
			$table->bigInteger('update_time')->nullable()->default(null)->comment('');
			$table->integer('is_delete')->nullable()->default(0)->comment('');
			$table->bigInteger('delete_time')->nullable()->default(null)->comment('');
			
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjective');
    }
}
