<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::unprepared("DROP TRIGGER IF EXISTS update_book_qty");
        DB::unprepared("CREATE TRIGGER update_book_qty AFTER INSERT ON lends FOR EACH ROW UPDATE books SET books.qty = books.qty-1 WHERE books.id = NEW.id_buku");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS update_book_qty");
    }
};
