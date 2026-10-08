<?php
  // session_start();
  include 'config.php';
  include 'auth.php';
  require_admin();
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM students WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if(mysqli_stmt_execute($stmt)) {
      $_SESSION['crud'] = [
        'type' => 'success',
        'message' => 'Success delete student'
      ];
      header("Location: index.php");
      exit();
    } else {
      $_SESSION['crud'] = [
        'type' => 'danger',
        'message' => 'Failed delete student'
      ];
      header("Location: index.php");
      exit();
    }
  }
?>