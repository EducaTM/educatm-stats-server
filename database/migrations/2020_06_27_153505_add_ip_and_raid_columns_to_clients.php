<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpAndRaidColumnsToClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->ipAddress('last_ip')->nullable()->after('hostname');
            $table->json('raid')->nullable()->after('last_ip'); // Remote Access ID; Ex: Anydesk, TeamViewer etc.
            $table->dateTime('last_active')->nullable()->after('raid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('ip');
            $table->dropColumn('raid');
            $table->dropColumn('last_active');
        });
    }
}
