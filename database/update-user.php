<?php
$data = $_POST;
$user_id = (int)$data['user_id'];
$first_name = $data['fname'];
$last_name =  $data['lname'];
$email = $data['email'];
if (empty($first_name) || empty($last_name) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}
try {
    include('connection.php');
    $sql = "UPDATE users SET email=?, first_name=?, last_name=?, updated_at =? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute([$email, $first_name, $last_name, date('Y-m-d H:i:s'), $user_id]);

    if ($success) {
        echo json_encode(['success' => true, 'message' => $first_name . ' ' . $last_name . ' successfully updated.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed.']);
    }
} 
catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
// try 
// {
//     include('connection.php');
//     $sql ="UPDATE users SET email=?,first_name=?,last_name=?,updated_at=? WHERE id=?";
//    $conn->prepare($sql)->execute([$email,$first_name,$last_name,date('Y-m-d h:i:s'),$user_id]);
//       echo json_encode([
//         'success'=> true,
//         'message'=> $first_name.''. $last_name.'successfully updated.' 
//     ]);
      
// } 
// catch (PDOException $e) 
// {
//     echo json_encode([
//         'success'=> false,
//         'message'=>'Error: Proccessing your request!'
//     ]);

// }
?>