<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real application, you would use mail() or PHPMailer here.
    // For now, we simulate a successful email submission.
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Thank you for contacting us. We will get back to you shortly.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
