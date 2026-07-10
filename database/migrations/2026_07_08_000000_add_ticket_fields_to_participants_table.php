<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->string('ticket_code')->nullable()->unique()->after('id');
            $table->timestamp('checked_in_at')->nullable()->after('attendance_status');
        });

        $participants = DB::table('participants')->whereNull('ticket_code')->orderBy('id')->get();

        foreach ($participants as $participant) {
            do {
                $code = 'EVT' . str_pad($participant->event_id, 3, '0', STR_PAD_LEFT)
                      . '-' . strtoupper(Str::random(6));
            } while (DB::table('participants')->where('ticket_code', $code)->exists());

            DB::table('participants')->where('id', $participant->id)->update(['ticket_code' => $code]);
        }
    }

    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn(['ticket_code', 'checked_in_at']);
        });
    }
};