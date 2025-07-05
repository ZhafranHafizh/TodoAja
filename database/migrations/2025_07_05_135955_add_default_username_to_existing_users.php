<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add default usernames to existing users before adding the unique constraint
        $users = DB::table('users')->whereNull('username')->get();
        
        foreach ($users as $index => $user) {
            $baseUsername = explode('@', $user->email)[0];
            $username = $baseUsername;
            $counter = 1;
            
            // Ensure username is unique
            while (DB::table('users')->where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }
            
            DB::table('users')
                ->where('id', $user->id)
                ->update(['username' => $username]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nothing to reverse as we're just updating existing data
    }
};
