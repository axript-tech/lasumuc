<?php
require_once 'includes/db.php';
include 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM news ORDER BY created_at DESC");
$news_items = $stmt->fetchAll();
?>

<!-- Premium Header -->
<div class="relative bg-navy overflow-hidden py-24 text-center">
    <!-- Abstract pattern overlay -->
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23d4af37\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="absolute top-0 right-0 -mr-40 -mt-40 w-96 h-96 bg-accent rounded-full opacity-20 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="text-5xl font-serif font-extrabold text-white sm:text-6xl tracking-tight mb-6">Latest <span class="text-accent-gradient">News</span></h1>
        <div class="w-24 h-1 bg-accent mx-auto mb-6 rounded-full opacity-70"></div>
        <p class="text-xl text-gray-300 max-w-2xl mx-auto font-light leading-relaxed">Stay updated with the latest announcements, events, and stories from LASUMUC.</p>
    </div>
</div>

<div class="py-24 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <?php if(empty($news_items)): ?>
            <div class="text-center text-gray-500 py-12 font-light">No news articles published yet.</div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php foreach($news_items as $news): ?>
                    <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] overflow-hidden hover-scale border border-gray-100 flex flex-col group">
                        <div class="relative overflow-hidden h-56 bg-navy flex items-center justify-center">
                            <?php if($news['image']): ?>
                                <img src="<?php echo $base_url; ?>/assets/img/uploads/<?php echo htmlspecialchars($news['image']); ?>" alt="News Image" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                            <?php else: ?>
                                <i class="fa-solid fa-newspaper text-6xl text-accent opacity-30"></i>
                            <?php endif; ?>
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-navy text-xs font-bold px-3 py-1 rounded shadow-sm">
                                <?php echo date('M d, Y', strtotime($news['created_at'])); ?>
                            </div>
                        </div>
                        <div class="p-8 flex-grow flex flex-col bg-white">
                            <h2 class="text-2xl font-serif font-bold text-navy mb-4 line-clamp-2 group-hover:text-forest transition"><?php echo htmlspecialchars($news['title']); ?></h2>
                            <p class="text-gray-500 mb-6 line-clamp-3 text-sm flex-grow leading-relaxed font-light">
                                <?php echo htmlspecialchars(strip_tags($news['content'])); ?>
                            </p>
                            <a href="news_detail.php?id=<?php echo $news['id']; ?>" class="inline-flex items-center text-accent font-bold text-sm tracking-wide uppercase hover:text-navy transition">
                                Read Article <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
