<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Component extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * 当表 component 不存在时执行迁移？（待测）
         */
        if(!Schema::hasTable("component")) {
            Schema::create('component', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->charset = 'utf8mb3';
                $table->collation = 'utf8mb3_general_ci';
                // CONTENT
                $table->increments('id')->nullable(false)->comment('');
                $table->integer('type')->nullable()->default(null)->comment('1 verb 动词 | 2 adjective 形容词 | 3 modal_particle 语气助词 | 4 noun 名词 | 5 punc_list 标点 | 6 personal_pronoun 人称代词 | 7 auxiliary 是');
                $table->string('content', 20)->nullable()->default(null)->comment('');
                $table->bigInteger('create_time')->nullable()->default(null)->comment('');
                $table->bigInteger('update_time')->nullable()->default(null)->comment('');
                $table->integer('is_delete')->nullable()->default(0)->comment('');
                $table->integer('delete_time')->nullable()->default(null)->comment('');

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component');
    }
}
