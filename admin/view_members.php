<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
require_once '../includes/db.php';

// Handle Actions
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id !== $_SESSION['user_id']) { // prevent self-deletion
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: view_members.php");
    exit;
}

if (isset($_GET['toggle_role'])) {
    $id = (int)$_GET['toggle_role'];
    if ($id !== $_SESSION['user_id']) { // prevent self-demotion
        $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $current_role = $stmt->fetchColumn();
        if ($current_role) {
            $new_role = $current_role === 'admin' ? 'member' : 'admin';
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$new_role, $id]);
        }
    }
    header("Location: view_members.php");
    exit;
}

include 'includes/admin_header.php';

$members = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>

<div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/80">
        <h3 class="font-bold text-navy text-lg">Registered Members</h3>
        <span class="bg-accent/10 text-accent text-xs font-bold px-3 py-1 rounded-full"><?php echo count($members); ?> Total</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Member Details</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Joined</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-50">
                <?php foreach($members as $m): ?>
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-navy text-white flex items-center justify-center font-bold font-serif shadow-sm">
                                <?php echo strtoupper(substr($m['first_name'], 0, 1) . substr($m['last_name'], 0, 1)); ?>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-navy"><?php echo htmlspecialchars($m['first_name'].' '.$m['last_name']); ?></div>
                                <div class="text-xs text-gray-400 mt-0.5 capitalize"><?php echo htmlspecialchars($m['member_type'] ?? 'member'); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-600"><a href="mailto:<?php echo htmlspecialchars($m['email']); ?>" class="hover:text-accent transition"><?php echo htmlspecialchars($m['email']); ?></a></div>
                        <div class="text-xs text-gray-400 mt-0.5"><?php echo htmlspecialchars($m['phone'] ?? ''); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full <?php echo $m['role'] === 'admin' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-green-50 text-accent border border-green-100'; ?>">
                            <?php echo ucfirst($m['role']); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo date('M d, Y', strtotime($m['created_at'])); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <?php if ($m['id'] !== $_SESSION['user_id']): ?>
                            <a href="?toggle_role=<?php echo $m['id']; ?>" class="text-gray-400 hover:text-accent mr-3 transition" title="Toggle Role">
                                <i class="fa-solid fa-user-shield"></i>
                            </a>
                            <a href="?delete=<?php echo $m['id']; ?>" onclick="return confirm('Are you sure you want to delete this member?');" class="text-gray-400 hover:text-red-500 transition" title="Delete Member">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        <?php else: ?>
                            <span class="text-xs text-gray-300 italic">Current User</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if(empty($members)): ?>
    <div class="p-8 text-center text-gray-400 text-sm">
        No members found.
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/admin_footer.php'; ?>
