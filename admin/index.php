<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
require_once '../includes/db.php';
include 'includes/admin_header.php';

// Fetch stats
$total_members = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_donations = $pdo->query("SELECT SUM(amount) FROM donations WHERE status = 'successful'")->fetchColumn() ?: 0;
$total_campaigns = $pdo->query("SELECT COUNT(*) FROM campaigns")->fetchColumn();
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="relative overflow-hidden bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 group hover:-translate-y-1 transition-all duration-300">
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-blue-50 rounded-full blur-2xl group-hover:bg-blue-100 transition-colors duration-500 -z-10"></div>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Total Members</p>
                <p class="text-4xl font-extrabold text-navy font-serif tracking-tight drop-shadow-sm"><?php echo number_format($total_members); ?></p>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-blue-50/80 backdrop-blur-sm border border-blue-100/50 text-blue-500 flex items-center justify-center shadow-inner group-hover:rotate-12 transition-transform duration-500">
                <i class="fa-solid fa-users text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="relative overflow-hidden bg-gradient-to-br from-navy via-[#0f2a4a] to-accent p-8 rounded-3xl shadow-xl shadow-navy/20 group hover:-translate-y-1 transition-all duration-300">
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors duration-500 z-0"></div>
        <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-accent/20 rounded-full blur-xl z-0"></div>
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-white/70 text-xs font-bold uppercase tracking-wider mb-2">Total Donations</p>
                <p class="text-3xl font-extrabold text-white font-serif tracking-tight drop-shadow-md">₦<?php echo number_format($total_donations, 2); ?></p>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/10 text-white flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-500">
                <i class="fa-solid fa-hand-holding-dollar text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="relative overflow-hidden bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 group hover:-translate-y-1 transition-all duration-300">
        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-purple-50 rounded-full blur-2xl group-hover:bg-purple-100 transition-colors duration-500 -z-10"></div>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Active Campaigns</p>
                <p class="text-4xl font-extrabold text-navy font-serif tracking-tight drop-shadow-sm"><?php echo number_format($total_campaigns); ?></p>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-purple-50/80 backdrop-blur-sm border border-purple-100/50 text-purple-500 flex items-center justify-center shadow-inner group-hover:-rotate-12 transition-transform duration-500">
                <i class="fa-solid fa-bullhorn text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="manage_campaigns.php" class="relative overflow-hidden bg-white p-6 rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-gray-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:border-accent/40 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-accent/5 rounded-full blur-xl group-hover:bg-accent/10 transition-colors duration-500"></div>
        <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:text-accent group-hover:bg-accent/10 transition-all duration-300 shadow-inner group-hover:scale-110">
            <i class="fa-solid fa-bullhorn text-xl"></i>
        </div>
        <div class="relative z-10">
            <h3 class="font-bold text-navy text-lg group-hover:text-accent transition-colors">Manage Campaigns</h3>
            <p class="text-sm text-gray-500 mt-0.5">Create or edit fundraisers</p>
        </div>
    </a>

    <a href="manage_news.php" class="relative overflow-hidden bg-white p-6 rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-gray-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:border-blue-500/40 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors duration-500"></div>
        <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:text-blue-500 group-hover:bg-blue-50 transition-all duration-300 shadow-inner group-hover:scale-110">
            <i class="fa-solid fa-newspaper text-xl"></i>
        </div>
        <div class="relative z-10">
            <h3 class="font-bold text-navy text-lg group-hover:text-blue-500 transition-colors">Manage News</h3>
            <p class="text-sm text-gray-500 mt-0.5">Publish site updates</p>
        </div>
    </a>

    <a href="settings.php" class="relative overflow-hidden bg-white p-6 rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-gray-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:border-purple-500/40 hover:-translate-y-1 transition-all duration-300 flex items-center gap-5 group">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-purple-500/5 rounded-full blur-xl group-hover:bg-purple-500/10 transition-colors duration-500"></div>
        <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:text-purple-500 group-hover:bg-purple-50 transition-all duration-300 shadow-inner group-hover:scale-110">
            <i class="fa-solid fa-cog text-xl"></i>
        </div>
        <div class="relative z-10">
            <h3 class="font-bold text-navy text-lg group-hover:text-purple-500 transition-colors">Site Settings</h3>
            <p class="text-sm text-gray-500 mt-0.5">Configure global options</p>
        </div>
    </a>
</div>

<?php include 'includes/admin_footer.php'; ?>
