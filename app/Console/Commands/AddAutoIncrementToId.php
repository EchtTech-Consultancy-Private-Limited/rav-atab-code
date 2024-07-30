<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAutoIncrementToId extends Command
{
    protected $signature = 'db:add-auto-increment';

    protected $description = 'Add auto-increment to id columns in all tables';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get a list of all tables
        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');

        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_$dbName"};

            if (Schema::hasColumn($tableName, 'id')) {
                $this->info("Processing table: $tableName");

                // Check if the id column is already an auto-increment column
                $column = DB::select("SHOW COLUMNS FROM $tableName LIKE 'id'")[0];
                if (strpos($column->Extra, 'auto_increment') === false) {
                    // Modify the id column to add auto-increment
                    DB::statement("ALTER TABLE $tableName MODIFY id INT AUTO_INCREMENT");

                    $this->info("Added auto-increment to id column in table: $tableName");
                } else {
                    $this->info("id column in table: $tableName is already an auto-increment column");
                }
            } else {
                $this->warn("Table: $tableName does not have an id column");
            }
        }

        $this->info('Operation completed.');
    }
}
