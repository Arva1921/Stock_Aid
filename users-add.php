<?php
// Start the session
session_start();
if(!isset($_SESSION['user'])) 
{ 
    header('location:login.php');
    exit();
}
$_SESSION['table']='users';
$user = $_SESSION['user'];
$users=include('database/show-users.php');
if(!is_array($users))
{
    $users=[];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        Add Users - Stock-Aid
    </title>
    <link rel="stylesheet" type="text/css" href="css/login.css?v=<?= time();?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css" integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/199857ee6e.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="dashboardMainContainer">
        <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dasboard_content_container">
          <?php include('partials/app-topNav.php') ?>
            <div class="dashboard_content">
              <div class="dashboard_content_main">
                <div class="row">
                 <div class="column column-12">
                    <h1 class="section_header"> <i class="fa fa-plus"></i> Create User</h1>
                    <div class="userAddFormContainer">
                           <form action="database/add.php" method="POST" class="appForm">
                                 <div class="appFormInputContainer">
                                     <label for="first_name">First Name:</label>
                                     <input type="text" class="appFormInput" id="first_name" name="first_name"/>
                                 </div>
                                 <div class="appFormInputContainer">
                                     <label for="last_name">Last Name:</label>
                                     <input type="text" class="appFormInput" id="last_name" name="last_name"/>
                                 </div>
                                 <div class="appFormInputContainer">
                                     <label for="email">Email:</label>
                                     <input type="text" class="appFormInput" id="email" name="email"/>
                                 </div>
                                 <div class="appFormInputContainer">
                                     <label for="password">Password:</label>
                                     <input type="password"  class="appFormInput" id="password" name="password"/>
                                 </div>
                                 
                                 <button type="submit" class="appBtn"><i class="fa fa-plus"></i>ADD USER</button>
                            </form>
                       <?php 
                       if(isset($_SESSION['response'])) 
                       {
                           $response_message=  $_SESSION['response']['message'];
                           $is_success = $_SESSION['response']['success'];
                           
                       ?>
                           <div class="responseMessage">
                               <p class="responseMessage <?=$is_success ? 'responseMessage_success':'responseMessage_error'?>">
                                   <?=$response_message ?>
                               </p>
                           </div>
                        <?php unset($_SESSION['response']); } ?>
                   </div>
                 </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="js/jquery/jquery-3.7.1.js"></script>
    <script src="js/script.js?v=<?= time();?>"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.js" integrity="sha512-AZ+KX5NScHcQKWBfRXlCtb+ckjKYLO1i10faHLPXtGacz34rhXU8KM4t77XXG/Oy9961AeLqB/5o0KTJfy2WiA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function script()
        {
            this.initialize =function()
            {
                this.registerEvents();
            };
            this.registerEvents = function()
            {
                document.addEventListener('click',function(e)
                {
                   targetElement = e.target.closest('a');
                   console.log('clicked element:',e.target);
                   if(!targetElement)
                   {
                    console.log('clicked element is not an anchor tag');
                    return; //exit
                   }
                   classList = targetElement.classList;
                  
                   if(classList.contains('deleteUser'))
                   {
                    e.preventDefault();
                    userId=targetElement.dataset.userid;
                    fname=targetElement.dataset.fname;
                    lname=targetElement.dataset.lname;
                    fullname=fname + ' ' + lname;

                    BootstrapDialog.confirm({
                        type:BootstrapDialog.TYPE_DANGER,
                        message:'Are you sure to delete'+ fullname + '?',
                        callback:function(isDelete)
                        {
                            if(isDelete)
                          {
                            $.ajax({
                             method:'POST',
                            data:
                       {
                        user_id:userId,
                        fname:fname,
                        lname:lname
                       },
                       url:'database/delete-user.php',
                       dataType:'json',
                       success:function(data)
                       {
                        if(data.success)
                       {
                        BootstrapDialog.alert({
                                type:BootstrapDialog.TYPE_SUCCESS,
                                message:data.message,
                                callback:function()
                                {
                                    location.reload();
                                }
                            }); 
                        }
                       else
                       { 
                        BootstrapDialog.alert(
                            {
                                type:BootstrapDialog.TYPE_DANGER,
                                message:data.message,
                            });
                        }
                    }
                });
            }
        }
    });
}
                       
                if(classList.contains('updateUser'))
                {
                    e.preventDefault();
                    console.log("edit button clicked!!");
                    // get data
                    userId = targetElement.dataset.userid;
                    firstName=targetElement.closest('tr').querySelector('td.firstName').innerHTML;
                    lastName=targetElement.closest('tr').querySelector('td.lastName').innerHTML;
                    email=targetElement.closest('tr').querySelector('td.email').innerHTML;
                   
                    BootstrapDialog.confirm({
                        title:'Update' + firstName + ' ' + lastName,
                        message:'<form>\
                        <div class="form-group">\
                        <label for="firstName">First Name:</label>\
                        <input type="text"class="form-control" id="firstName" value="'+firstName+'">\
                        </div>\
                        <div class="form-group">\
                        <label for="lastName">Last Name:</label>\
                        <input type="text"class="form-control" id="lastName" value="'+lastName+'">\
                        </div>\
                        <div class="form-group">\
                        <label for="email">Email Address:</label>\
                        <input type="email"class="form-control" id="emailUpdate" value="'+email+'">\
                        </div>\
                        </form>',
                        callback:function(isUpdate)
                        {
                            if(isUpdate)
                        {
                            // If user click ok
                            $.ajax({
                       method:'POST',
                       data:
                       {
                        user_id:userId,
                        fname:document.getElementById('firstName').value,
                        lname:document.getElementById('lastName').value,
                        email:document.getElementById('emailUpdate').value,
                       },
                       url:'database/update-user.php',
                       dataType:'json',
                       success:function(data)
                       {
                        if(data.success)
                       {
                        BootstrapDialog.alert(
                            {
                                type:BootstrapDialog.TYPE_SUCCESS,
                                message:data.message,
                                callback:function()
                                {
                                    location.reload();
                                }
                            }); 
                        }
                       else
                       { 
                        BootstrapDialog.alert(
                            {
                                type:BootstrapDialog.TYPE_DANGER,
                                message:data.message,
                            });
                        }
                    }
                });
            }
        }
    });
}
                });
            };
        }

    
        var script = new script;
        script.initialize();
    </script>
</body>

</html>
