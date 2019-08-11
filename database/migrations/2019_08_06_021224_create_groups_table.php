<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group_name');
            $table->text('group_desc');
            $table->integer('user_id');
            $table->integer('group_capacity');
            $table->integer('group_save_amt');
            $table->integer('is_searchable');
            $table->integer('group_type');
            $table->timestamp('group_start_month');
            $table->string('group_unique_id')->unique();
            $table->integer('group_status')->default(1);
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
        Schema::dropIfExists('groups');
    }
}
