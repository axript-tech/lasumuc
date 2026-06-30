<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
require_once '../includes/db.php';

$filter_campaign = $_GET['filter_campaign'] ?? 'all';

// Fetch all campaigns for the filter dropdown
$campaigns = $pdo->query("SELECT id, title FROM campaigns ORDER BY title ASC")->fetchAll();

$query = "
    SELECT d.*, c.title as campaign_title, u.first_name, u.last_name, u.email 
    FROM donations d 
    LEFT JOIN campaigns c ON d.campaign_id = c.id 
    LEFT JOIN users u ON d.user_id = u.id 
";
$params = [];

if ($filter_campaign === 'general') {
    $query .= " WHERE d.campaign_id IS NULL ";
} elseif ($filter_campaign !== 'all') {
    $query .= " WHERE d.campaign_id = ? ";
    $params[] = (int)$filter_campaign;
}

$query .= " ORDER BY d.created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$donations = $stmt->fetchAll();

// Calculate Total (only successful)
$total_amount = 0;
foreach($donations as $d) {
    if ($d['status'] === 'successful') {
        $total_amount += $d['amount'];
    }
}

include 'includes/admin_header.php';
?>

<!-- Summary & Filter Section -->
<div class="mb-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Total Card -->
    <div class="lg:col-span-1 bg-gradient-to-br from-navy via-[#0f2a4a] to-accent rounded-3xl p-8 relative overflow-hidden shadow-xl shadow-navy/20 group transition-all duration-300 hover:-translate-y-1">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-all duration-500"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-accent/20 rounded-full blur-xl group-hover:bg-accent/30 transition-all duration-500"></div>
        
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <p class="text-white/70 text-xs font-bold uppercase tracking-widest">Total Collected</p>
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white shadow-inner border border-white/10">
                    <i class="fa-solid fa-hand-holding-dollar text-lg"></i>
                </div>
            </div>
            <h2 class="text-4xl font-serif font-extrabold text-white tracking-tight drop-shadow-md">
                ₦<?php echo number_format($total_amount); ?>
            </h2>
            <p class="text-white/60 text-xs mt-2 font-medium">From successful transactions</p>
        </div>
    </div>
    
    <!-- Filter Card -->
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 flex flex-col justify-center relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gray-50 rounded-full blur-3xl -z-10 group-hover:bg-accent/5 transition-colors duration-700"></div>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center">
                <i class="fa-solid fa-filter"></i>
            </div>
            <h3 class="font-bold text-navy text-lg">Filter Records</h3>
        </div>
        <p class="text-sm font-medium text-gray-500 mb-4">Select a specific campaign to view its dedicated donation history and updated totals.</p>
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <select name="filter_campaign" class="w-full pl-11 pr-10 py-3.5 border border-gray-200 rounded-2xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-accent/20 focus:border-accent bg-gray-50/50 hover:bg-gray-50 transition appearance-none shadow-inner">
                    <option value="all" <?php echo $filter_campaign === 'all' ? 'selected' : ''; ?>>All Donations (Global)</option>
                    <option value="general" <?php echo $filter_campaign === 'general' ? 'selected' : ''; ?>>General Fund Only</option>
                    <optgroup label="Specific Campaigns">
                        <?php foreach($campaigns as $c): ?>
                            <option value="<?php echo $c['id']; ?>" <?php echo $filter_campaign == $c['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($c['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </div>
            <button type="submit" class="bg-navy hover:bg-accent text-white px-8 py-3.5 rounded-2xl transition-all duration-300 font-bold text-sm shadow-[0_4px_14px_0_rgba(15,42,74,0.25)] hover:shadow-[0_6px_20px_rgba(42,168,110,0.23)] hover:-translate-y-0.5 whitespace-nowrap flex items-center justify-center gap-2">
                Apply Filter <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="font-bold text-navy text-lg">Donation History</h3>
        <span class="bg-accent/10 text-accent text-xs font-bold px-3 py-1 rounded-full"><?php echo count($donations); ?> Transactions</span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Reference</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Donor Details</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Campaign</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-50">
                <?php foreach($donations as $d): ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-1 rounded inline-block">
                            <?php echo htmlspecialchars($d['reference']); ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-navy">
                                    <?php echo $d['user_id'] ? htmlspecialchars($d['first_name'].' '.$d['last_name']) : 'Guest Donor'; ?>
                                </div>
                                <?php if($d['user_id']): ?>
                                    <div class="text-xs text-gray-400 mt-0.5"><?php echo htmlspecialchars($d['email']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-600 font-medium">
                            <?php echo $d['campaign_id'] ? htmlspecialchars($d['campaign_title']) : 'General Fund'; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-lg font-bold text-navy font-serif">
                            ₦<?php echo number_format($d['amount']); ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php 
                        $status_class = 'bg-gray-100 text-gray-600';
                        if($d['status'] === 'successful') $status_class = 'bg-green-100 text-green-700';
                        if($d['status'] === 'failed') $status_class = 'bg-red-100 text-red-700';
                        if($d['status'] === 'pending') $status_class = 'bg-yellow-100 text-yellow-700';
                        ?>
                        <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wider <?php echo $status_class; ?>">
                            <?php echo htmlspecialchars($d['status']); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo date('M d, Y h:i A', strtotime($d['created_at'])); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?php if(empty($donations)): ?>
    <div class="p-8 text-center text-gray-400 text-sm">
        No donations found.
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/admin_footer.php'; ?>
