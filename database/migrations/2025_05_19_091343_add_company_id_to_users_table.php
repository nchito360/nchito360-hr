<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // First add the column
            $table->unsignedBigInteger('company_id')->nullable()->after('id');

            // Then add the foreign key constraint
            $table->foreign('company_id')
                  ->references('id')->on('companies')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
};

