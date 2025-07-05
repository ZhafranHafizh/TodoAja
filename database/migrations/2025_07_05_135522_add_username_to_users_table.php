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
        // Check if column already exists
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->after('name');
            });
        }
        
        // Add default usernames to existing users
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
        
        // Add unique constraint if it doesn't exist
        $indexes = DB::select("SHOW INDEX FROM users WHERE Column_name = 'username'");
        if (empty($indexes)) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('username');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
