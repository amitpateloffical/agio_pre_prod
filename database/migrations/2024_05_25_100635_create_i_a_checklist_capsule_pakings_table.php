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
        Schema::create('i_a_checklist_capsule_pakings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ia_id')->nullable();
            for ($i = 1; $i <= 50; $i++) {
                $table->text("tablet_capsule_packing_$i")->nullable();
                 $table->text("tablet_capsule_packing_remark_$i")->nullable();
            }

            $table->string('tablet_capsule_packing_comment')->nullable();
            $table->longText('tablet_capsule_packing_attachment')->nullable();
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
        Schema::dropIfExists('i_a_checklist_capsule_pakings');
    }
};
