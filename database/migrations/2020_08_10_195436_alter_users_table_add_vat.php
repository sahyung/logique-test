<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAddVat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('membership')->nullable();
            $table->string('fee')->nullable();
            $table->string('vat')->default('10')->comment('vat in %');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'membership')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('membership');
            });
        }
        if (Schema::hasColumn('users', 'fee')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('fee');
            });
        }
        if (Schema::hasColumn('users', 'vat')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('vat');
            });
        }
    }
}
