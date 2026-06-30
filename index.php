<?php
require_once 'includes/db.php';
include 'includes/header.php';

// Fetch recent campaigns
$stmt = $pdo->query("SELECT * FROM campaigns ORDER BY created_at DESC LIMIT 10");
$campaigns = $stmt->fetchAll();

// Fetch recent news
$recent_news = [];
try {
    $stmt_news = $pdo->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 3");
    $recent_news = $stmt_news->fetchAll();
} catch(PDOException $e) {}
?>

<!-- Premium Hero Section -->
<div class="relative bg-gradient-to-br from-navy via-[#0d2240] to-navy overflow-hidden">
    <!-- Abstract pattern overlay (Stars/Sky vibe) -->
    <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%23d4af37\\' fill-opacity=\\'1\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="absolute top-0 right-0 w-[40rem] h-[40rem] bg-sky opacity-20 rounded-full blur-[120px] transform translate-x-1/3 -translate-y-1/3"></div>
    <div class="absolute bottom-0 left-0 w-[40rem] h-[40rem] bg-forest opacity-30 rounded-full blur-[120px] transform -translate-x-1/3 translate-y-1/3"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-16 px-4 sm:px-6 lg:px-8">
            <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-white text-sm font-medium tracking-widest uppercase mb-4">Welcome to</span>
                    <h1 class="text-5xl tracking-tight font-serif font-extrabold text-white sm:text-6xl md:text-7xl leading-tight">
                        <span class="block">Lagos State</span>
                        <span class="block text-accent-gradient">University</span>
                        <span class="block">Muslim Community</span>
                    </h1>
                    <p class="mt-6 text-base text-gray-300 sm:text-lg sm:max-w-xl sm:mx-auto md:text-xl lg:mx-0 font-light leading-relaxed">
                        Fostering brotherhood, academic excellence, and Islamic values in a premium, spiritually uplifting environment.
                    </p>
                    <div class="mt-10 sm:flex sm:justify-center lg:justify-start gap-4">
                        <a href="<?php echo $base_url; ?>/donate.php" class="w-full sm:w-auto flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded text-white bg-accent hover:bg-forest shadow-[0_0_20px_rgba(5,150,105,0.4)] transition duration-300">
                            Make a Donation
                        </a>
                        <a href="<?php echo $base_url; ?>/register.php" class="mt-4 sm:mt-0 w-full sm:w-auto flex items-center justify-center px-8 py-4 border border-white text-lg font-medium rounded text-white bg-transparent hover:bg-white/10 transition duration-300">
                            Join the Community
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Hero graphic -->
    <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <div class="h-full w-full flex items-center justify-center relative">
            <div class="absolute inset-0 bg-gradient-to-l from-transparent to-navy z-10"></div>
            <i class="fa-solid fa-mosque text-[20rem] text-gold opacity-10 absolute right-10"></i>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="bg-white py-16 -mt-8 relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="relative bg-white rounded-3xl p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-forest/40 hover:shadow-[0_15px_40px_rgba(32,128,60,0.15)] transition duration-500 group overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-forest opacity-5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 group-hover:scale-150 transition duration-700"></div>
                <div class="w-16 h-16 rounded-2xl bg-forest/10 flex items-center justify-center mb-8 border border-forest/20 group-hover:bg-forest group-hover:border-forest transition duration-500">
                    <i class="fa-solid fa-book-quran text-2xl text-forest group-hover:text-white transition duration-500"></i>
                </div>
                <h3 class="text-2xl font-serif font-bold text-forest mb-4">Islamic Education</h3>
                <p class="text-navy font-light leading-relaxed">Comprehensive classes covering Tafseer, Hadith, Fiqh, and Arabic language for all levels.</p>
            </div>

            <!-- Feature 2 -->
            <div class="relative bg-white rounded-3xl p-10 shadow-[0_15px_40px_rgb(0,0,0,0.06)] border border-gray-100 hover:border-forest/40 hover:shadow-[0_20px_50px_rgba(32,128,60,0.2)] transition duration-500 group overflow-hidden transform md:-translate-y-4">
                <div class="absolute top-0 right-0 w-32 h-32 bg-forest opacity-10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 group-hover:scale-150 transition duration-700"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-sky opacity-10 rounded-full blur-2xl transform -translate-x-1/2 translate-y-1/2"></div>
                <div class="w-16 h-16 rounded-2xl bg-forest/10 flex items-center justify-center mb-8 border border-forest/20 group-hover:bg-forest group-hover:border-forest transition duration-500 backdrop-blur-sm relative z-10">
                    <i class="fa-solid fa-users text-2xl text-forest group-hover:text-white transition duration-500"></i>
                </div>
                <h3 class="text-2xl font-serif font-bold text-forest mb-4 relative z-10">Brotherhood & Sisterhood</h3>
                <p class="text-navy font-light leading-relaxed relative z-10">Fostering strong bonds through regular meetups, mentoring, and community service projects.</p>
            </div>

            <!-- Feature 3 -->
            <div class="relative bg-white rounded-3xl p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-forest/40 hover:shadow-[0_15px_40px_rgba(32,128,60,0.15)] transition duration-500 group overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-forest opacity-5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 group-hover:scale-150 transition duration-700"></div>
                <div class="w-16 h-16 rounded-2xl bg-forest/10 flex items-center justify-center mb-8 border border-forest/20 group-hover:bg-forest group-hover:border-forest transition duration-500">
                    <i class="fa-solid fa-graduation-cap text-2xl text-forest group-hover:text-white transition duration-500"></i>
                </div>
                <h3 class="text-2xl font-serif font-bold text-forest mb-4">Academic Excellence</h3>
                <p class="text-navy font-light leading-relaxed">Tutorials, study groups, and career guidance to ensure outstanding academic performance.</p>
            </div>
        </div>
    </div>
</div>

<!-- Prayer Times & Calendar Section -->
<section class="py-24 bg-gray-50 relative overflow-hidden border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-accent font-bold tracking-widest uppercase text-sm mb-2 block">Community Spirit</span>
            <h2 class="text-4xl md:text-5xl font-bold text-navy mb-6 font-serif">Daily Prayers &amp; Calendar</h2>
            <div class="w-20 h-1.5 bg-accent mx-auto rounded-full mb-6"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Prayer Times Card -->
            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 md:p-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-navy/5 rounded-bl-full opacity-50"></div>
                <div class="relative z-10">
                    <div class="flex justify-between items-end mb-4 border-b border-gray-100 pb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-navy flex items-center">
                                <i class="fa-regular fa-clock w-6 h-6 mr-3 text-accent text-xl flex items-center"></i> Lagos Prayer Times
                            </h3>
                            <p class="text-sm text-gray-500 mt-1" id="gregorian-date-display">Loading...</p>
                        </div>
                        <div class="text-right">
                            <span class="bg-navy/10 text-navy text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block" id="next-prayer-badge">...</span>
                            <div class="text-2xl font-bold text-accent font-serif tracking-widest" id="next-prayer-countdown">--:--:--</div>
                            <div class="text-[9px] text-gray-400 uppercase tracking-widest">Time Remaining</div>
                        </div>
                    </div>
                    
                    <!-- Sun/Moon Live Graphic -->
                    <div class="my-8 relative w-full aspect-[2.5/1]">
                        <svg width="100%" height="100%" viewBox="0 0 200 100" class="overflow-visible absolute inset-0">
                            <!-- Dashed Background Arc -->
                            <path d="M 10 100 A 90 90 0 0 1 190 100" fill="none" stroke="#e5e7eb" stroke-width="2" stroke-dasharray="5,5" />
                            <!-- Filled Arc -->
                            <path id="sun-arc-path" d="M 10 100 A 90 90 0 0 1 190 100" fill="none" stroke="#f8bc2c" stroke-width="4" stroke-dasharray="283" stroke-dashoffset="283" class="transition-all duration-1000" />
                            
                            <!-- Moving Icon -->
                            <foreignObject x="10" y="100" width="40" height="40" id="live-sun-fo" style="overflow: visible;" class="transition-all duration-1000">
                                <div id="celestial-bg" class="w-8 h-8 m-1 rounded-full bg-white border-2 border-gold flex items-center justify-center shadow-[0_0_15px_rgba(248,188,44,0.6)] transition-colors duration-1000">
                                    <i class="fa-solid fa-sun text-gold text-sm transition-colors duration-1000" id="celestial-icon"></i>
                                </div>
                            </foreignObject>
                        </svg>
                        <!-- Labels -->
                        <div class="absolute bottom-0 left-0 w-full flex justify-between text-[9px] font-bold text-gray-400 uppercase tracking-widest px-2 transform translate-y-full pt-4">
                            <span id="sun-start-label">Sunrise</span>
                            <span id="sun-end-label">Sunset</span>
                        </div>
                    </div>

                    <div class="space-y-4" id="prayer-times-container">
                        <div class="animate-pulse flex flex-col space-y-4">
                            <div class="h-16 bg-gray-100 rounded-xl"></div>
                            <div class="h-16 bg-gray-100 rounded-xl"></div>
                            <div class="h-16 bg-gray-100 rounded-xl"></div>
                            <div class="h-16 bg-gray-100 rounded-xl"></div>
                            <div class="h-16 bg-gray-100 rounded-xl"></div>
                            <div class="h-16 bg-gray-100 rounded-xl"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Islamic Calendar Card -->
            <div class="bg-navy text-white rounded-[2rem] shadow-[0_15px_40px_rgba(0,0,0,0.2)] p-8 md:p-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-5 pointer-events-none transform translate-x-1/4 -translate-y-1/4">
                    <i class="fa-solid fa-moon text-[15rem]"></i>
                </div>
                <div class="relative z-10">
                    <div class="mb-8 border-b border-white/10 pb-6">
                        <h3 class="text-2xl font-bold flex items-center">
                            <i class="fa-regular fa-calendar w-6 h-6 mr-3 text-gold text-xl flex items-center"></i> Islamic Calendar
                        </h3>
                        <p class="text-xl text-gold font-bold mt-2 font-arabic mb-6" id="hijri-date-display">Loading...</p>

                        <!-- Countdown Container -->
                        <div id="event-countdown-container" class="hidden bg-white/5 rounded-2xl p-5 border border-white/10 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-gold/10 rounded-bl-full blur-xl pointer-events-none"></div>
                            <p class="text-[11px] font-bold tracking-widest uppercase text-gray-400 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-hourglass-half text-gold"></i> Countdown to <span id="countdown-event-name" class="text-white"></span>
                            </p>
                            <div class="flex gap-4 justify-between" id="countdown-timer">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>

                    <h4 class="text-sm font-bold tracking-wider uppercase text-gray-400 mb-6">Upcoming Key Dates</h4>
                    <ul class="space-y-5" id="important-dates-list">
                        <div class="animate-pulse flex flex-col space-y-4">
                            <div class="h-12 bg-white/10 rounded-xl"></div>
                            <div class="h-12 bg-white/10 rounded-xl"></div>
                            <div class="h-12 bg-white/10 rounded-xl"></div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Daily Inspirations Section -->
<div class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-sm text-gold font-bold tracking-widest uppercase mb-2">Daily Reminders</h2>
            <p class="text-4xl font-serif font-extrabold text-forest">
                Inspirations
            </p>
            <div class="w-24 h-1 bg-gradient-to-r from-transparent via-forest to-transparent mx-auto mt-6 rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Verse of the Day -->
            <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-accent opacity-5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-accent/10 flex items-center justify-center text-accent">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <h3 class="text-xl font-bold text-navy">Verse of the Day</h3>
                </div>
                
                <div id="quran-container" class="animate-pulse">
                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded w-full mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                </div>
            </div>

            <!-- Hadith of the Day -->
            <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gold opacity-5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center text-gold">
                        <i class="fa-solid fa-comment-dots"></i>
                    </div>
                    <h3 class="text-xl font-bold text-navy">Hadith of the Day</h3>
                </div>
                
                <div id="hadith-container">
                     <!-- Populated by JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Campaigns Section -->
<div class="bg-white py-20 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div class="text-left">
                <h2 class="text-sm text-accent font-bold tracking-widest uppercase mb-2">Support Our Cause</h2>
                <p class="text-4xl font-serif font-extrabold text-forest">
                    Ongoing Campaigns
                </p>
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-forest to-transparent mt-6 rounded-full"></div>
            </div>
            <div class="hidden sm:flex gap-2">
                <button onclick="document.getElementById('campaigns-carousel').scrollBy({left: -382, behavior: 'smooth'})" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-accent hover:border-accent hover:bg-accent/5 transition focus:outline-none">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button onclick="document.getElementById('campaigns-carousel').scrollBy({left: 382, behavior: 'smooth'})" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-accent hover:border-accent hover:bg-accent/5 transition focus:outline-none">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
        
        <div class="relative">
            <div id="campaigns-carousel" class="flex overflow-x-auto snap-x snap-mandatory gap-8 pb-8 -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-hide">
            <?php if(empty($campaigns)): ?>
                <div class="w-full text-center text-gray-500 py-12 text-lg">No ongoing campaigns at the moment.</div>
            <?php else: ?>
                <?php foreach($campaigns as $camp): 
                    $percent = $camp['target_amount'] > 0 ? min(100, ($camp['current_amount'] / $camp['target_amount']) * 100) : 0;
                ?>
                <div class="snap-start shrink-0 w-[85vw] sm:w-[350px] lg:w-[400px] bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden hover-scale border border-gray-100 flex flex-col group hover:border-gold/30 hover:shadow-[0_15px_40px_rgba(248,188,44,0.1)] transition duration-500">
                    <div class="h-56 bg-navy flex items-center justify-center relative overflow-hidden">
                        <?php if($camp['image']): ?>
                            <img src="<?php echo $base_url; ?>/assets/img/<?php echo htmlspecialchars($camp['image']); ?>" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition duration-500">
                        <?php else: ?>
                            <i class="fa-solid fa-hand-holding-dollar text-6xl text-gold opacity-50"></i>
                            <div class="absolute inset-0 bg-gradient-to-t from-navy to-transparent opacity-60"></div>
                        <?php endif; ?>
                    </div>
                    <div class="p-8 flex-grow flex flex-col relative bg-white">
                        <div class="absolute top-0 right-8 -mt-6 bg-accent text-white text-xs font-bold px-4 py-2 rounded shadow-md uppercase tracking-wider">Urgent</div>
                        <h3 class="text-2xl font-serif font-bold text-forest mb-3 leading-snug group-hover:text-navy transition"><?php echo htmlspecialchars($camp['title']); ?></h3>
                        <p class="text-navy font-light mb-6 line-clamp-3 leading-relaxed flex-grow"><?php echo htmlspecialchars($camp['description']); ?></p>
                        
                        <div class="mb-6">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="font-bold text-forest">₦<?php echo number_format($camp['current_amount']); ?></span>
                                <span class="text-navy opacity-60">Target: ₦<?php echo number_format($camp['target_amount']); ?></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-emerald h-2 rounded-full relative" style="width: <?php echo $percent; ?>%">
                                    <div class="absolute inset-0 bg-white/20 w-full h-full animate-[shimmer_2s_infinite]"></div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo $base_url; ?>/donate.php?campaign=<?php echo $camp['id']; ?>" class="w-full text-center bg-white border-2 border-navy text-navy hover:bg-navy hover:text-white py-3 rounded transition font-bold tracking-wide uppercase text-sm">Contribute Now</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Latest News Section -->
<div class="py-20 bg-gray-50 border-t border-gray-100 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-accent/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gold/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div>
                <h2 class="text-sm text-gold font-bold tracking-widest uppercase mb-2">Stay Updated</h2>
                <p class="text-4xl font-serif font-extrabold text-navy">
                    Latest News & Events
                </p>
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-forest to-transparent mt-6 rounded-full"></div>
            </div>
            <a href="<?php echo $base_url; ?>/news.php" class="inline-flex items-center text-accent hover:text-forest font-bold tracking-wide transition group">
                View All Updates 
                <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php if(empty($recent_news)): ?>
                <div class="col-span-3 text-center text-gray-400 py-12 text-lg">No news published yet. Check back later!</div>
            <?php else: ?>
                <?php foreach($recent_news as $news): ?>
                <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-accent/30 hover:shadow-[0_15px_40px_rgba(5,150,105,0.1)] transition duration-500 group flex flex-col h-full">
                    <?php if(!empty($news['image'])): ?>
                        <div class="w-full h-48 rounded-2xl overflow-hidden mb-6 relative">
                            <img src="<?php echo $base_url; ?>/assets/img/uploads/<?php echo htmlspecialchars($news['image']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                    <?php endif; ?>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="fa-regular fa-calendar text-accent"></i> <?php echo date('M d, Y', strtotime($news['created_at'])); ?>
                    </div>
                    <h3 class="text-xl font-bold text-navy mb-4 group-hover:text-accent transition leading-snug">
                        <?php echo htmlspecialchars($news['title']); ?>
                    </h3>
                    <p class="text-gray-500 font-light mb-6 line-clamp-3 leading-relaxed flex-grow">
                        <?php echo htmlspecialchars(strip_tags($news['content'])); ?>
                    </p>
                    <a href="<?php echo $base_url; ?>/news.php?id=<?php echo $news['id']; ?>" class="inline-flex items-center text-sm font-bold text-navy hover:text-accent transition">
                        Read Full Story <i class="fa-solid fa-arrow-right-long ml-2"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let dayOfYear = Math.floor((new Date() - new Date(new Date().getFullYear(), 0, 0)) / (1000 * 60 * 60 * 24));
    
    // Fetch Prayer Times & Hijri Date
    $.get('https://api.aladhan.com/v1/timingsByCity?city=Lagos&country=Nigeria&method=2', function(response) {
        if(response.code === 200) {
            let timings = response.data.timings;
            let hijri = response.data.date.hijri;
            
            $('#hijri-date-display').text(`${hijri.day} ${hijri.month.en} ${hijri.year} AH (${hijri.month.ar})`);
            
            let g = new Date();
            let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            $('#gregorian-date-display').text(g.toLocaleDateString('en-GB', options));
            
            // Calculate Upcoming Events
            const islamicEvents = [
                { name: 'Islamic New Year', month: 1, day: 1, icon: 'fa-book' },
                { name: 'Ashura', month: 1, day: 10, icon: 'fa-hand-holding-heart' },
                { name: 'Ramadan Begins', month: 9, day: 1, icon: 'fa-moon' },
                { name: 'Eid al-Fitr', month: 10, day: 1, icon: 'fa-sun' },
                { name: 'Day of Arafah', month: 12, day: 9, icon: 'fa-star' },
                { name: 'Eid al-Adha', month: 12, day: 10, icon: 'fa-heart' }
            ];
            
            let cM = parseInt(hijri.month.number);
            let cD = parseInt(hijri.day);
            
            let upcomingEvents = [...islamicEvents].sort((a, b) => {
                let aScore = a.month * 100 + a.day;
                let bScore = b.month * 100 + b.day;
                let cScore = cM * 100 + cD;
                if (aScore < cScore) aScore += 10000;
                if (bScore < cScore) bScore += 10000;
                return aScore - bScore;
            }).slice(0, 5);
            
            const hMonths = ['', 'Muharram', 'Safar', 'Rabi al-Awwal', 'Rabi al-Thani', 'Jumada al-Awwal', 'Jumada al-Thani', 'Rajab', "Sha'ban", 'Ramadan', 'Shawwal', "Dhu al-Qi'dah", 'Dhu al-Hijjah'];
            
            let fetchPromises = upcomingEvents.map(e => {
                let eScore = e.month * 100 + e.day;
                let cScore = cM * 100 + cD;
                let eYear = (eScore < cScore) ? parseInt(hijri.year) + 1 : parseInt(hijri.year);
                let dateStr = `${e.day.toString().padStart(2, '0')}-${e.month.toString().padStart(2, '0')}-${eYear}`;
                return fetch(`https://api.aladhan.com/v1/hToG?date=${dateStr}`).then(res => res.json());
            });

            Promise.all(fetchPromises).then(results => {
                let eventsHtml = '';
                upcomingEvents.forEach((e, i) => {
                    let greg = results[i].data.gregorian;
                    let gregStr = `~ ${greg.month.en} ${greg.day}, ${greg.year}`;
                    
                    if (i === 0) {
                        let eventTime = new Date(greg.year, parseInt(greg.month.number) - 1, parseInt(greg.day)).getTime();
                        $('#countdown-event-name').text(e.name);
                        $('#event-countdown-container').removeClass('hidden');
                        
                        setInterval(function() {
                            let now = new Date().getTime();
                            let distance = eventTime - now;
                            
                            if (distance < 0) {
                                $('#countdown-timer').html('<div class="text-gold font-bold text-sm tracking-widest uppercase w-full text-center py-2">Event is Today!</div>');
                                return;
                            }
                            
                            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            
                            $('#countdown-timer').html(`
                                <div class="text-center flex-1 bg-navy/40 rounded-xl py-2 border border-white/5">
                                    <div class="text-3xl font-serif font-bold text-white mb-1">${days}</div>
                                    <div class="text-[9px] text-gray-400 uppercase tracking-widest">Days</div>
                                </div>
                                <div class="text-center flex-1 bg-navy/40 rounded-xl py-2 border border-white/5">
                                    <div class="text-3xl font-serif font-bold text-white mb-1">${hours}</div>
                                    <div class="text-[9px] text-gray-400 uppercase tracking-widest">Hrs</div>
                                </div>
                                <div class="text-center flex-1 bg-navy/40 rounded-xl py-2 border border-white/5">
                                    <div class="text-3xl font-serif font-bold text-white mb-1">${minutes}</div>
                                    <div class="text-[9px] text-gray-400 uppercase tracking-widest">Mins</div>
                                </div>
                                <div class="text-center flex-1 bg-navy/40 rounded-xl py-2 border border-white/5 relative overflow-hidden">
                                    <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gold/10 blur-md pointer-events-none"></div>
                                    <div class="text-3xl font-serif font-bold text-gold mb-1 relative z-10">${seconds}</div>
                                    <div class="text-[9px] text-gold/70 uppercase tracking-widest relative z-10">Secs</div>
                                </div>
                            `);
                        }, 1000);
                    }
                    
                    let badge = i === 0 ? `<p class="text-[10px] font-bold text-navy bg-gold px-2 py-0.5 rounded uppercase tracking-wider">Next</p>` : '';
                    eventsHtml += `
                        <li class="flex items-center border-b border-white/5 pb-4 last:border-0 last:pb-0">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-gold mr-4 shrink-0 shadow-sm">
                                <i class="fa-solid ${e.icon} text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-white text-base leading-none">${e.name}</p>
                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-sm text-gray-400 font-medium">${e.day} ${hMonths[e.month]}</p>
                                    <div class="flex items-center gap-2">
                                        <p class="text-[10px] font-bold text-gray-400 bg-white/5 px-2 py-0.5 rounded tracking-wider">${gregStr}</p>
                                        ${badge}
                                    </div>
                                </div>
                            </div>
                        </li>
                    `;
                });
                $('#important-dates-list').html(eventsHtml);
            }).catch(err => {
                let eventsHtml = '';
                upcomingEvents.forEach((e, i) => {
                    let badge = i === 0 ? `<p class="text-[10px] font-bold text-navy bg-gold px-2 py-0.5 rounded uppercase tracking-wider">Next</p>` : '';
                    eventsHtml += `
                        <li class="flex items-center border-b border-white/5 pb-4 last:border-0 last:pb-0">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-gold mr-4 shrink-0 shadow-sm">
                                <i class="fa-solid ${e.icon} text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-white text-base leading-none">${e.name}</p>
                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-sm text-gray-400 font-medium">${e.day} ${hMonths[e.month]}</p>
                                    ${badge}
                                </div>
                            </div>
                        </li>
                    `;
                });
                $('#important-dates-list').html(eventsHtml);
            });
            
            // Render Prayers
            let prayers = ['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
            const prayerIcons = {
                'Fajr': 'fa-cloud-sun',
                'Sunrise': 'fa-sun',
                'Dhuhr': 'fa-sun',
                'Asr': 'fa-cloud-sun',
                'Maghrib': 'fa-cloud-moon',
                'Isha': 'fa-moon'
            };
            
            let now = new Date();
            let currentHours = now.getHours().toString().padStart(2, '0');
            let currentMinutes = now.getMinutes().toString().padStart(2, '0');
            let currentTimeStr = `${currentHours}:${currentMinutes}`;
            
            let currentPrayerIdx = -1;
            
            for (let i = 0; i < prayers.length; i++) {
                let prayerTimeStr = timings[prayers[i]].substring(0, 5);
                if (currentTimeStr >= prayerTimeStr) {
                    currentPrayerIdx = i;
                } else {
                    break;
                }
            }
            if (currentPrayerIdx === -1) currentPrayerIdx = prayers.length - 1;
            
            let nextPrayerIdx = (currentPrayerIdx + 1) % prayers.length;
            $('#next-prayer-badge').text(`Next: ${prayers[nextPrayerIdx]}`);
            
            let html = '';
            prayers.forEach((prayer, index) => {
                let isCurrent = index === currentPrayerIdx;
                let bgClass = isCurrent ? 'bg-navy/5 border-accent shadow-md transform scale-[1.02]' : 'bg-gray-50 border-gray-100 hover:border-navy/20';
                let iconClass = isCurrent ? 'text-accent' : 'text-gray-400';
                let titleClass = isCurrent ? 'text-navy font-extrabold' : 'text-gray-700 font-bold';
                let timeClass = isCurrent ? 'text-accent font-bold' : 'text-gray-500 font-medium';
                
                html += `
                    <div class="flex items-center justify-between p-4 rounded-xl border transition-all ${bgClass}">
                        <div class="flex items-center">
                            <div class="w-8 flex items-center justify-center">
                                <i class="fa-solid ${prayerIcons[prayer]} text-lg ${iconClass}"></i>
                            </div>
                            <span class="text-lg ml-2 ${titleClass}">${prayer}</span>
                        </div>
                        <div class="text-xl ${timeClass}">${timings[prayer].substring(0, 5)}</div>
                    </div>
                `;
            });
            
            $('#prayer-times-container').html(html);
            
            // Calculate Next Prayer Countdown & Sun Position
            setInterval(function() {
                let now = new Date();
                let currentTotalMinutes = now.getHours() * 60 + now.getMinutes() + now.getSeconds() / 60;
                
                // Countdown logic
                let nextPrayerName = prayers[nextPrayerIdx];
                let nextTimeParts = timings[nextPrayerName].substring(0,5).split(':');
                let nextTotalMinutes = parseInt(nextTimeParts[0]) * 60 + parseInt(nextTimeParts[1]);
                
                if (nextTotalMinutes < currentTotalMinutes) {
                    nextTotalMinutes += 24 * 60; // Next day
                }
                
                let diffSeconds = Math.floor((nextTotalMinutes - currentTotalMinutes) * 60);
                if(diffSeconds <= 0) {
                    location.reload(); 
                }
                
                let h = Math.floor(diffSeconds / 3600).toString().padStart(2, '0');
                let m = Math.floor((diffSeconds % 3600) / 60).toString().padStart(2, '0');
                let s = Math.floor(diffSeconds % 60).toString().padStart(2, '0');
                
                $('#next-prayer-countdown').text(`${h}:${m}:${s}`);
                
                // Sun/Moon Graphic Logic
                let fajrParts = timings['Fajr'].substring(0,5).split(':');
                let maghribParts = timings['Maghrib'].substring(0,5).split(':');
                
                let fajrMins = parseInt(fajrParts[0]) * 60 + parseInt(fajrParts[1]);
                let maghribMins = parseInt(maghribParts[0]) * 60 + parseInt(maghribParts[1]);
                
                let isDay = (currentTotalMinutes >= fajrMins && currentTotalMinutes <= maghribMins);
                
                let p = 0;
                if(isDay) {
                    p = (currentTotalMinutes - fajrMins) / (maghribMins - fajrMins);
                    $('#sun-start-label').text('Fajr');
                    $('#sun-end-label').text('Maghrib');
                    $('#celestial-icon').removeClass('fa-moon text-blue-400').addClass('fa-sun text-gold');
                    $('#celestial-bg').removeClass('border-blue-400 shadow-[0_0_15px_rgba(96,165,250,0.6)]').addClass('border-gold shadow-[0_0_15px_rgba(248,188,44,0.6)]');
                    $('#sun-arc-path').attr('stroke', '#f8bc2c');
                } else {
                    let nightStart = maghribMins;
                    let nightEnd = fajrMins + 24 * 60;
                    let cTime = currentTotalMinutes < fajrMins ? currentTotalMinutes + 24 * 60 : currentTotalMinutes;
                    p = (cTime - nightStart) / (nightEnd - nightStart);
                    
                    $('#sun-start-label').text('Maghrib');
                    $('#sun-end-label').text('Fajr');
                    $('#celestial-icon').removeClass('fa-sun text-gold').addClass('fa-moon text-blue-400');
                    $('#celestial-bg').removeClass('border-gold shadow-[0_0_15px_rgba(248,188,44,0.6)]').addClass('border-blue-400 shadow-[0_0_15px_rgba(96,165,250,0.6)]');
                    $('#sun-arc-path').attr('stroke', '#60a5fa');
                }
                
                p = Math.max(0, Math.min(1, p));
                
                let r = 90;
                let cx = 100;
                let cy = 100;
                let angle = Math.PI - (p * Math.PI);
                let x = cx + r * Math.cos(angle) - 20; 
                let y = cy - r * Math.sin(angle) - 20;
                
                $('#live-sun-fo').attr('x', x).attr('y', y);
                $('#sun-arc-path').css('stroke-dashoffset', 283 * (1 - p));
                
            }, 1000);
        }
    });

    // Fetch Verse of the Day
    const curatedAyahs = [255, 1, 2, 3, 286, 3133, 4395, 5070, 5972, 6234, 110, 153, 186, 6088]; 
    const randomAyahNumber = curatedAyahs[dayOfYear % curatedAyahs.length] || ((dayOfYear % 6236) + 1);
    $.get(`https://api.alquran.cloud/v1/ayah/${randomAyahNumber}/editions/quran-uthmani,en.asad`, function(response) {
        if(response.code === 200) {
            let ar = response.data[0];
            let en = response.data[1];
            $('#quran-container').removeClass('animate-pulse').html(`
                <p class="text-2xl font-arabic text-right text-navy leading-loose mb-6" dir="rtl">${ar.text}</p>
                <p class="text-gray-600 font-light italic leading-relaxed mb-4">"${en.text}"</p>
                <p class="text-sm font-bold text-accent">— Surah ${en.surah.englishName}, Ayah ${en.numberInSurah}</p>
            `);
        }
    });

    // Populate Hadith of the Day
    const hadiths = [
        "The believer's shade on the Day of Resurrection will be his charity. (Tirmidhi)",
        "None of you truly believes until he loves for his brother what he loves for himself. (Bukhari & Muslim)",
        "He who is not merciful to others, will not be treated mercifully. (Bukhari)",
        "The best among you are those who have the best manners and character. (Bukhari)",
        "God does not look at your forms and possessions but he looks at your hearts and your deeds. (Muslim)",
        "A good word is charity. (Bukhari & Muslim)",
        "Make things easy for people and do not make them difficult, and cheer people up and do not drive them away. (Bukhari)",
        "The most complete of the believers in faith, is the one with the best character. (Tirmidhi)",
        "When a person dies, his deeds come to an end except for three: Sadaqah Jariyah (a continuous charity), or knowledge from which benefit is gained, or a righteous child who prays for him. (Muslim)"
    ];
    const selectedHadith = hadiths[dayOfYear % hadiths.length];
    const [hText, hSource] = selectedHadith.split(' (');
    $('#hadith-container').html(`
        <p class="text-xl font-serif text-navy leading-relaxed mb-6 italic">"${hText}"</p>
        <p class="text-sm font-bold text-gold">— ${hSource.replace(')', '')}</p>
    `);
});
</script>

<?php include 'includes/footer.php'; ?>
