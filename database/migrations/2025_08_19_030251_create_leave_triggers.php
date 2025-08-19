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
        // Perbaikan: Menambahkan `END;` dan `RETURN NEW;` ke dalam fungsi
        DB::unprepared('
            CREATE OR REPLACE FUNCTION process_leave_approval()
            RETURNS TRIGGER AS $$ 
            BEGIN
                IF NEW.status = \'approved\' AND OLD.status != \'approved\' AND NEW.type = \'cuti\' THEN
                    UPDATE users SET quota = GREATEST(0, quota -1) WHERE id = NEW.employee_id;
                END IF;
                -- Fungsi trigger harus mengembalikan baris yang diubah
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::unprepared('
            CREATE TRIGGER leave_approved
            AFTER UPDATE ON leaves
            FOR EACH ROW
            EXECUTE FUNCTION process_leave_approval();
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS leave_approved ON leaves;');
        DB::unprepared('DROP FUNCTION IF EXISTS process_leave_approval();');
    }
};

