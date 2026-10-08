<?php
  // session_start();
  include 'config.php';
  include 'auth.php';

  $id = $_GET['id'];
  // $result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
  // $data = mysqli_fetch_assoc($result);
  $stmt = mysqli_prepare($conn, "SELECT * FROM students WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);

  $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
  if(!$data) {
    die("Student not found.");
  }
  $majors = mysqli_query($conn, "SELECT id, name FROM majors ORDER BY name");
  if(isset($_POST['update'])) {
    $nim = $_POST['nim'];
    $name = $_POST['name'];
    $major_id = $_POST['major_id'];
    // $query = "UPDATE students SET nim='$nim', name='$name', major='$major' WHERE id=$id";
    $stmt = mysqli_prepare($conn, "UPDATE students SET nim = ?, name = ?, major_id = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssii", $nim, $name, $major_id, $id);
    if(mysqli_stmt_execute($stmt)) {
      $_SESSION['crud'] = [
        "type" => "success",
        "message" => "success update student data"
      ];
      header("Location: index.php");
      exit();
    } else {
      $_SESSION['crud'] = [
        'type' => 'danger',
        'message' => 'Failed edit/update student'
      ];
      header("Location: index.php");
      exit();
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Edit Student</h5>
          </div>
          <div class="card-body">
            <form action="" method="POST">
              <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" value="<?= htmlspecialchars($data['nim']); ?>" required>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($data['name']); ?>" required>
              </div>
              <div class="mb-4">
                <label for="major_id" class="form-label">Major</label>
                <select name="major_id" id="major_id" class="form-select" required>
                  <?php while($m = mysqli_fetch_assoc($majors)): ?>
                    <option value="<?= $m['id'] ?>" <?= $m['id'] == $data['major_id'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($m['name']) ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                <a href="index.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="update" class="btn btn-warning">Update Data</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>