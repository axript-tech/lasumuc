<?php
$base_url = '/lasumuc'; // Adjust based on deployment
$stmt = $pdo->query("SELECT setting_value FROM settings WHERE setting_key = 'site_name'");
$site_title = $stmt->fetchColumn() ?: 'LASUMUC';

$stmt = $pdo->query("SELECT setting_value FROM settings WHERE setting_key = 'site_logo'");
$site_logo = $stmt->fetchColumn() ?: '';

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo htmlspecialchars($site_title); ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Mirza:wght@400;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#081634',
                        forest: '#20803c',
                        accent: '#059669', // Emerald Green
                    },
                    fontFamily: {
                        sans: ['Quicksand', 'sans-serif'],
                        serif: ['Quicksand', 'sans-serif'],
                        arabic: ['Mirza', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/custom.css">
</head>
<body class="bg-gray-50 text-navy font-sans antialiased h-screen overflow-hidden flex">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-navy text-white flex flex-col flex-shrink-0 relative overflow-hidden hidden md:flex">
        <!-- Subtle Pattern Background -->
        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%23059669\\' fill-opacity=\\'1\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="h-16 flex items-center px-6 border-b border-white/10 relative z-10">
            <a href="<?php echo $base_url; ?>/admin/index.php" class="flex items-center gap-3">
                <?php if(!empty($site_logo)): ?>
                    <img src="<?php echo $base_url; ?>/assets/img/uploads/<?php echo htmlspecialchars($site_logo); ?>" alt="Logo" class="w-8 h-8 object-cover rounded-full border border-white/20">
                <?php else: ?>
                    <i class="fa-solid fa-mosque text-accent"></i>
                <?php endif; ?>
                <span class="font-bold tracking-wider uppercase text-sm">LASUMUC Admin</span>
            </a>
        </div>
        
        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-2 relative z-10">
            <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Dashboard</p>
            <a href="index.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?php echo $current_page == 'index.php' ? 'bg-accent/20 text-accent font-bold' : 'text-gray-300 hover:bg-white/5 hover:text-white'; ?>">
                <i class="fa-solid fa-chart-line w-5 text-center"></i> Overview
            </a>
            
            <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Management</p>
            <a href="view_members.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?php echo $current_page == 'view_members.php' ? 'bg-accent/20 text-accent font-bold' : 'text-gray-300 hover:bg-white/5 hover:text-white'; ?>">
                <i class="fa-solid fa-users w-5 text-center"></i> Members
            </a>
            <a href="view_donations.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?php echo $current_page == 'view_donations.php' ? 'bg-accent/20 text-accent font-bold' : 'text-gray-300 hover:bg-white/5 hover:text-white'; ?>">
                <i class="fa-solid fa-hand-holding-dollar w-5 text-center"></i> Donations
            </a>
            <a href="manage_campaigns.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?php echo $current_page == 'manage_campaigns.php' ? 'bg-accent/20 text-accent font-bold' : 'text-gray-300 hover:bg-white/5 hover:text-white'; ?>">
                <i class="fa-solid fa-bullhorn w-5 text-center"></i> Campaigns
            </a>
            <a href="manage_news.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?php echo $current_page == 'manage_news.php' ? 'bg-accent/20 text-accent font-bold' : 'text-gray-300 hover:bg-white/5 hover:text-white'; ?>">
                <i class="fa-solid fa-newspaper w-5 text-center"></i> News & Updates
            </a>
            <a href="manage_marketplace.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?php echo $current_page == 'manage_marketplace.php' ? 'bg-accent/20 text-accent font-bold' : 'text-gray-300 hover:bg-white/5 hover:text-white'; ?>">
                <i class="fa-solid fa-store w-5 text-center"></i> Marketplace
            </a>
            
            <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">System</p>
            <a href="settings.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors <?php echo $current_page == 'settings.php' ? 'bg-accent/20 text-accent font-bold' : 'text-gray-300 hover:bg-white/5 hover:text-white'; ?>">
                <i class="fa-solid fa-cog w-5 text-center"></i> Settings
            </a>
        </div>
        
        <div class="p-4 border-t border-white/10 relative z-10">
            <a href="<?php echo $base_url; ?>/index.php" class="flex items-center gap-3 px-3 py-2.5 text-gray-400 hover:text-white transition-colors">
                <i class="fa-solid fa-globe w-5 text-center"></i> View Website
            </a>
            <a href="<?php echo $base_url; ?>/logout.php" class="flex items-center gap-3 px-3 py-2.5 text-red-400 hover:text-red-300 hover:bg-red-400/10 rounded-xl transition-colors mt-1">
                <i class="fa-solid fa-sign-out-alt w-5 text-center"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50/50">
        <!-- Topbar (Mobile Hamburger & User Profile) -->
        <header class="bg-white/80 backdrop-blur-md h-16 border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 z-20 shadow-sm">
            <div class="flex items-center">
                <button class="md:hidden text-gray-500 hover:text-navy mr-4">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-navy hidden sm:block">
                    <?php 
                    $page_titles = [
                        'index.php' => 'Dashboard Overview',
                        'view_members.php' => 'Member Management',
                        'view_donations.php' => 'Donation Tracking',
                        'manage_campaigns.php' => 'Campaign Management',
                        'manage_news.php' => 'News & Updates',
                        'manage_marketplace.php' => 'Marketplace Management',
                        'settings.php' => 'System Settings'
                    ];
                    echo $page_titles[$current_page] ?? 'Admin Panel';
                    ?>
                </h2>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 bg-gray-50 py-1.5 px-3 rounded-full border border-gray-200 cursor-pointer hover:bg-gray-100 transition">
                    <div class="w-7 h-7 rounded-full bg-accent/20 text-accent flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <span class="text-sm font-bold text-navy pr-1">Admin</span>
                </div>
            </div>
        </header>

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 relative">
            <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%23059669\\' fill-opacity=\\'1\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            <div class="relative z-10 max-w-7xl mx-auto">
