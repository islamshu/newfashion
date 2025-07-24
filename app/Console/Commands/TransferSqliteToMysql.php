<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TransferSqliteToMysql extends Command
{
    protected $signature = 'transfer:sqlite-to-mysql';
    protected $description = 'Transfer all data from SQLite to MySQL';

    public function handle()
    {
        $this->info('Starting transfer from SQLite to MySQL...');

        $sqliteTables = DB::connection('sqlite_source')->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");

        foreach ($sqliteTables as $tableObj) {
            $table = $tableObj->name;

            // تجاوز جدول migrations إذا أردت
            if ($table === 'migrations') {
                continue;
            }

            $this->info("Transferring table: $table");

            try {
                $records = DB::connection('sqlite_source')->table($table)->get();

                foreach ($records as $record) {
                    DB::connection('mysql')->table($table)->insert((array)$record);
                }

                $this->info("✓ Done: $table");
            } catch (\Exception $e) {
                $this->error("✗ Failed on $table: " . $e->getMessage());
            }
        }

        $this->info('✅ Transfer complete.');
    }
}
