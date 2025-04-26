<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;

class dbcreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {connecton?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new MySQL database based on the database config file or the provided name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $env = config('app.env');

        $connection = 'mysql';

        if($env === 'test') {
            $connection .= "_testing";
        }
        $schemaName = config("$connection.database");
        $userName = config("$connection.username");
        $userPassword = config("$connection.password");
        $charset = config("$connection.charset",'utf8mb4');
        $collation = config("$connection.collation",'utf8mb4_unicode_ci');
        $dbUser = "'$userName'@localhost";

        config(["$connection.database" => null]);

        $query = "CREATE DATABASE IF NOT EXISTS $schemaName CHARACTER SET $charset COLLATE $collation;";

        $ok = DB::statement($query);

        if(!$ok) {
            $this->error("Database '$schemaName' creation went wrong!");
            return 1;
        }

        $query = "CREATE USER $dbUser IDENTIFIED BY '$userPassword';";
        $ok = DB::statement($query);

        if(!$ok) {
            $this->error("User '$userName' creation went wrong!");
            return 1;
        }

        $query = "GRANT ALL PRIVILEGES ON $schemaName.* TO $dbUser IDENTIFIED BY '$userPassword';";
        $ok = DB::statement($query);

        if(!$ok) {
            $this->error("Granting privileges to user '$userName' went wrong!");
            return 1;
        }

        config(["$connection.database" => $schemaName]);

        $message = "Database $schemaName created successfully!";
        if(!$ok) {
            $message = "Database $schemaName creation went wrong!";
        }

        $this->info($message);

        return 0;
    }
}
