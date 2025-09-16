<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedTinyInteger('role_tmp')
                    ->nullable()
                    ->after('password')
                    ->comment('10:employee, 90:admin');
            });

            DB::table('users')->update([
                'role_tmp' => DB::raw("
                    CASE
                        WHEN role = 'admin' OR role = 90 THEN 90
                        WHEN role = 'user'  OR role = 10 THEN 10
                        WHEN role IS NULL THEN 10
                        ELSE 10
                    END
                "),
            ]);

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });

            DB::statement("
                ALTER TABLE users
                CHANGE COLUMN role_tmp role TINYINT UNSIGNED NOT NULL DEFAULT 10
                COMMENT '10:employee, 90:admin'
            ");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedTinyInteger('role')
                    ->default(10)
                    ->after('password')
                    ->comment('10:employee, 90:admin');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role_enum', ['admin', 'user'])
                    ->default('user')
                    ->after('password');
            });

            DB::table('users')->update([
                'role_enum' => DB::raw("
                    CASE
                        WHEN role = 90 OR role = 'admin' THEN 'admin'
                        ELSE 'user'
                    END
                "),
            ]);

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });

            DB::statement("
                ALTER TABLE users
                CHANGE COLUMN role_enum role ENUM('admin','user') NOT NULL DEFAULT 'user'
            ");
        }
    }
};
