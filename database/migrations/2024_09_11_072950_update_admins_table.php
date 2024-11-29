<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            // Remove 'email' column if it exists
            if (Schema::hasColumn('admins', 'email')) {
                $table->dropColumn('email');
            }

            // Remove 'email_verified_at' column if it exists
            if (Schema::hasColumn('admins', 'email_verified_at')) {
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
        Schema::table('admins', function (Blueprint $table) {
            // Add back 'email' column
            $table->string('email')->unique()->nullable();  // Adjust nullable as needed

            // Add back 'email_verified_at' column
            $table->timestamp('email_verified_at')->nullable();

            // Remove new columns added
            $table->dropColumn('verification_code');
            $table->dropColumn('verified_at');

            // Revert 'phone' column to non-unique
            $table->string('phone')->change(); // Remove unique constraint if needed
        });
    }
}
