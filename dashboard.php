<!DOCTYPE html>
<?php
require_once "dologin.php";
if($obj->is_logged()=="")
{
    $obj->redirect('login.php');
}
if($_SESSION['user']['email'] == 'admin@qsoftvietnam.com'){
    $admin = true;
}  else {
    $admin = FALSE;
}
if($admin){
    $statement = $obj->connection->prepare("select * from users");
    $statement->execute();
}else{
    $statement = $obj->connection->prepare("select * from users where email = :email ");
    $statement->execute(array(':email' => $_SESSION['user']['email']));
}
$user = $statement->fetchAll(PDO::FETCH_ASSOC);
//var_dump($user);die;

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- jQuery 2.1.4 -->
    <script src="js/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="row">
            <h3>User Management</h3>
            <span class=" alert-success"><?=!empty($_GET['message'])? $_GET['message']:''?></span>
            <h4 style="color:blue"></h4>
        </div>
        <div class="row">
            <p>
                <a href="login.php?logout=true" class="btn btn-success">Log Out</a>
            </p>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($user)){foreach ($user as $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['id'];?></td>
                        <td><?php echo $value['email'];?></td>
                        <td><?php echo $value['password'];?></td>
                    </tr>
                    <?php }}?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /container -->

</body>
</html>