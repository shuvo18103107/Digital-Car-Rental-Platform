<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')
            ->where('key', 'owner_signature_path')
            ->where('value', 'signatures/owner_signature.png') // only fix wrong value
            ->update([
                'value' => 'private/signatures/owner_signature.png',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('settings')
            ->where('key', 'owner_signature_path')
            ->where('value', 'private/signatures/owner_signature.png')
            ->update([
                'value' => 'signatures/owner_signature.png',
                'updated_at' => now(),
            ]);
    }
};