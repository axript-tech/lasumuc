<?php
session_start();
require '../includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$points_to_add = isset($_POST['points']) ? (int)$_POST['points'] : 0;

if ($points_to_add <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid points']);
    exit;
}

try {
    // Check if score exists
    $stmt = $pdo->prepare("SELECT score FROM quiz_scores WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $existing = $stmt->fetch();

    if ($existing) {
        $new_score = $existing['score'] + $points_to_add;
        $update = $pdo->prepare("UPDATE quiz_scores SET score = ? WHERE user_id = ?");
        $update->execute([$new_score, $user_id]);
        echo json_encode(['success' => true, 'new_score' => $new_score]);
    } else {
        $insert = $pdo->prepare("INSERT INTO quiz_scores (user_id, score) VALUES (?, ?)");
        $insert->execute([$user_id, $points_to_add]);
        echo json_encode(['success' => true, 'new_score' => $points_to_add]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>
