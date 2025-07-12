<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];
        header("Location: " . ($user["role"] == "admin" ? "admin/index.php" : "pengguna/index.php"));
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Checklist Toilet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css-img/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg border-0 p-4" style="min-width: 350px; max-width: 400px;">
        <div class="text-center mb-4">
            <img src="assets/img/2 (1).png" width="80" alt="Logo" class="mb-3">
            <h4 class="fw-bold text-primary">Login Aplikasi</h4>
            <small class="text-muted">Checklist Kebersihan Toilet</small>
        </div>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger text-center p-2 mb-3"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-floating mb-3">
                <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">Masuk</button>
        </form>
    </div>
</div>

</body>
</html>