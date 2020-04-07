<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSettingI18nsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_i18ns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('setting_id')->unsigned();
            $table->string('locale')->default('FR');
            $table->string('title');
            $table->string('value')->nullable();
            $table->string('help')->nullable();

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::table('setting_i18ns', function (Blueprint $table) {
            $table->foreign('setting_id')
                    ->references('id')->on('settings')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_i18ns');
    }
}
