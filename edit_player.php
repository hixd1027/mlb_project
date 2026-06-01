<?php
require_once 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
$teams_stmt = $conn->query("SELECT team_id, team_name FROM teams");
$teams = $teams_stmt->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$player_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM players WHERE player_id = :id");
$stmt->execute(['id' => $player_id]);
$player = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$player) {
    header("Location: index.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $team_id = $_POST['team_id'];

    if (!empty($name) && !empty($position) && !empty($team_id)) {
        $update_sql = "UPDATE players SET name = :name, position = :position, team_id = :team_id WHERE player_id = :id";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->execute([
            'name' => $name,
            'position' => $position,
            'team_id' => $team_id,
            'id' => $player_id
        ]);
        
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編輯球員 - MLB 數據管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">✏️ 編輯球員資料</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="edit_player.php?id=<?= $player['player_id'] ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">球員姓名</label>
                            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($player['name']) ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">守備位置</label>
                            <input type="text" name="position" class="form-control" required value="<?= htmlspecialchars($player['position']) ?>">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">所屬球隊</label>
                            <select name="team_id" class="form-select" required>
                                <?php foreach ($teams as $team): ?>
                                    <option value="<?= $team['team_id'] ?>" <?= ($team['team_id'] == $player['team_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($team['team_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">取消返回</a>
                            <button type="submit" class="btn btn-primary">儲存修改</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>