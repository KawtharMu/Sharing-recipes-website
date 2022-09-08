<style>
        #user_name_data li a {
            color: black !important;
            transition: all 0.2s 0s ease-out;
            text-decoration: none !important;
            text-decoration-color: rgb(16, 206, 32);
            display: block;
            padding: .75rem 1.25rem;
        }

        #user_name_data li a:hover {
            color: #0073aa !important;
        }

        /* #user_name_data li a:hover {
            color: #0073aa !important;
        } */
    </style>
<?php


include 'connect_db.php';
$database=new database();
$db = $database->connect_mysqli();

if (isset($_GET['q'])) {

    $serval=$_GET['q'];
    $serval="%$serval%";

    $query1="select * from users where status=? and name like ? limit 0,5"; 
    $stmt1 = $db->prepare($query1);
    if ($stmt1) {
      $status_val = '1';
        $stmt1->bind_param('ss', $status_val, $serval); 
        $stmt1->execute();
        $result = $stmt1->get_result();

        if($result->num_rows > 0)
        {
            while($row=$result->fetch_array(MYSQLI_ASSOC)){
              echo '<li class="list-group-item p-0"><a href="javascript:;" data-id="'.$row['id'].'">'.$row['name'].'</a></li>';
            }
            exit();
        }
    }
}
?>