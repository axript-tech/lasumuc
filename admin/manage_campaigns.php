<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $target = $_POST['target_amount'];
        $bank_name = $_POST['bank_name'] ?: null;
        $account_name = $_POST['account_name'] ?: null;
        $account_number = $_POST['account_number'] ?: null;
        
        $image_name = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/img/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($file_ext, $allowed_exts)) {
                $image_name = 'campaign_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO campaigns (title, description, target_amount, bank_name, account_name, account_number, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $desc, $target, $bank_name, $account_name, $account_number, $image_name]);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $target = $_POST['target_amount'];
        $status = $_POST['status'] ?? 'active';
        $bank_name = $_POST['bank_name'] ?: null;
        $account_name = $_POST['account_name'] ?: null;
        $account_number = $_POST['account_number'] ?: null;
        
        $update_image = false;
        $image_name = null;
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/img/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($file_ext, $allowed_exts)) {
                $image_name = 'campaign_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
                $update_image = true;
            }
        }
        
        if ($update_image) {
            $stmt = $pdo->prepare("UPDATE campaigns SET title = ?, description = ?, target_amount = ?, status = ?, bank_name = ?, account_name = ?, account_number = ?, image = ? WHERE id = ?");
            $stmt->execute([$title, $desc, $target, $status, $bank_name, $account_name, $account_number, $image_name, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE campaigns SET title = ?, description = ?, target_amount = ?, status = ?, bank_name = ?, account_name = ?, account_number = ? WHERE id = ?");
            $stmt->execute([$title, $desc, $target, $status, $bank_name, $account_name, $account_number, $id]);
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM campaigns WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: manage_campaigns.php");
    exit;
}

include 'includes/admin_header.php';

$edit_campaign = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM campaigns WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_campaign = $stmt->fetch();
}

$campaigns = $pdo->query("SELECT * FROM campaigns ORDER BY created_at DESC")->fetchAll();
?>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    
    <!-- Left Column: Create/Edit Form -->
    <div class="xl:col-span-1">
        <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-accent/5 rounded-full blur-3xl group-hover:bg-accent/10 transition-colors duration-500"></div>
            <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4 relative z-10">
                <h2 class="text-2xl font-serif font-bold text-navy"><?php echo $edit_campaign ? 'Edit Campaign' : 'Create New Campaign'; ?></h2>
                <?php if ($edit_campaign): ?>
                    <a href="manage_campaigns.php" class="text-xs text-accent hover:underline">Cancel Edit</a>
                <?php endif; ?>
            </div>
            
            <form method="POST" action="manage_campaigns.php" enctype="multipart/form-data" class="space-y-5">
                <input type="hidden" name="action" value="<?php echo $edit_campaign ? 'edit' : 'create'; ?>">
                <?php if ($edit_campaign): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_campaign['id']; ?>">
                <?php endif; ?>
                
                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Campaign Title</label>
                    <input type="text" name="title" value="<?php echo $edit_campaign ? htmlspecialchars($edit_campaign['title']) : ''; ?>" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="4" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition resize-none"><?php echo $edit_campaign ? htmlspecialchars($edit_campaign['description']) : ''; ?></textarea>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Target Amount (₦)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none font-bold text-gray-400">₦</div>
                        <input type="number" name="target_amount" value="<?php echo $edit_campaign ? htmlspecialchars($edit_campaign['target_amount']) : ''; ?>" required class="block w-full pl-8 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                    </div>
                </div>

                <?php if ($edit_campaign): ?>
                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Status</label>
                    <select name="status" class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                        <option value="active" <?php echo (isset($edit_campaign['status']) && $edit_campaign['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo (isset($edit_campaign['status']) && $edit_campaign['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <?php endif; ?>

                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Featured Image <?php echo $edit_campaign ? '(Leave empty to keep current)' : '(Optional)'; ?></label>
                    <?php if ($edit_campaign && $edit_campaign['image']): ?>
                        <div class="mb-2">
                            <img src="../assets/img/<?php echo htmlspecialchars($edit_campaign['image']); ?>" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-accent/10 file:text-accent hover:file:bg-accent/20 transition cursor-pointer border border-gray-200 rounded-xl bg-gray-50 p-1">
                </div>

                <div class="border-t border-gray-100 pt-4 mt-2">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Optional: Specific Bank Details</h3>
                    <div class="space-y-4">
                        <div>
                            <input type="text" name="bank_name" value="<?php echo $edit_campaign ? htmlspecialchars($edit_campaign['bank_name'] ?? '') : ''; ?>" placeholder="Bank Name" class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                        </div>
                        <div>
                            <input type="text" name="account_name" value="<?php echo $edit_campaign ? htmlspecialchars($edit_campaign['account_name'] ?? '') : ''; ?>" placeholder="Account Name" class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                        </div>
                        <div>
                            <input type="text" name="account_number" value="<?php echo $edit_campaign ? htmlspecialchars($edit_campaign['account_number'] ?? '') : ''; ?>" placeholder="Account Number" class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                        </div>
                        <p class="text-[10px] text-gray-400 leading-tight">Leave blank to use the global bank settings from System Settings.</p>
                    </div>
                </div>
                
                <div class="pt-2">
                    <button type="submit" class="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-accent hover:bg-forest transition transform hover:-translate-y-0.5 uppercase tracking-wide">
                        <?php echo $edit_campaign ? 'Update Campaign' : 'Create Campaign'; ?> <i class="fa-solid <?php echo $edit_campaign ? 'fa-save' : 'fa-plus'; ?> ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Campaign List -->
    <div class="xl:col-span-2">
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/80">
                <h3 class="font-bold text-navy text-lg">Active Campaigns</h3>
                <span class="bg-accent/10 text-accent text-xs font-bold px-3 py-1 rounded-full"><?php echo count($campaigns); ?> Total</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Campaign</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Progress</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        <?php foreach($campaigns as $c): 
                            $progress = $c['target_amount'] > 0 ? min(100, round(($c['current_amount'] / $c['target_amount']) * 100)) : 0;
                        ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 flex items-start gap-4">
                                <?php if($c['image']): ?>
                                    <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200">
                                        <img src="../assets/img/<?php echo htmlspecialchars($c['image']); ?>" class="w-full h-full object-cover">
                                    </div>
                                <?php else: ?>
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0 border border-gray-200">
                                        <i class="fa-solid fa-image text-gray-300"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="text-sm font-bold text-navy mb-1 flex items-center gap-2">
                                        <span><?php echo htmlspecialchars($c['title']); ?></span>
                                        <?php if(isset($c['status']) && $c['status'] === 'inactive'): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-800">Inactive</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-xs text-gray-400 line-clamp-1"><?php echo htmlspecialchars($c['description']); ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-between text-xs mb-1">
                                    <span class="font-bold text-accent">₦<?php echo number_format($c['current_amount']); ?></span>
                                    <span class="text-gray-400">of ₦<?php echo number_format($c['target_amount']); ?></span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-accent h-1.5 rounded-full" style="width: <?php echo $progress; ?>%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="manage_campaigns.php?edit=<?php echo $c['id']; ?>" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center" title="Edit Campaign">
                                        <i class="fa-solid fa-edit text-sm"></i>
                                    </a>
                                    <form method="POST" action="manage_campaigns.php" onsubmit="return confirm('Are you sure you want to delete this campaign?');" class="m-0 p-0">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center" title="Delete Campaign">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($campaigns)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400 text-sm">No campaigns found. Create one to get started!</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
