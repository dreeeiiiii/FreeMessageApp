<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
</head>
<body>
    
<?php 

include("../includes/database.php");
$sql ="SELECT * FROM messages";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $feedbacks = [];
    while($row = $result->fetch_assoc()){
        $feedbacks[] = $row;
    }   
};
?>



<table>
   <tr>
    <th>Id</th>
    <th>Email</th>
    <th>Message</th>
   </tr>
<?php foreach($feedbacks as $feedback){ ?>
    <?php if($feedback){?>
   <tr>
    <td><?php echo $feedback['id'] ?></td>
    <td><?php echo $feedback['email'] ?></td>
    <td><?php echo $feedback['message'] ?></td>
   </tr>
   <?php }else echo "no messages found";?>
<?php }  

$conn->close();
?>
    
</table>




    
</body>
</html>