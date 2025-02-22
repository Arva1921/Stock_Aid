<?php

// Start the session
session_start();

if(isset($_SESSION['user'])) 
{
    header('location:dashboard.php');
}
 $error_message = '';
  if($_POST)
  {
    include('database/connection.php');
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email = :email AND password =:password ";
    $stmt= $conn->prepare($query);
    $stmt->execute([':email'=>$username,':password'=>$password]);

    if($stmt->rowCount() > 0)
    {
        $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $user = $stmt -> fetchAll()[0];
        $_SESSION['user'] = $user;
         
        header('Location:dashboard.php');
    }
    else $error_message = 'Please make sure that username and password are correct';
  }
?>


<!DOCTYPE html>
<html>
    <head>
        <title>
            SA Login - Stock-Aid
        </title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
    </head>
    <body id="loginBody">
        <?php if(!empty($error_message)){?>
        <div class="errorMessage">
            <p>
               <strong> Error: </strong> <?=$error_message?>
            </p>
        </div>
        <?php } ?>
        <div class="container">
            <div class="loginHeader">
             <h1>Stock-Aid</h1>
             <p>Innovating the Way You Stock</p>
            </div>
            <div class="loginBody">
                <form action="login.php" method="POST">
                    <div class="loginInputConatiner">
                        <label for="">USERNAME:</label>
                        <input placeholder="username" name="username" type="text"/>
                    </div>
                    <div class="loginInputConatiner">
                        <label for="">PASSWORD:</label>
                        <input placeholder="password" name="password" type="password"/>
                    </div>
                    <div class="loginButtonContainer">
                        <button>LOGIN</button>
                    </div>
                
                </form>
            </div>
        </div>

    </body>
</html>

