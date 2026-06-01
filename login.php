<?php
require_once 'db.php';
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['username' => $username, 'password' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; 
        header("Location: index.php");
        exit;
    } else {
        $error_msg = '帳號或密碼錯誤，請重試！';
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入系統 - MLB 數據管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">⚾ 系統登入</h4>
                </div>
                <div class="card-body">
                    <?php if ($error_msg): ?>
                        <div class="alert alert-danger"><?= $error_msg ?></div>
                    <?php endif; ?>

                    <form method="POST" action="login.php">
                        <div class="mb-3">
                            <label class="form-label">帳號</label>
                            <input type="text" name="username" class="form-control" required placeholder="輸入 admin">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">密碼</label>
                            <input type="password" name="password" class="form-control" required placeholder="輸入 admin123">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">登入</button>
                        <a href="index.php" class="btn btn-outline-secondary w-100 mt-2">先回首頁逛逛</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>