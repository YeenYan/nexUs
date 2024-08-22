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
        Schema::create('workspace__collabs', function (Blueprint $table) {
            $table->uuid('workspace_collab_id')->primary();
            $table->uuid('workspace_id');
            $table->uuid('owner_id');
            $table->uuid('member_id');
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
        Schema::dropIfExists('workspace__collabs');
    }
};
