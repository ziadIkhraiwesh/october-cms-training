<?php namespace Ziad\Services\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ziad_services_services', function (Blueprint $table) {
            $table
                ->unsignedBigInteger('category_id')
                ->nullable()
                ->after('id');

            $table
                ->foreign('category_id')
                ->references('id')
                ->on('ziad_services_service_categories')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('ziad_services_services', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};