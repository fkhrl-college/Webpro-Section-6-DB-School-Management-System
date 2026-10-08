<?php
  session_start();
  include 'config.php';

  if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
  }

  $error = "";

  if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if($user && password_verify($password, $user['password'])) {
      session_regenerate_id(true);
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];
      header("Location: index.php");
      exit();
    } else {
      $error = "Incorrect username or password";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center" style="margin-top: 15vh;">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-header bg-dark text-white text-center">
            <h5 class="mb-0">Student Management</h5>
          </div>
          <div class="card-body">
            <?php if($error): ?>
              <div class="alert alert-danger py-2">
                <?= $error ?>
              </div>
            <?php endif; ?>
            <form action="" method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" required autofocus>
              </div>
              <div class="mb-4">
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
              <div class="d-grid">
                <button type="submit" name="login" class="btn btn-dark">Login</button>
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