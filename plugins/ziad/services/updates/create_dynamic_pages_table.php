<?php
namespace Ziad\Services\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create('ziad_services_dynamic_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('slug', 150)->unique();
            $table->string('status', 20)->default('draft');
            $table->string('seo_title', 160)->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->boolean('show_in_navigation')->default(false);
            $table->unsignedInteger('navigation_order')->default(0);
            $table->json('sections')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index(
                ['show_in_navigation', 'navigation_order'],
                'dynamic_pages_navigation_index'
            );
        });
    }

    public function down()
    {
        Schema::dropIfExists('ziad_services_dynamic_pages');
    }
};