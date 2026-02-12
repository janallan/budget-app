<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('salary_type')->nullable()->default(null);
            $table->json('salary_options')->nullable()->default(null);
            $table->timestamps();
        });

        foreach (DB::table('users')->pluck('id') as $accountId) {
            DB::table('account_settings')->insert([
                'account_id' => $accountId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_settings');
    }
};
