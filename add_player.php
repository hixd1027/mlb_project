<?php
require_once 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('您沒有權限執行此操作！'); window.location.href='index.php';</script>";
    exit;
}

$stmt = $conn->query("SELECT team_id, team_name FROM teams");
$teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $team_id = $_POST['team_id'];

    if (!empty($name) && !empty($position) && !empty($team_id)) {
        $sql = "INSERT INTO players (name, position, team_id) VALUES (:name, :position, :team_id)";
        $insert_stmt = $conn->prepare($sql);
        $insert_stmt->execute([
            'name' => $name,
            'position' => $position,
            'team_id' => $team_id
        ]);
        header("Location: index.php");
        exit;
    } else {
        $error_msg = "所有欄位都必須填寫！";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增球員 - MLB 數據管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">➕ 新增球員資料</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error_msg)): ?>
                        <div class="alert alert-danger"><?= $error_msg ?></div>
                    <?php endif; ?>

                    <form method="POST" action="add_player.php">
                        <div class="mb-3">
                            <label class="form-label fw-bold">球員姓名</label>
                            <input type="text" name="name" class="form-control" required placeholder="例如：張育成">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">守備位置</label>
                            <input type="text" name="position" class="form-control" required placeholder="例如：SS, 2B, P">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">所屬球隊</label>
                            <select name="team_id" class="form-select" required>
                                <option value="">-- 請選擇球隊 --</option>
                                <?php foreach ($teams as $team): ?>
                                    <option value="<?= $team['team_id'] ?>">
                                        <?= htmlspecialchars($team['team_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">取消返回</a>
                            <button type="submit" class="btn btn-success">確認新增</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>