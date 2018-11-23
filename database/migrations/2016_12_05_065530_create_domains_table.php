<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id')->index();
            $table->string('name')->unique();
            $table->string('name_ascii')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->unsignedInteger('soa_serial');
            $table->unsignedInteger('soa_refresh');
            $table->unsignedInteger('soa_retry');
            $table->unsignedInteger('soa_expire');
            $table->unsignedInteger('soa_ttl');
            $table->unsignedInteger('record_count')->default(0);
            $table->unsignedInteger('max_records')->nullable();
            $table->timestamps();
            $table->timestamp('last_zone_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domains');
    }
}
