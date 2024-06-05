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
        Schema::create('market_complaint_audit_trials', function (Blueprint $table) {
            $table->id();
            $table->string('market_id');
            $table->string('activity_type');
            $table->longText('previous');
            $table->string('stage');
            $table->longText('current');
            $table->longText('comment');
            $table->string('user_id');
            $table->string('user_name');
            $table->string('origin_state');
            $table->string('user_role');
            $table->longText('change_to');
            $table->longText('change_from');
            $table->longText('action_name');
            $table->softDeletes();
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
        Schema::dropIfExists('market_complaint_audit_trials');
    }
};
