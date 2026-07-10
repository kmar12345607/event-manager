<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->string('ticket_code', 20)->nullable()->unique()->after('id');
            $table->timestamp('checked_in_at')->nullable()->after('attendance_status');
        });
    }

    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn(['ticket_code', 'checked_in_at']);
        });
    }
};
