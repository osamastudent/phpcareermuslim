<?php
session_start(); 
if(isset($_SESSION['email']))
{
  header("location:showusers.php");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   
    <title>Login</title>
</head>
<body>
<div class="container" style="padding: 100px;">

<?php
include'conn.php';
if(isset($_POST["login"])){
$uemail=$_POST["email"];
$password=$_POST["password"];
if(empty($uemail)){
$error="email must be required ";
}
else if(empty($password)){
    $error="password must be required ";
}
else{
    $emailsearch="select * from users where email='$uemail'";
    $query=mysqli_query($conn,$emailsearch);
    $email_account=mysqli_num_rows($query);
if($email_account){
$email_pass=mysqli_fetch_assoc($query);
$db_pass=$email_pass['password'];
$pass_decode = password_verify($password, $db_pass);
if ($pass_decode) {
    $error = "login successfully";
} else {
    $error = "password incorrect";
}

}
    else{
    $error="invalid email";
    }
}
}
?>




<h1 class="text-center">Login Form</h1>

<form action="" method="post" class="offset-3">
<input type="email" name="email" placeholder="Enter Your Email" class="form-control w-75 rounded-pill"><br>
<input type="password" name="password" placeholder="Enter Your Password" class="form-control w-75 rounded-pill"><br>
<input type="submit" name="login" value="Login" class="form-control w-75 rounded-pill btn btn-primary btn-outline-success text-light">
<br>
<br>
<a href="register.php">Register!</a>
</form>


<?php
if(isset($error)){
echo"
<div class='alert alert-dark rounded-pill fs-5 w-50 offset-3'>
$error
</div>";

}
  ?>
</div>

</body>
</html>