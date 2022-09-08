<?php 
	
include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();
	if(isset($_POST['user_id']))
	{
		$user_id=$_POST['user_id'];
		$recipe_id=$_POST['recipe_id'];

		$sql="delete from share_recipes where recipe_id=? AND user_id=?";
		$stmt1 = $db->prepare($sql);
    
    if ($stmt1) {
        $stmt1->bind_param('ii', $recipe_id,$user_id);
        $stmt1->execute(); 
        echo 'true';
	}

}
 ?>