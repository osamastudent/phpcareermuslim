<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
    <title>Document</title>
</head>
<body>

<?php
@include'conn.php';
if(isset($_GET["update"])){
$update=$_GET["update"];
$select=mysqli_query($conn,"select * from users where id='$update'");
$row=mysqli_fetch_array($select);
}
?>

<?php
if(isset($_GET["deleteall"])){
$deleteall=mysqli_query($conn,"delete from users");
if($deleteall){
    echo'
    <script>
    alert("delete all successfully");
    </script>
    ';
}
}

?>

<?php
if(isset($_POST["updateusers"])){
$name=$_POST["name"];
$email=$_POST["email"];
$pass=$_POST["pass"];
$img=$_FILES["userimage"]["name"];

$allowedextension=array('png');
$filename=$_FILES["userimage"]["name"];
$pathinfo=pathinfo($filename,PATHINFO_EXTENSION);

if(!in_array($pathinfo,$allowedextension)){
$error="png only";
}
else if(empty($name)){
    $error="please enter your name";
    }
    elseif(strlen($name) <5 || strlen($name)>10){
        $error="user name between 5 to 10 characters";
        } 

    else{
move_uploaded_file($_FILES["userimage"]["tmp_name"],'images/'.$img);
$updatevalue=mysqli_query($conn,"update users set name='$name', email='$email' , pass='$pass', image='$img' where id='$update'");
if($updatevalue){
echo'
<script>
alert("updated successfully");
</script>
';
// header("location:showusers.php");
}
    
}
}

?>


<div class="container">


<h1>update form</h1>
<form action="" method="post" enctype="multipart/form-data">
<input type="text" class="form-control" value="<?php echo @$row["name"] ?>" name="name" placeholder="name"><br>
<input type="text" class="form-control" name="email" value="<?php echo @$row["email"] ?>" placeholder="email"><br>
<input type="text" class="form-control" name="pass" value="<?php echo @$row["pass"] ?>" placeholder="pass"><br>
<?php
if(isset($error)){
echo"
<div class='alert alert-dark rounded-pill fs-5 w-75'>
$error
</div>";
}
  ?>
<label for="">old image</label><img src="images/<?php echo $row['image'] ?>" class="img-center" height="80">
&nbsp <label for="" id=new></label><img src="" id="preview-image" height="80">
<br>
<input type="file" name="userimage" id="input-image" class="d-none"/>
<label for="input-image" class="btn btn-primary">Upload Image</label>

<input type="submit" value="Update" class="btn btn-warning" name="updateusers">


</form>


</div>

<script>
var inputimage=document.getElementById("input-image");
var previewimage=document.getElementById("preview-image");

inputimage.addEventListener("change",function(event){
if(event.target.files.length==0){

return;
}

else{
var tmpUrl=URL.createObjectURL(event.target.files[0]);
previewimage.setAttribute("src",tmpUrl);
document.getElementById("new").innerText="new image";
}

});
</script>
</body>
</html>