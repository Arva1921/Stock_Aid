<?php
// Start the session
session_start();
if(!isset($_SESSION['user'])) 
{ 
    header('location:login.php');
    exit();
}
$_SESSION['table']='products';
$user = $_SESSION['user'];
$products=include('database/show-products.php');
if(!is_array( $products ))
{
    $products=[];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        View Products - Stock-Aid
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
                     <h1 class="section_header"> <i class="fa fa-list"></i> List of Products</h1>
                       <div class="section_content">
                        <div class="users">
                            
                            <table>
                                <thead>
                                   <tr>
                                       <th>#</th>
                                       <th>Image</th>
                                       <th>Product Name</th>
                                       <th>Description</th>
                                       <th>Created By</th>
                                       <th>Created At</th>
                                       <th>Updated At</th>
                                       <th>Action</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($products as $index=> $product) 
                                    {
                                    ?>
                                     <tr>
                                        <td><?= $index +1 ?></td>
                                        <td class="firstName">
                                            <img class="productImages" src="uploads/products/<?=$product['img'] ?>" alt=""/>
                                        </td>
                                        <td class="lastName"><?=$product['product_name']?></td>
                                        <td class="email"><?=$product['description']?></td>
                                        <td>
                                            <?php
                                            $pId  = $product['created_by'];
                                            $stmt = $conn->prepare("SELECT * FROM users WHERE id=$pId");
                                            $stmt->execute();
                                            $row = $stmt->Fetch(PDO::FETCH_ASSOC);

                                            $created_by_user = $row['first_name'].' '.$row['last_name'];
                                            echo $created_by_user;
                                            ?>
                                            
                                        </td>
                                        <td><?=date('M d,Y',strtotime($product['created_at']))?></td>
                                        <td><?=date('M d,Y',strtotime($product['updated_at']))?></td>
                                        <td>
                                            <a href="" class="updateProduct" data-pid="<?=$product['id']?>" data-pname="<?=$product['product_name']?>"  data-description="<?=$product['description']?>">
                                                <i class="fa fa-pencil"></i>Edit
                                            </a>
                                            <a href="" class="deleteProduct" data-pname="<?=$product['product_name']?>" data-pid="<?=$product['id']?>">
                                                <i class="fa fa-trash"></i>Delete
                                            </a>
                                        </td>
                                    </tr>
                                   <?php }?>
                                </tbody>
                            </table>
                            <p class="userCount"><?= count($products) ?> Products </p>
                            </div>
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
        console.log("Script loaded!"); 
        function script()
        {
            var vm = this;
            this.registerEvents = function()
            {
                document.addEventListener('click',function(e)
                {
                    targetElement = e.target;
                    classList = targetElement.classList;

                    if(classList.contains('deleteProduct'))
                   {
                    e.preventDefault();

                    pId=targetElement.dataset.pid;
                    pName=targetElement.dataset.pname;
                    
                    BootstrapDialog.confirm({
                        type:BootstrapDialog.TYPE_DANGER,
                        title:'Delete Product',
                        message:'Are you sure to delete'+' '+ pName + '?',
                        callback:function(isDelete)
                        {

                            if(isDelete)
                            {
                                $.ajax({
                             method:'POST',
                            data:
                       {
                        id:pId,
                        table:'products',
                       },
                       url:'database/delete-product.php',
                       dataType:'json',
                       success:function(data)
                       {
                        message = data.success ?
                        pName + ' ' + ' sucessfully deleted! ': 'Error processing you request!';
                      
                        BootstrapDialog.alert({
                                type: data.success? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER ,
                                message:message,
                                callback:function()
                                {
                                    if (data.success) location.reload();
                                }
                            }); 
                      
                    }
                });
                            }
                        }
          });
        }
    

        if(classList.contains('updateProduct'))
        {
            e.preventDefault();
            console.log("Update button clicked!");
            pId=targetElement.dataset.pid;
            console.log("Product ID:", pId);
            vm.showEditDialog(pId);

            
        }
    });

document.addEventListener('click',function(e)
{ 
    console.log("Click detected:", e.target);  // Debug log
    e.preventDefault();
    targetElement = e.target;
    if(targetElement.id == 'editProductForm')
{
    vm.saveUpdatedData(targetElement);
}
});
},
this.saveUpdatedData = function(form)
{
    console.log("Submitting update request..."); // Debugging log
    $.ajax({
                       method:'POST',
                       data: new FormData(form),
                       url:'database/update-product.php',
                       processData:false,
                       contentType:false,
                       dataType:'json',
                       success:function(data)
                       {
                        console.log("AJAX Success Response: ", data); // Debugging
                        BootstrapDialog.alert({
                            type: data.success ?BootstrapDialog.TYPE_SUCCESS:BootstrapDialog.TYPE_DANGER,
                            message:data.message,
                            callback:function()
                            {
                                if(data.success)
                                {
                                    location.reload();
                                }
                            }
                        });
                    },
                });
};
this.showEditDialog = function(id)
{
$.get('database/get-product.php',{id:id},function(pName)
{
    BootstrapDialog.confirm({
                        title:'Update <strong>' + pName.product_name+'</strong>',
                        message:'<form id="editProductForm" enctype="multipart/form-data" >\
                        <div class="appFormInputContainer">\
                                     <label for="product_name">Product Name:</label>\
                                     <input type="text" class="appFormInput" value="'+ pName.product_name +'"  placeholder="Enter Product Name..." id="product_name" name="product_name"/>\
                                 </div>\
                                 <div class="appFormInputContainer">\
                                     <label for="description">Description:</label>\
                                     <textarea type="text" class="productTextAreaInput" placeholder="Enter Product Description..." id="description" name="description">'+pName.description+'</textarea>\
                                 </div>\
                                 <div class="appFormInputContainer">\
                                     <label for="img">Product Image:</label>\
                                      <input type="file" name="img" id="img"/>\
                                 </div>\
                                 </form>\
                        ',
                        console.log("Selected File: ", document.getElementById("img").files[0]);
                        callback:function(isUpdate)
                        {
                            if(isUpdate)
                        {
                            document.querySelector('#editProductForm').submit();
            }
        }
    });
},'json');
    
},
        
            this.initialize =function()
            {
                this.registerEvents();
            }
           
        }
        var script = new script;
        script.initialize();
    </script>
    
</body>

</html>
