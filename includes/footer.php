</main>
<!-- End Main Container -->

<?php
$counter_file = __DIR__ . '/../visitors.txt';
if(!file_exists($counter_file)) {
    file_put_contents($counter_file, "0");
}
if (!isset($_SESSION['has_visited'])) {
    $count = (int)file_get_contents($counter_file);
    $count++;
    file_put_contents($counter_file, $count);
    $_SESSION['has_visited'] = true;
} else {
    $count = (int)file_get_contents($counter_file);
}

// Fetch Top 5 Leaderboard
$leaderboard = [];
try {
    if (isset($pdo)) {
        $stmt = $pdo->query("SELECT u.first_name, u.last_name, q.score FROM quiz_scores q JOIN users u ON q.user_id = u.id ORDER BY q.score DESC LIMIT 5");
        $leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {}
?>

<footer class="bg-navy text-gray-300 py-12 border-t border-accent/20 mt-12 relative overflow-hidden">
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-accent/5 rounded-full blur-3xl"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <?php if(!empty($site_logo)): ?>
                        <img src="<?php echo $base_url; ?>/assets/img/uploads/<?php echo htmlspecialchars($site_logo); ?>" alt="LASUMUC Logo" class="h-12 object-contain">
                    <?php else: ?>
                        <div class="w-10 h-10 rounded-full border border-accent/30 flex items-center justify-center bg-white/5">
                            <i class="fa-solid fa-mosque text-xl text-accent"></i>
                        </div>
                    <?php endif; ?>
                    <span class="font-serif font-bold text-2xl text-white tracking-wider">LASUMUC</span>
                </div>
                <p class="text-sm">
                    Lagos State University Muslim Community. Providing spiritual, social, and academic support to Muslims on campus.
                </p>
            </div>
            <div>
                <h3 class="text-lg font-serif font-semibold text-white mb-6 border-b border-accent/20 pb-2 inline-block">Quick Links</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="<?php echo $base_url; ?>/index.php" class="hover:text-accent transition duration-300 flex items-center"><i class="fa-solid fa-chevron-right text-xs mr-2 text-accent/50"></i> Home</a></li>
                    <li><a href="<?php echo $base_url; ?>/about.php" class="hover:text-accent transition duration-300 flex items-center"><i class="fa-solid fa-chevron-right text-xs mr-2 text-accent/50"></i> About Us</a></li>
                    <li><a href="<?php echo $base_url; ?>/news.php" class="hover:text-accent transition duration-300 flex items-center"><i class="fa-solid fa-chevron-right text-xs mr-2 text-accent/50"></i> News</a></li>
                    <li><a href="<?php echo $base_url; ?>/marketplace.php" class="hover:text-accent transition duration-300 flex items-center"><i class="fa-solid fa-chevron-right text-xs mr-2 text-accent/50"></i> Marketplace</a></li>
                    <li><a href="<?php echo $base_url; ?>/quran.php" class="hover:text-accent transition duration-300 flex items-center"><i class="fa-solid fa-chevron-right text-xs mr-2 text-accent/50"></i> Al-Quran</a></li>
                    <li><a href="<?php echo $base_url; ?>/calendar.php" class="hover:text-accent transition duration-300 flex items-center"><i class="fa-solid fa-chevron-right text-xs mr-2 text-accent/50"></i> Hijri Calendar</a></li>
                    <li><a href="<?php echo $base_url; ?>/contact.php" class="hover:text-accent transition duration-300 flex items-center"><i class="fa-solid fa-chevron-right text-xs mr-2 text-accent/50"></i> Contact Us</a></li>
                    <li><a href="<?php echo $base_url; ?>/donate.php" class="hover:text-accent transition duration-300 text-accent font-semibold flex items-center"><i class="fa-solid fa-chevron-right text-xs mr-2 text-accent/50"></i> Donate</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-serif font-semibold text-white mb-6 border-b border-accent/20 pb-2 inline-block">Connect</h3>
                <div class="flex space-x-4 mb-8">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-navy hover:bg-accent hover:border-accent transition duration-300"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-navy hover:bg-accent hover:border-accent transition duration-300"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-navy hover:bg-accent hover:border-accent transition duration-300"><i class="fa-brands fa-instagram"></i></a>
                </div>
                
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Quiz Leaderboard</h3>
                <ul class="space-y-3">
                    <?php if(!empty($leaderboard)): ?>
                        <?php foreach($leaderboard as $index => $player): ?>
                            <li class="flex items-center justify-between text-sm bg-white/5 border border-white/10 rounded-lg px-3 py-2 shadow-sm hover:border-accent/30 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-full bg-navy border border-accent/30 text-accent flex items-center justify-center text-xs font-bold shadow-[0_0_10px_rgba(5,150,105,0.2)]">
                                        <?php echo $index + 1; ?>
                                    </div>
                                    <span class="text-gray-300 font-medium"><?php echo htmlspecialchars($player['first_name'] . ' ' . substr($player['last_name'], 0, 1) . '.'); ?></span>
                                </div>
                                <span class="text-gold font-bold tracking-wide"><?php echo $player['score']; ?> pts</span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="text-xs text-gray-500 italic bg-white/5 rounded-lg p-3 text-center border border-white/5">No scores yet. Be the first!</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="mt-12 pt-8 border-t border-white/10 flex flex-col lg:flex-row items-center justify-between gap-6 text-sm text-gray-400">
            <p>&copy; <?php echo date('Y'); ?> Lagos State University Muslim Community. All rights reserved.</p>
            
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <!-- Visitor Counter -->
                <div class="flex items-center gap-2 bg-white/5 border border-white/10 px-4 py-2 rounded-full shadow-inner" title="Total Website Visits">
                    <i class="fa-solid fa-users text-accent"></i>
                    <span class="font-bold text-white tracking-wider text-base"><?php echo number_format($count); ?></span>
                    <span class="text-xs uppercase tracking-widest text-gray-500">Visits</span>
                </div>
                
                <!-- Developer Credit -->
                <div class="bg-gradient-to-r from-accent/50 to-transparent p-[1px] rounded-full">
                    <div class="bg-navy px-5 py-2 rounded-full border border-accent/30 shadow-[0_0_20px_rgba(5,150,105,0.3)] hover:shadow-[0_0_30px_rgba(5,150,105,0.6)] transition-all duration-300 flex items-center gap-2">
                        <i class="fa-solid fa-code text-gold/70 text-xs"></i>
                        <span class="text-gray-300 font-medium tracking-wide">Developed by</span> 
                        <a href="https://axript.com.ng" target="_blank" class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-accent to-gold hover:from-gold hover:to-accent transition-all duration-300 ml-1 text-base tracking-wide">Axript Tech</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 for nice alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Paystack -->
<script src="https://js.paystack.co/v1/inline.js"></script>

<!-- Custom Scripts -->
<script>var BASE_URL = '<?php echo $base_url; ?>';</script>
<script src="<?php echo $base_url; ?>/assets/js/main.js"></script>
<?php if(basename($_SERVER['PHP_SELF']) == 'quran.php'): ?>
<script src="<?php echo $base_url; ?>/assets/js/quran.js"></script>
<?php endif; ?>
<?php 
$quiz_files = ['alphabet.php', 'word4word.php', 'surahs.php', 'ayahbysurah.php'];
if(in_array(basename($_SERVER['PHP_SELF']), $quiz_files)): 
?>
<script src="<?php echo $base_url; ?>/assets/js/quiz-utils.js"></script>
<?php endif; ?>

</body>
</html>
