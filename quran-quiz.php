<?php
include 'includes/header.php';
require_once 'includes/db.php';

// Fetch leaderboard
try {
    $stmt = $pdo->query("SELECT u.first_name, u.last_name, qs.score 
                         FROM quiz_scores qs 
                         JOIN users u ON qs.user_id = u.id 
                         ORDER BY qs.score DESC LIMIT 10");
    $leaderboard = $stmt->fetchAll();
} catch (PDOException $e) {
    $leaderboard = [];
}
?>

<!-- Premium Hero Section for Quran Quiz -->
<div class="relative py-24 bg-navy overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-96 h-96 bg-accent opacity-10 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gold opacity-10 rounded-full blur-3xl transform -translate-x-1/3 translate-y-1/3"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent/20 border border-accent/30 text-accent mb-8 shadow-[0_0_30px_rgba(5,150,105,0.3)]">
            <i class="fa-solid fa-clipboard-question text-4xl"></i>
        </div>
        <h1 class="text-4xl md:text-6xl font-serif font-extrabold text-white mb-6 tracking-tight">Quran Quiz</h1>
        <p class="text-xl text-gray-300 font-light max-w-2xl mx-auto leading-relaxed">
            Test your knowledge of the Holy Quran. Select a difficulty level below to begin your challenge.
        </p>
    </div>
</div>

<!-- Main Content Area -->
<div class="py-20 bg-gray-50 border-t border-gray-100 min-h-[50vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-12 text-center">
            <h2 class="text-sm text-gold font-bold tracking-widest uppercase mb-2">Select Quiz Type</h2>
            <p class="text-3xl font-serif font-extrabold text-navy">Choose Your Challenge</p>
            <div class="w-16 h-1 bg-gradient-to-r from-transparent via-accent to-transparent mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Alphabets -->
            <a href="alphabet.php" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 text-center hover:border-accent/40 hover:shadow-[0_15px_40px_rgba(5,150,105,0.15)] hover:-translate-y-2 transition duration-500 group block relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-accent opacity-5 rounded-bl-full group-hover:scale-125 transition duration-700"></div>
                
                <div class="w-20 h-20 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-6 border border-gray-100 group-hover:bg-accent/10 transition relative shadow-sm">
                    <i class="fa-solid fa-language text-3xl text-gray-400 group-hover:text-accent transition"></i>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-accent text-white rounded-full flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">A</div>
                </div>
                
                <h3 class="text-xl font-bold text-navy mb-4 group-hover:text-accent transition">Alphabets</h3>
                
                <div class="flex justify-center items-center gap-2 mb-6">
                    <span class="px-3 py-1 bg-emerald-50 border border-emerald-100 text-emerald-600 text-[10px] font-bold rounded-full uppercase tracking-widest">Very Easy</span>
                </div>
                
                <div class="flex justify-center gap-1">
                    <i class="fa-solid fa-star text-gold text-sm"></i>
                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                </div>
            </a>

            <!-- Word For Word -->
            <a href="word4word.php" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 text-center hover:border-accent/40 hover:shadow-[0_15px_40px_rgba(5,150,105,0.15)] hover:-translate-y-2 transition duration-500 group block relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-accent opacity-5 rounded-bl-full group-hover:scale-125 transition duration-700"></div>
                
                <div class="w-20 h-20 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-6 border border-gray-100 group-hover:bg-accent/10 transition relative shadow-sm">
                    <i class="fa-solid fa-quote-left text-3xl text-gray-400 group-hover:text-accent transition"></i>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-accent text-white rounded-full flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">B</div>
                </div>
                
                <h3 class="text-xl font-bold text-navy mb-4 group-hover:text-accent transition">Word For Word</h3>
                
                <div class="flex justify-center items-center gap-2 mb-6">
                    <span class="px-3 py-1 bg-green-50 border border-green-100 text-green-600 text-[10px] font-bold rounded-full uppercase tracking-widest">Easy</span>
                </div>
                
                <div class="flex justify-center gap-1">
                    <i class="fa-solid fa-star text-gold text-sm"></i>
                    <i class="fa-solid fa-star text-gold text-sm"></i>
                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                </div>
            </a>

            <!-- Verse By Verse -->
            <a href="surahs.php" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 text-center hover:border-accent/40 hover:shadow-[0_15px_40px_rgba(5,150,105,0.15)] hover:-translate-y-2 transition duration-500 group block relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-accent opacity-5 rounded-bl-full group-hover:scale-125 transition duration-700"></div>
                
                <div class="w-20 h-20 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-6 border border-gray-100 group-hover:bg-accent/10 transition relative shadow-sm">
                    <i class="fa-solid fa-book-open text-3xl text-gray-400 group-hover:text-accent transition"></i>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-accent text-white rounded-full flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">C</div>
                </div>
                
                <h3 class="text-xl font-bold text-navy mb-4 group-hover:text-accent transition">Verse By Verse</h3>
                
                <div class="flex justify-center items-center gap-2 mb-6">
                    <span class="px-3 py-1 bg-yellow-50 border border-yellow-100 text-yellow-600 text-[10px] font-bold rounded-full uppercase tracking-widest">Normal</span>
                </div>
                
                <div class="flex justify-center gap-1">
                    <i class="fa-solid fa-star text-gold text-sm"></i>
                    <i class="fa-solid fa-star text-gold text-sm"></i>
                    <i class="fa-solid fa-star text-gold text-sm"></i>
                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                </div>
            </a>

            <!-- Ayah in Surah -->
            <a href="ayahbysurah.php" class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 text-center hover:border-accent/40 hover:shadow-[0_15px_40px_rgba(5,150,105,0.15)] hover:-translate-y-2 transition duration-500 group block relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-accent opacity-5 rounded-bl-full group-hover:scale-125 transition duration-700"></div>
                
                <div class="w-20 h-20 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-6 border border-gray-100 group-hover:bg-accent/10 transition relative shadow-sm">
                    <i class="fa-solid fa-layer-group text-3xl text-gray-400 group-hover:text-accent transition"></i>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-accent text-white rounded-full flex items-center justify-center font-bold text-sm border-2 border-white shadow-sm">D</div>
                </div>
                
                <h3 class="text-xl font-bold text-navy mb-4 group-hover:text-accent transition">Ayah in Surah</h3>
                
                <div class="flex justify-center items-center gap-2 mb-6">
                    <span class="px-3 py-1 bg-red-50 border border-red-100 text-red-600 text-[10px] font-bold rounded-full uppercase tracking-widest">Hard</span>
                </div>
                
                <div class="flex justify-center gap-1">
                    <i class="fa-solid fa-star text-gold text-sm"></i>
                    <i class="fa-solid fa-star text-gold text-sm"></i>
                    <i class="fa-solid fa-star text-gold text-sm"></i>
                    <i class="fa-solid fa-star text-gold text-sm"></i>
                    <i class="fa-regular fa-star text-gray-300 text-sm"></i>
                </div>
            </a>
        </div>
        
        <!-- Global Leaderboard Section -->
        <div class="mt-24 max-w-4xl mx-auto">
            <div class="mb-10 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gold/10 text-gold mb-4">
                    <i class="fa-solid fa-trophy text-2xl"></i>
                </div>
                <h2 class="text-3xl font-serif font-bold text-navy">Global Leaderboard</h2>
                <p class="text-gray-500 mt-2">Top 10 players based on total score</p>
            </div>
            
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <?php if (empty($leaderboard)): ?>
                    <div class="p-10 text-center text-gray-400">
                        <i class="fa-solid fa-ranking-star text-4xl mb-4 opacity-50"></i>
                        <p>No scores recorded yet. Be the first to play!</p>
                    </div>
                <?php else: ?>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="py-4 px-6 font-bold text-sm text-gray-400 uppercase tracking-wider w-20 text-center">Rank</th>
                                <th class="py-4 px-6 font-bold text-sm text-gray-400 uppercase tracking-wider">Player</th>
                                <th class="py-4 px-6 font-bold text-sm text-gray-400 uppercase tracking-wider text-right">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaderboard as $index => $player): ?>
                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                    <td class="py-4 px-6 text-center">
                                        <?php if ($index === 0): ?>
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full font-bold text-sm"><i class="fa-solid fa-crown"></i></span>
                                        <?php elseif ($index === 1): ?>
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-200 text-gray-600 rounded-full font-bold text-sm">2</span>
                                        <?php elseif ($index === 2): ?>
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-orange-100 text-orange-600 rounded-full font-bold text-sm">3</span>
                                        <?php else: ?>
                                            <span class="text-gray-400 font-bold"><?= $index + 1 ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-navy"><?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?></div>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <span class="font-bold text-accent"><?= number_format($player['score']) ?> pts</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
            
            <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="mt-8 text-center bg-blue-50 border border-blue-100 rounded-2xl p-6">
                <i class="fa-solid fa-circle-info text-blue-500 text-xl mb-2"></i>
                <p class="text-blue-800 font-medium mb-3">You must be logged in to save your score to the leaderboard!</p>
                <a href="login.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-blue-700 transition">Log In Now</a>
            </div>
            <?php endif; ?>
        </div>
        
    </div>
</div>

<?php include 'includes/footer.php'; ?>
