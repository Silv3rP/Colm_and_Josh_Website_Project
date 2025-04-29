<?php

namespace App;

require_once 'user.php';


class Admin extends User {
    public function __construct($conn) {
        parent::__construct($conn); // Pass the connection to User class
    }

    public function manageMenu($action, $menuItem) {
        if ($action == 'add') {
            $sql = "INSERT INTO menu_items (item_name, price) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sd", $menuItem['item_name'], $menuItem['price']);
            return $stmt->execute();
        }
    }
}
?>
