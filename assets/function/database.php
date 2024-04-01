<?php
include 'config.php';
?>

<?php
class Database
{
    public $host = DB_HOST;
    public $dbname = DB_NAME;
    public $username = DB_USER;
    public $password = DB_PASSWORD;
    public $link;
    public $error;

    public function __construct()
    {
        $this->connectDB();
    }

    private function connectDB()
    {
        $this->link = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->link->connect_error) {
            $this->error = "Error: " . $this->link->connect_error;
            return false;
        } else {
            echo "";
        }
    }

    public function select($query)
    {
        $result = $this->link->query($query);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function fetch_array($query)
    {
        $result = $this->link->query($query);
        $array = $result->fetch_assoc();
        if ($array) {
            return $array;
        } else {
            return false;
        }
    }

    public function insert($query)
    {
        $insert_row = $this->link->query($query);

        if ($insert_row) {
            return $insert_row;
        } else {
            return false;
        }
    }

    public function update($query)
    {
        $update_row = $this->link->query($query);

        if ($update_row) {
            return $update_row;
        } else {
            return false;
        }
    }

    public function delete($query)
    {
        $delete_row = $this->link->query($query);

        if ($delete_row) {
            return $delete_row;
        } else {
            return false;
        }
    }
}
?>
