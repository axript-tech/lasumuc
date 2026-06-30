<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_url = '/lasumuc'; // Adjust based on deployment

// Fetch dynamic logo
$logo_stmt = null;
try {
    if (isset($pdo)) {
        $logo_stmt = $pdo->query("SELECT setting_value FROM settings WHERE setting_key = 'site_logo'");
    }
} catch(PDOException $e) {}
$site_logo = $logo_stmt ? $logo_stmt->fetchColumn() : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LASUMUC Web Portal</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mirza:wght@400;500;600;700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                        secondary: '#F9F9F9',
                        accent: '#059669', // Beautiful Emerald Green
                        // Aliasing for layout structure consistency
                        navy: '#000000',      // Rich Black
                        forest: '#047857',    // Deep Green (for hovers)
                        gold: '#10B981',      // Light Green (for gradients/highlights)
                        emerald: '#059669',   // Emerald Green
                        sky: '#000000',       // Rich Black
                        champagne: '#F9F9F9',
                        parchment: '#F9F9F9'
                    },
                    fontFamily: {
                        sans: ['Quicksand', 'sans-serif'],
                        serif: ['Quicksand', 'sans-serif'], // Overriding serif to enforce Quicksand across the board
                        arabic: ['Mirza', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/custom.css">
</head>
<body class="bg-white text-navy font-sans antialiased flex flex-col min-h-screen pt-16">
    
    <!-- Luxurious Glassmorphism Navigation -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-navy/95 backdrop-blur-xl border-b border-white/10 shadow-[0_4px_30px_rgba(8,22,52,0.3)] transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="<?php echo $base_url; ?>/index.php" class="flex-shrink-0 flex items-center gap-3 text-white hover:text-accent transition duration-300">
                    <?php if(!empty($site_logo)): ?>
                        <img src="<?php echo $base_url; ?>/assets/img/uploads/<?php echo htmlspecialchars($site_logo); ?>" alt="LASUMUC Logo" class="w-12 h-12 object-cover rounded-full border border-white/10 shadow-sm">
                    <?php else: ?>
                        <div class="w-10 h-10 rounded-full border border-accent/30 flex items-center justify-center bg-white/5">
                            <i class="fa-solid fa-mosque text-xl text-accent"></i>
                        </div>
                    <?php endif; ?>
                    <span class="font-serif font-bold text-2xl tracking-wider">LASUMUC</span>
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="<?php echo $base_url; ?>/index.php" class="text-gray-200 hover:text-accent transition duration-300 px-3 py-2 rounded-md text-sm font-medium tracking-wide">Home</a>
                <a href="<?php echo $base_url; ?>/about.php" class="text-gray-200 hover:text-accent transition duration-300 px-3 py-2 rounded-md text-sm font-medium tracking-wide">About</a>
                <a href="<?php echo $base_url; ?>/news.php" class="text-gray-200 hover:text-accent transition duration-300 px-3 py-2 rounded-md text-sm font-medium tracking-wide">News</a>
                <a href="<?php echo $base_url; ?>/marketplace.php" class="text-gray-200 hover:text-accent transition duration-300 px-3 py-2 rounded-md text-sm font-medium tracking-wide">Marketplace</a>
                
                <!-- Apps Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-1 text-gray-200 hover:text-accent transition duration-300 px-3 py-2 rounded-md text-sm font-medium tracking-wide">
                        Apps <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </button>
                    <div class="absolute left-0 mt-0 w-48 bg-white rounded-xl shadow-lg py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-y-2 transition-all duration-300 border border-gray-100">
                        <a href="<?php echo $base_url; ?>/quran.php" class="block px-4 py-2 text-sm text-navy hover:bg-gray-50 hover:text-accent transition font-medium">Al-Quran</a>
                        <a href="<?php echo $base_url; ?>/quran-quiz.php" class="block px-4 py-2 text-sm text-navy hover:bg-gray-50 hover:text-accent transition font-medium">Quran Quiz</a>
                        <a href="<?php echo $base_url; ?>/calendar.php" class="block px-4 py-2 text-sm text-navy hover:bg-gray-50 hover:text-accent transition font-medium">Hijri Calendar</a>
                    </div>
                </div>
                
                <!-- Facilities Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-1 text-gray-200 hover:text-accent transition duration-300 px-3 py-2 rounded-md text-sm font-medium tracking-wide">
                        Facilities <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </button>
                    <div class="absolute left-0 mt-0 w-48 bg-white rounded-xl shadow-lg py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-y-2 transition-all duration-300 border border-gray-100">
                        <a href="<?php echo $base_url; ?>/guesthouse.php" class="block px-4 py-2 text-sm text-navy hover:bg-gray-50 hover:text-accent transition font-medium">Guest House</a>
                    </div>
                </div>
                <a href="<?php echo $base_url; ?>/contact.php" class="text-gray-200 hover:text-accent transition duration-300 px-3 py-2 rounded-md text-sm font-medium tracking-wide">Contact</a>
                <a href="<?php echo $base_url; ?>/donate.php" class="ml-2 bg-accent hover:bg-forest text-white transition duration-300 px-5 py-2 rounded text-sm font-bold shadow-[0_0_15px_rgba(5,150,105,0.3)]">Donate</a>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <?php if($_SESSION['role'] === 'admin'): ?>
                        <a href="<?php echo $base_url; ?>/admin/index.php" class="ml-2 text-white/70 hover:text-white transition duration-300 px-3 py-2 rounded-md text-sm font-medium border border-white/20">Admin</a>
                    <?php endif; ?>
                    <a href="<?php echo $base_url; ?>/logout.php" class="text-gray-400 hover:text-gray-300 transition duration-300 px-3 py-2 rounded-md text-sm font-medium">Logout</a>
                <?php else: ?>
                    <div class="pl-4 ml-2 border-l border-white/20 flex items-center space-x-2">
                        <a href="<?php echo $base_url; ?>/login.php" class="text-gray-200 hover:text-accent transition duration-300 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="<?php echo $base_url; ?>/register.php" class="bg-white/10 hover:bg-white/20 text-white border border-white/10 transition duration-300 px-4 py-2 rounded text-sm font-medium">Register</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-200 hover:text-white hover:bg-gray-800 focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-navy border-t border-gray-700">
            <a href="<?php echo $base_url; ?>/index.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-white hover:bg-gray-800">Home</a>
            <a href="<?php echo $base_url; ?>/about.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-white hover:bg-gray-800">About</a>
            <a href="<?php echo $base_url; ?>/news.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-white hover:bg-gray-800">News</a>
            <a href="<?php echo $base_url; ?>/marketplace.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-white hover:bg-gray-800">Marketplace</a>
            
            <!-- Mobile Apps -->
            <div class="pt-2 pb-1 border-t border-gray-700/50 mt-2">
                <div class="block px-3 py-1 text-xs font-bold text-gray-400 uppercase tracking-wider">Apps</div>
                <a href="<?php echo $base_url; ?>/quran.php" class="block px-3 py-2 ml-2 rounded-md text-base font-medium text-gray-200 hover:text-white hover:bg-gray-800 flex items-center gap-2"><i class="fa-solid fa-book-open text-sm text-accent"></i> Al-Quran</a>
                <a href="<?php echo $base_url; ?>/quran-quiz.php" class="block px-3 py-2 ml-2 rounded-md text-base font-medium text-gray-200 hover:text-white hover:bg-gray-800 flex items-center gap-2"><i class="fa-solid fa-clipboard-question text-sm text-accent"></i> Quran Quiz</a>
                <a href="<?php echo $base_url; ?>/calendar.php" class="block px-3 py-2 ml-2 rounded-md text-base font-medium text-gray-200 hover:text-white hover:bg-gray-800 flex items-center gap-2"><i class="fa-solid fa-calendar-days text-sm text-accent"></i> Hijri Calendar</a>
            </div>
            <div class="border-t border-gray-700/50 mt-1 pt-1"></div>
            
            <!-- Mobile Facilities -->
            <div class="pt-2 pb-1 border-t border-gray-700/50 mt-2">
                <div class="block px-3 py-1 text-xs font-bold text-gray-400 uppercase tracking-wider">Facilities</div>
                <a href="<?php echo $base_url; ?>/guesthouse.php" class="block px-3 py-2 ml-2 rounded-md text-base font-medium text-gray-200 hover:text-white hover:bg-gray-800 flex items-center gap-2"><i class="fa-solid fa-bed text-sm text-accent"></i> Guest House</a>
            </div>
            <div class="border-t border-gray-700/50 mt-1 pt-1"></div>
            <a href="<?php echo $base_url; ?>/contact.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-white hover:bg-gray-800">Contact</a>
            <a href="<?php echo $base_url; ?>/donate.php" class="block px-3 py-2 rounded-md text-base font-medium text-accent hover:bg-gray-800">Donate</a>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="<?php echo $base_url; ?>/admin/index.php" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 text-gray-300">Admin Dashboard</a>
                <?php endif; ?>
                <a href="<?php echo $base_url; ?>/logout.php" class="block px-3 py-2 rounded-md text-base font-medium text-red-400 hover:bg-gray-800">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>/login.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-white hover:bg-gray-800">Login</a>
                <a href="<?php echo $base_url; ?>/register.php" class="block px-3 py-2 rounded-md text-base font-medium text-forest hover:bg-gray-800">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Main Container -->
<main class="flex-grow">
