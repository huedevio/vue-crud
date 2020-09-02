<?php 

include 'config.php';

$result     = array('error'=>false);
$action     = '';

if(isset($_GET['action'])) {
    $action = $_GET['action'];
}

if ($action == 'read') {
    $query  = "SELECT * FROM users";
    $sql    = $conn->query($query);
    $users  = array();
    while ($row = $sql->fetch_assoc()){
        array_push($users, $row);
    }
    $result['users'] = $users;
    echo json_encode($result);
}

if ($action == 'create') {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];

    $query  = "INSERT INTO users (name, email, phone) VALUES (?, ?, ?)";
    $stmt   = $conn->prepare ($query);
    $stmt->bind_param("sss", $name, $email, $phone);    
    $sql    = $stmt->execute();
    if ($sql){
        $result['message'] = "User added successfully!";
    } else {
        $result['error'] = true;
        $result['message'] = "Failed to add user";
    }
    echo json_encode($result);
}

if ($action == 'update') {
    $id     = $_POST['id'];
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone']; 

    $query  = "UPDATE users SET ";
    $query .= "name     = ?, ";
    $query .= "email    = ?, ";
    $query .= "phone    = ? ";
    $query .= "WHERE ID = ? ";
    
    $stmt   = $conn->prepare ($query);
    $stmt->bind_param("sssi", $name, $email, $phone, $id);    
    $sql    = $stmt->execute();
    if ($sql){
        $result['message'] = "User updated successfully!";
    } else {
        $result['error'] = true;
        $result['message'] = "Failed to update user";
    }
    echo json_encode($result);
}

if ($action == 'delete') {
    $id     = $_POST['id'];

    $query  = "DELETE FROM users WHERE ID = ? ";
    
    $stmt   = $conn->prepare ($query);
    $stmt->bind_param("i", $id);    
    $sql    = $stmt->execute();

    if ($sql){
        $result['message'] = "User deleted successfully!";
    } else {
        $result['error'] = true;
        $result['message'] = "Failed to delete user";
    }
    echo json_encode($result);
}

$conn->close();


?>