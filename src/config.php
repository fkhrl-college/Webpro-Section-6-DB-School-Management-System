<?php
//   function loadEnv(string $filePath) {
//       if (!file_exists($filePath)) {
//           return false;
//       }
      
//       $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//       foreach ($lines as $line) {
//           // Lewati baris komentar
//           if (strpos(trim($line), '#') === 0) {
//               continue;
//           }

//           // Pisahkan key dan value berdasarkan tanda sama dengan (=)
//           list($name, $value) = explode('=', $line, 2);
//           $name = trim($name);
//           $value = trim($value);

//           // Hilangkan tanda kutip jika ada di awal/akhir value
//           $value = trim($value, '"\'');

//           // Set ke environment variabel lokal PHP
//           if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
//               putenv(sprintf('%s=%s', $name, $value));
//               $_ENV[$name] = $value;
//               $_SERVER[$name] = $value;
//           }
//       }
//   }
//   loadEnv(__DIR__ . '/.env');
  // $db_host = "localhost";
  // $db_username = "fkhrl91";
  // $db_password = '190507$AruL';
  // $db_name = "db_school";
//   $db_host = $_ENV['DB_HOST'];
//   $db_username = $_ENV['DB_USER'];
//   $db_password = $_ENV['DB_PASSWORD'];
//   $db_name   = $_ENV['DB_NAME'];
  $db_host     = getenv('DB_HOST') ?: 'db';
  $db_username = getenv('DB_USER') ?: 'root';
  $db_password = getenv('DB_PASSWORD') ?: 'secret';
  $db_name     = getenv('DB_NAME') ?: 'db_school';
  $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
  if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
  }
  // echo "Koneksi berhasil!";
?>