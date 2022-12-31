<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS update_after_lending");
        DB::unprepared("CREATE TRIGGER `update_after_lending` AFTER UPDATE ON `lends` FOR EACH ROW IF NEW.status_peminjaman = 'sudah dikembalikan' OR NEW.status_peminjaman = 'terlambat' THEN UPDATE books SET books.qty = books.qty + 1 WHERE books.id = NEW.id_buku; END IF;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS update_after_lending");
    }
};
