<?php
    require_once('../connection.php');
    if($_GET['ver'] == date('i') || $_GET['ver'] == (date('i') + 1)) {
    if(!empty($_GET["name"]) && !empty($_GET["imgurl"])){
        //student table
        $studentQuery = $db->prepare("SELECT full_name from student_data");
        $studentQuery->execute();
        $name = $_GET['name'];
        $result = Array();
        foreach ($studentQuery->get_result() as $row)
        {
          array_push($result, $row['full_name']);
        }
        //admin table
        $adminQuery = $db->prepare("SELECT full_name from admins");
        $adminQuery->execute();
        $adminResult = Array();
        foreach ($adminQuery->get_result() as $row)
        {
          array_push($adminResult, $row['full_name']);
        }
        if(in_array($name, $result)) {

          $imgurl = $_GET['imgurl'];
          $updateImage = $db->query("UPDATE student_data SET imgurl = '$imgurl' WHERE full_name = '$name'");

          $studentPriv = $db->query("SELECT priv FROM student_data WHERE full_name = '$name'");
          setcookie("user", $imgurl, time() + (86400 * 5), "/");
          echo $studentPriv->fetch_array()[0];

        } elseif(in_array($name, $adminResult)) {
          $imgurl = $_GET['imgurl'];
          $updateImage = $db->query("UPDATE admins SET imgurl = '$imgurl' WHERE full_name = '$name'");


          $adminPriv = $db->query("SELECT priv FROM admins WHERE full_name = '$name'");
          setcookie("user", $imgurl, time() + (86400 * 5), "/");
          echo $adminPriv->fetch_array()[0];
        } else {
          echo 0;
        }
    }
  } else {
    setcookie("user", $imgurl, time() - 3600, "/");
    echo 'bad verification';
  }

?>
