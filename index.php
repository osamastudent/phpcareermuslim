<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>adduser</title>
    <style>
        #name:focus {
  box-shadow: none !important;
}
    </style>
</head>
<body>
<?php   
include'conn.php';

?>
<div class="container">


    
<?php
if(isset($_POST["addusers"])){
$name=$_POST["name"];
$email=$_POST["email"];
$pass=$_POST["pass"];
// $cpass=$_POST["cpass"];
$passhash=password_hash($pass,PASSWORD_BCRYPT);
$img=$_FILES["userimage"]["name"];
$allowedextension=array('jpg','jpeg');
$filename=$_FILES["userimage"]["name"];
$pathinfo=pathinfo($filename,PATHINFO_EXTENSION);

if(empty($name)){
$error="please enter your name";
}


else if(empty($email)){
    $error="please enter your email";
    }

    
// else if($cpass!=$pass){
//     $error="password and confirm password are not match";
//     }
    
else if(empty($pass)){
    $error="please enter your password";
    }

    
else if(empty($img)){
    $error="please enter your image";
    }


else if(!in_array($pathinfo,$allowedextension)){
$error="jpg and jpeg only";
}

else if($_FILES["userimage"]['size']>3500000){
    $error="image can not allowed more than 1 mb";
}

else{
    if(file_exists("images/".$_FILES['userimage']['name'])){
        $filename=$_FILES['userimage']['name'];
        $error="image already exists";
        
        }
        else{

            
move_uploaded_file($_FILES["userimage"]["tmp_name"],'images/'.$img);
$fetch_email=mysqli_query($conn,"select * from users where email='$email'");
if(mysqli_num_rows($fetch_email)<=0){
$insert=mysqli_query($conn,"insert into users values(null,'$name','$email','$passhash','$img')");
    if($insert){
    echo '
<script>
alert("added with image");
window.location.href="showusers.php"
</script>

';
    }
        }
        else{
            echo '
            <script>
            alert("this email already added");
            // window.location.href="showusers.php"
            </script>
            
            ';          
        }

}

}
}
?>


<?php
if(isset($error)){
echo"
<div class='alert alert-dark rounded-pill fs-5 w-75'>
$error
</div>";
}
  ?>
  <form action="" method="post" enctype="multipart/form-data">
<input type="text" class="form-control" name="name" placeholder="name" id="name" onblur="blr()" onfocus="abc()"><br>
<input type="email" class="form-control" name="email" placeholder="email"><br>
<input type="password" class="form-control" name="pass" placeholder="pass"><br>
<!-- <input type="password" class="form-control" name="cpass" placeholder="confirm pass"><br> -->
<input type="file" class="form-control" id="input-image" name="userimage"><br>
<input type="submit" name="addusers">
</form>
<img src="" id="preview-image" height="200">
</div>
</body>
</html>

<script>

function abc(){
document.getElementById("name").style.backgroundColor="yellow";
document.getElementById("name").style.borderColor="green";
document.getElementById("name").style.outlineColor="yellow";
}

function blr(){
    document.getElementById("name").style.backgroundColor="";
}
    var inputimg=document.getElementById("input-image");
    var previewimg=document.getElementById("preview-image");
    inputimg.addEventListener("change",function(event){
if(event.target.files.length==0){
return;
}
else{
    var tmpUrl=URL.createObjectURL(event.target.files[0]);
    previewimg.setAttribute("src",tmpUrl);
}
    });

    for(var a=1; a<=100; a=a+10){
for(var b=a; b<a+1; b++){
    document.write(" "+b);
}
document.write(" <br>");
}
</script>