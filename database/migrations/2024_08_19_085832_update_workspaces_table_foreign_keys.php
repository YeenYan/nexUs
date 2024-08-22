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
        Schema::table('workspace__collabs', function (Blueprint $table) {

            // Add foreign key constraints for the new columns
            $table->foreign('workspace_id')->references('workspace_id')->on('workspaces')->onDelete('cascade');
            $table->foreign('owner_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('member_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workspace__collabs', function (Blueprint $table) {
            // Drop the new foreign keys and columns
            $table->dropForeign(['workspace_id']);
            $table->dropForeign(['owner_id']);
            $table->dropForeign(['member_id']);
            $table->dropColumn(['workspace_id', 'owner_id', 'member_id']);
        });
    }
};
