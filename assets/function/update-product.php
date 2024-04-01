<?php
class UpdateCart {
    function updateCart($add = false) {
        // Establish MySQLi connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        foreach ($_POST['quantity'] as $id => $quantity) {
            if ($quantity == 0) {
                $masp = $mysqli->real_escape_string($id); // Escape input to prevent SQL injection
                $delete = "DELETE FROM SAN_PHAM WHERE MaSP = '$masp'";
                $conndel = $mysqli->query($delete);

                if (!$conndel) {
                    echo "Error: " . $mysqli->error;
                }
            } else {
                if ($add) {
                    $_SESSION["cart"][$id] += $quantity;
                } else {
                    $_SESSION["cart"][$id] += $quantity;
                }
            }
        }

        // Close connection
        $mysqli->close();
    }
}

// Usage
$updateCartObj = new UpdateCart();
$updateCartObj->updateCart();
?>
