<?php
require_once 'db.php';
$sql = "SELECT p.player_id, p.name AS player_name, t.team_name, s.at_bats, s.hits, s.home_runs 
        FROM players p 
        LEFT JOIN teams t ON p.team_id = t.team_id
        LEFT JOIN player_game_stats s ON p.player_id = s.player_id
        ORDER BY t.team_id ASC, p.player_id ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MLB 選手數據管理系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">⚾ MLB 數據管理系統</a>
        <div class="d-flex align-items-center">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="text-white me-3">歡迎，<?= htmlspecialchars($_SESSION['username']) ?></span>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="add_player.php" class="btn btn-success btn-sm me-2">➕ 新增球員</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-danger btn-sm">登出</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-light btn-sm">系統登入</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <h2 class="mb-4">球員數據排行榜</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <table id="myTable" class="table table-hover table-bordered text-center align-middle w-100">
                <thead class="table-dark">
                    <tr>
                        <th>球員姓名</th>
                        <th>所屬球隊</th>
                        <th>打數 (AB)</th>
                        <th>安打 (H)</th>
                        <th>全壘打 (HR)</th>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <th>操作 (Admin)</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td class="text-start fw-bold"><?= htmlspecialchars($row['player_name']) ?></td>
                            <td><?= htmlspecialchars($row['team_name'] ?? '無') ?></td>
                            <td><?= htmlspecialchars($row['at_bats'] ?? 0) ?></td>
                            <td><?= htmlspecialchars($row['hits'] ?? 0) ?></td>
                            <td><?= htmlspecialchars($row['home_runs'] ?? 0) ?></td>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <td>
                                    <a href="edit_player.php?id=<?= $row['player_id'] ?>" class="btn btn-sm btn-primary">✏️ 編輯</a>
                                    <a href="delete_player.php?id=<?= $row['player_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('確定要刪除嗎？');">🗑️ 刪除</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/zh-HANT.json" // 中文化設定
        }
    });
});
</script>

</body>
</html>