<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('uploads', function (Blueprint $table) {
            $table->decimal('duration')->default(0);
            $table->unsignedBigInteger('visibility')->default(2);
            $table->foreign('visibility')->references('id')->on('visibility_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uploads', function (Blueprint $table) {
            $table->dropColumn('duration');
            $table->dropForeign(['visibility']);
            $table->dropColumn('visibility');
        });
    }
};
