<?php
  include 'auth.php';
  include 'config.php';
  require_admin();

  $message = "";

  if(isset($_POST['add_user'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if(strlen($password) < 6) {
      $message = "<div
        class='alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3'
        role='alert'
        style='z-index: 1050;'
      >
        Password must be at least 6 characters
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      </div>";
    } elseif(!in_array($role, ['admin', 'staff'])) {
      $message = "<div
        class='alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3'
        role='alert'
        style='z-index: 1050;'
      >
        Invalid role
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      </div>";
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
      mysqli_stmt_bind_param($stmt, "sss", $username, $hash, $role);
      try {
        mysqli_stmt_execute($stmt);
        $message = "<div
        class='alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3'
        role='alert'
        style='z-index: 1050;'
      >
        User added succesfully
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      </div>";
      } catch(mysqli_sql_exception $e) {
        $message = "<div
        class='alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3'
        role='alert'
        style='z-index: 1050;'
      >
        Error adding user: $e
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      </div>";
      }
    }
  }

  $users = mysqli_query($conn, "SELECT id, username, role FROM users ORDER BY id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Management</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <?= $message ?>
  <?php include 'navbar.php'; ?>
  <div class="container mt-4">
    <div class="row g-4">
      <!-- user form -->
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-header bg-success text-white">
            <h5 class="mb-0">Add User</h5>
          </div>
          <div class="card-body">
            <form action="" method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <input type="password" name="password" class="form-control" id="password" minlength="6" required>
                  <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Show password"
                  >
                    <i class="bi bi-eye"></i>
                  </button>
                </div>

                <script>
                  const password = document.getElementById('password');
                  const togglePassword = document.getElementById('togglePassword');

                  togglePassword.addEventListener('click', () => {
                    const isPassword = password.type === 'password';
                    password.type = isPassword ? 'text' : 'password';
                    togglePassword.innerHTML = isPassword
                      ? '<i class="bi bi-eye-slash"></i>'
                      : '<i class="bi bi-eye"></i>';
                    togglePassword.setAttribute(
                      'aria-label',
                      isPassword ? 'Hide password' : 'Show password'
                    );
                  });
                </script>
              </div>
              <div class="mb-4">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select">
                  <option value="staff">Staff</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              <div class="d-grid">
                <button type="submit" name="add_user" class="btn btn-success">Save User</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- user list -->
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">User List</h5>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped align-middle mb-0">
              <thead class="table-dark">
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Role</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $no = 1;
                  while($u = mysqli_fetch_assoc($users)):
                ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td>
                      <?= htmlspecialchars($u['username']); ?>
                      <?php if($u['id'] == $_SESSION['user_id']): ?>
                        <span class="badge bg-info">You</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="badge <?= $u['role'] == 'admin' ? 'bg-danger' : 'bg-secondary' ?>">
                        <?= $u['role'] ?>
                      </span>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>