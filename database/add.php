<?php
 //session start
 session_start();

 include("table_columns.php");

$table_name=$_SESSION['table'];
$columns = $table_columns_mapping[$table_name];

$db_arr = [];
$user = $_SESSION['user'];

foreach ($columns as $column) 
{
       if(in_array($column,['created_at','updated_at'])) 
       {
              $db_arr[$column] = date('Y-m-d H:i:s');
       }
       else if ($column == 'created_by')
       { 
              $db_arr[$column] = $user['id'];
       }
       else if ($column == 'password' && isset($_POST[$column]))
       {
              $db_arr[$column] = password_hash($_POST[$column], PASSWORD_DEFAULT);
       }
       else if ($column == 'img')
       {
              $target_dir = "../uploads/products/";
              $file_data = $_FILES[$column];

              $file_name = $file_data["name"];
              $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

              $file_name = 'product -' . time() .'.'. $file_ext;
              $check = getimagesize($file_data['tmp_name']);
              if($check)
              {
                     if(move_uploaded_file($file_data['tmp_name'],$target_dir.$file_name))
                     {
                            $db_arr[$column]= $file_name;
                     }
                     
              }
              else
              {
                     $db_arr[$column] = null;
              }
       }
       else
       {
              $db_arr[$column] = $_POST[$column] ?? null;
       }
}

$table_properties = implode(", ", array_keys($db_arr));
$table_placeholders = ':' . implode(" , :", array_keys($db_arr));
$sql="INSERT INTO 
$table_name($table_properties) 
VALUES 
       ($table_placeholders)";


//  $first_name=$_POST['first_name'];
//  $last_name=$_POST['last_name'];
//  $email=$_POST['email'];
//  $password=$_POST['password'];
//  $encrypted = password_hash($password,PASSWORD_DEFAULT);
//  //Adding the record
 

try 
 {
       include('connection.php');
       
       $stmt = $conn ->prepare($sql);
       $placeholders = [];
    foreach ($db_arr as $key => $value) 
    {
        $placeholders[":$key"] = $value;
    }
   

    $stmt->execute($placeholders);
       $response=[
        'success'=>true,
        'message'=> 'Successfully added to the system.'
       ];

       
} 
 catch (PDOException $e) 
 {
    $response=[
        'success'=>false,
        'message'=>$e->getMessage()
       ];

 }
 $_SESSION['response'] = $response;
 header('location:../' .$_SESSION['redirect_to']);
?>