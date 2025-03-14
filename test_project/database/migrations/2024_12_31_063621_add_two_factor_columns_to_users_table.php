<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'two_factor_secret')) {
                $table->text('two_factor_secret')
                    ->after('password')
                    ->nullable();
            }

            if (!Schema::hasColumn('users', 'two_factor_recovery_codes')) {
                $table->text('two_factor_recovery_codes')
                    ->after('two_factor_secret')
                    ->nullable();
            }

            if (Fortify::confirmsTwoFactorAuthentication() && !Schema::hasColumn('users', 'two_factor_confirmed_at')) {
                $table->timestamp('two_factor_confirmed_at')
                    ->after('two_factor_recovery_codes')
                    ->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToRemove = [];

            if (Schema::hasColumn('users', 'two_factor_secret')) {
                $columnsToRemove[] = 'two_factor_secret';
            }

            if (Schema::hasColumn('users', 'two_factor_recovery_codes')) {
                $columnsToRemove[] = 'two_factor_recovery_codes';
            }

            if (Fortify::confirmsTwoFactorAuthentication() && Schema::hasColumn('users', 'two_factor_confirmed_at')) {
                $columnsToRemove[] = 'two_factor_confirmed_at';
            }

            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }
};