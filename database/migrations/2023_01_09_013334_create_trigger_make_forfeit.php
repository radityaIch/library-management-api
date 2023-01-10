<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS `add_forfeit_when_late_or_missing`");
        DB::unprepared("CREATE DEFINER=`root`@`localhost` TRIGGER `add_forfeit_when_late_or_missing` AFTER UPDATE ON `lends` FOR EACH ROW IF (NEW.status_peminjaman = 'terlambat')
        THEN
            INSERT INTO `forfeits` VALUES(NULL, NEW.id, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
    ELSEIF (NEW.status_peminjaman = 'hilang')
        THEN
            INSERT INTO `forfeits` VALUES(NULL, NEW.id, 2, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP); END IF");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS `add_forfeit_when_late_or_missing`");
    }
};
