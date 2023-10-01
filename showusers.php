
<?php
session_start();
if(isset($_SESSION["email"])){

}
else{
    header("location:login.php");
}

?>
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
    <h1>
<h1>welcome to <?php echo @$_SESSION["name"];?></h1>
<h1>welcome to <?php echo @$_SESSION["email"];?></h1>
<h1><a href="logout.php">logout</a></h1>
    </h1>
<h1>Users Details</h1>
<table class="table">
<thead>
<th>id</th>
<th>name</th>
<th>email</th>
<th>pass</th>
<th>image</th>
<th>actions</th>
</thead>
<tbody>

<?php
@include'conn.php';
$select=mysqli_query($conn,"select * from users");
$key="";
while($row=mysqli_fetch_array($select)){  
$key++;
?>
<tr>
<td><?php echo $key  ?></td>
<td><?php echo $row[1]  ?></td>
<td><?php echo $row[2]  ?></td>
<td><?php echo $row[3]  ?></td>
<td><img src="images/<?php echo $row[4]  ?>" alt="" height="60"></td>
<td><a href="showusers.php?delete=<?php echo $row[0] ?>" >Delete</a></td>
<td><a href="update.php?update= <?php echo $row[0]  ?>">Update</a></td>
<td><a href="update.php?deleteall= <?php echo $row[0]  ?>">Delete All</a></td>
</tr>
<?php
}
?>

<?php
if(isset($_GET["delete"])){
$delete_id=$_GET["delete"];
    @$delete=mysqli_query($conn,"delete from users where id='$delete_id'");
}
if(@$delete){
echo'
<script>
alert("delete successfully");
window.location.href="showusers.php"
</script>
';
}

?>
</tbody>
</table>
</body>
</html>