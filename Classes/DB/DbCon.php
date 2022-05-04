    <?php

    class DbCon
    {
        
        public static $PDO;

        public static function innit() {
            $host = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Roomers";
            self::$PDO = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");

        }

    }

    DbCon::innit();
    ?>
