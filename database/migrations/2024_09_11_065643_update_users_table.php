<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove the 'email' column if it exists
            if (Schema::hasColumn('users', 'email')) {
                $table->dropColumn('email');
            }

            // Remove the 'email_verified_at' column if it exists
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }

            // Add new columns
            $table->integer('verification_code')->nullable();  // Add verification_code
            $table->timestamp('verified_at')->nullable();  // Add verified_at

            // Ensure the 'phone' column is unique
            $table->string('phone')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back the 'email' column
            $table->string('email')->unique()->nullable();  // Make it nullable if previously it was optional

            // Add back the 'email_verified_at' column
            $table->timestamp('email_verified_at')->nullable();

            // Remove the new columns added
            $table->dropColumn('verification_code');
            $table->dropColumn('verified_at');

            // Revert the 'phone' column to non-unique
            $table->string('phone')->change(); // Remove unique constraint if necessary
        });
    }
}
