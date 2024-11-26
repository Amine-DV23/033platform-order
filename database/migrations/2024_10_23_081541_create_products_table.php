<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'note')) {
                    $table->text('note')->nullable();
                }
                if (!Schema::hasColumn('products', 'image')) {
                    $table->string('image')->nullable(); // Add image column
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->dropColumn('image'); // Remove image column
        });
    }
};
