<?php
session_start();
require_once '../includes/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference = $_POST['reference'] ?? '';
    $campaign_id = !empty($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : null;
    $amount = (float)($_POST['amount'] ?? 0);
    $email = $_POST['email'] ?? '';
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$reference || !$amount) {
        echo json_encode(['success' => false, 'message' => 'Invalid payment data.']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'paystack_secret_key'");
    $stmt->execute();
    $paystack_secret_key = $stmt->fetchColumn() ?: 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

    // Verify transaction via Paystack API
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer " . $paystack_secret_key,
            "Cache-Control: no-cache",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo json_encode(['success' => false, 'message' => 'cURL Error: ' . $err]);
        exit;
    }

    $tranx = json_decode($response);

    if (!$tranx->status) {
        // API returned error
        echo json_encode(['success' => false, 'message' => 'API Error: ' . $tranx->message]);
        exit;
    }

    if ('success' !== $tranx->data->status) {
        // Transaction was not successful
        echo json_encode(['success' => false, 'message' => 'Transaction was not successful. Status: ' . $tranx->data->status]);
        exit;
    }

    // Amount verification (Paystack returns amount in kobo, so divide by 100)
    $verified_amount = $tranx->data->amount / 100;
    if ($verified_amount != $amount) {
        echo json_encode(['success' => false, 'message' => 'Amount verification failed.']);
        exit;
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO donations (user_id, campaign_id, amount, reference, status) VALUES (?, ?, ?, ?, 'successful')");
        $stmt->execute([$user_id, $campaign_id, $amount, $reference]);

        if ($campaign_id) {
            $stmt = $pdo->prepare("UPDATE campaigns SET current_amount = current_amount + ? WHERE id = ?");
            $stmt->execute([$amount, $campaign_id]);
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Payment verified and recorded successfully.']);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
