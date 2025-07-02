<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hash all existing PINs in the database
        $users = DB::table('users')->whereNotNull('pin')->get();
        
        foreach ($users as $user) {
            // Only hash if the PIN is not already hashed (simple check: if it's 4 digits, it's not hashed)
            if (strlen($user->pin) == 4 && is_numeric($user->pin)) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['pin' => Hash::make($user->pin)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed as we cannot unhash the PINs
        // If you need to rollback, you'll need to regenerate new PINs for all users
    }
};
