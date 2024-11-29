<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agencies', function (Blueprint $table) {
            // Drop the 'email' column if it exists
            $table->dropColumn('email');

            // Make the 'number' column unique
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
        Schema::table('agencies', function (Blueprint $table) {
            // Re-add the 'email' column (you might need to adjust its type and options)
            $table->string('email')->nullable(); // Adjust according to the original type

            // Remove uniqueness from the 'number' column
            $table->string('phone')->change();
        });
    }
}
