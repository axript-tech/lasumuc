<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
require_once '../includes/db.php';

$message = '';

// Helper function to safely update or insert a setting
function updateSetting($pdo, $key, $value) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    if ($stmt->fetchColumn() > 0) {
        $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
        $stmt->execute([$value, $key]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)");
        $stmt->execute([$key, $value]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['site_logo']['tmp_name'];
        $name = basename($_FILES['site_logo']['name']);
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
        if (in_array($ext, $allowed)) {
            $new_name = 'logo_' . time() . '.' . $ext;
            $upload_dir = '../assets/img/uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $dest = $upload_dir . $new_name;
            
            if (move_uploaded_file($tmp_name, $dest)) {
                $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'site_logo'");
                $stmt->execute([$new_name]);
                $message = "Logo updated successfully.";
            } else {
                $message = "Failed to move uploaded file.";
            }
        } else {
            $message = "Invalid file type.";
        }
    }
    if (isset($_POST['update_bank_details'])) {
        updateSetting($pdo, 'bank_name', $_POST['bank_name'] ?? '');
        updateSetting($pdo, 'account_name', $_POST['account_name'] ?? '');
        updateSetting($pdo, 'account_number', $_POST['account_number'] ?? '');
        
        $message = "Bank details updated successfully.";
    }
    
    if (isset($_POST['update_paystack_keys'])) {
        updateSetting($pdo, 'paystack_public_key', $_POST['paystack_public_key'] ?? '');
        updateSetting($pdo, 'paystack_secret_key', $_POST['paystack_secret_key'] ?? '');
        
        $message = "Paystack API keys updated successfully.";
    }
}

include 'includes/admin_header.php';

// Fetch all settings
$settings = [];
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
$current_logo = $settings['site_logo'] ?? '';
$bank_name = $settings['bank_name'] ?? '';
$account_name = $settings['account_name'] ?? '';
$account_number = $settings['account_number'] ?? '';
$paystack_public_key = $settings['paystack_public_key'] ?? '';
$paystack_secret_key = $settings['paystack_secret_key'] ?? '';
?>

<div class="max-w-2xl mx-auto pb-12">
    <?php if($message): ?>
    <div class="bg-green-50 text-accent p-4 rounded-xl mb-6 border border-green-100 flex items-center gap-3 shadow-sm">
        <i class="fa-solid fa-check-circle text-lg"></i>
        <span class="font-bold text-sm"><?php echo htmlspecialchars($message); ?></span>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden relative group">
        <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-gray-50/80 to-white">
            <h2 class="text-2xl font-bold text-navy font-serif">Global Settings</h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">Manage your website configuration and API keys</p>
        </div>
        
        <div class="p-6">
            <form action="settings.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                
                <!-- Logo Upload Section -->
                <div class="bg-gray-50/80 rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-bold text-navy uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Site Identity</h3>
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <div class="flex-shrink-0">
                            <?php if($current_logo): ?>
                                <div class="w-24 h-24 rounded-full border-4 border-white shadow-md overflow-hidden bg-white flex items-center justify-center">
                                    <img src="../assets/img/uploads/<?php echo htmlspecialchars($current_logo); ?>" alt="Logo" class="w-full h-full object-cover">
                                </div>
                            <?php else: ?>
                                <div class="w-24 h-24 rounded-full border-4 border-white shadow-md bg-gray-100 flex items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-image text-3xl"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex-1 w-full">
                            <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Upload New Logo</label>
                            <input type="file" name="site_logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-accent/10 file:text-accent hover:file:bg-accent/20 cursor-pointer transition">
                            <p class="text-xs text-gray-400 mt-2">Recommended: Square image (PNG, JPG, WEBP), max 2MB.</p>
                        </div>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" name="update_logo" class="flex items-center justify-center py-3 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-accent hover:bg-forest transition transform hover:-translate-y-0.5 uppercase tracking-wide">
                        Save Logo <i class="fa-solid fa-save ml-2"></i>
                    </button>
                </div>
            </form>

            <form action="settings.php" method="POST" class="space-y-6 mt-10 border-t border-gray-200 pt-10">
                <!-- Bank Transfer Details Section -->
                <div class="bg-gray-50/80 rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-bold text-navy uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Direct Bank Transfer Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Bank Name</label>
                            <input type="text" name="bank_name" value="<?php echo htmlspecialchars($bank_name); ?>" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Account Name</label>
                            <input type="text" name="account_name" value="<?php echo htmlspecialchars($account_name); ?>" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-white transition">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Account Number</label>
                            <input type="text" name="account_number" value="<?php echo htmlspecialchars($account_number); ?>" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-white transition" placeholder="e.g. 0123456789">
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" name="update_bank_details" class="flex items-center justify-center py-3 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-accent hover:bg-forest transition transform hover:-translate-y-0.5 uppercase tracking-wide">
                        Save Bank Details <i class="fa-solid fa-save ml-2"></i>
                    </button>
                </div>
            </form>

            <form action="settings.php" method="POST" class="space-y-6 mt-10 border-t border-gray-200 pt-10">
                <!-- Paystack API Keys Section -->
                <div class="bg-gray-50/80 rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-bold text-navy uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Paystack API Keys</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Public Key</label>
                            <input type="text" name="paystack_public_key" value="<?php echo htmlspecialchars($paystack_public_key); ?>" placeholder="pk_test_..." required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Secret Key</label>
                            <input type="password" name="paystack_secret_key" value="<?php echo htmlspecialchars($paystack_secret_key); ?>" placeholder="sk_test_..." required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-white transition">
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" name="update_paystack_keys" class="flex items-center justify-center py-3 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-accent hover:bg-forest transition transform hover:-translate-y-0.5 uppercase tracking-wide">
                        Save API Keys <i class="fa-solid fa-save ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
