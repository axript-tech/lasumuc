<?php
require_once 'includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    header("Location: news.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) {
    header("Location: news.php");
    exit;
}

include 'includes/header.php';
?>

<div class="bg-slate-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="news.php" class="inline-flex items-center text-accent font-bold tracking-wider text-xs uppercase hover:text-navy mb-10 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to News
        </a>
        
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <?php if($news['image']): ?>
                <div class="h-80 w-full relative">
                    <img src="<?php echo $base_url; ?>/assets/img/uploads/<?php echo htmlspecialchars($news['image']); ?>" alt="News Cover" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent"></div>
                </div>
            <?php else: ?>
                <div class="h-40 w-full bg-navy relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23d4af37\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>
            <?php endif; ?>

            <div class="p-10 md:p-16 relative <?php echo $news['image'] ? '-mt-24' : ''; ?> z-10">
                <div class="bg-white rounded-2xl <?php echo $news['image'] ? 'p-8 shadow-lg border border-gray-100 mb-10' : ''; ?>">
                    <div class="text-accent text-sm font-bold tracking-widest uppercase mb-4 flex items-center">
                        <i class="fa-regular fa-calendar mr-2"></i> <?php echo date('F d, Y', strtotime($news['created_at'])); ?>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-serif font-extrabold text-navy leading-tight"><?php echo htmlspecialchars($news['title']); ?></h1>
                </div>

                <div class="prose prose-lg prose-slate max-w-none font-light leading-relaxed text-gray-600">
                    <?php echo nl2br(htmlspecialchars($news['content'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
