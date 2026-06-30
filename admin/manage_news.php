<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = '';

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name = basename($_FILES['image']['name']);
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $image = 'news_' . time() . '.' . $ext;
                $upload_dir = '../assets/img/uploads/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                move_uploaded_file($tmp_name, $upload_dir . $image);
            }
        }

        $stmt = $pdo->prepare("INSERT INTO news (title, content, image) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, $image]);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: manage_news.php");
    exit;
}

include 'includes/admin_header.php';
$news_items = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
?>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    
    <!-- Left Column: Create Form -->
    <div class="xl:col-span-1">
        <div class="bg-white p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-colors duration-500"></div>
            <h2 class="text-2xl font-serif font-bold text-navy mb-6 border-b border-gray-100 pb-4 relative z-10">Publish News Article</h2>
            <form method="POST" action="manage_news.php" enctype="multipart/form-data" class="space-y-5">
                <input type="hidden" name="action" value="create">
                
                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Title</label>
                    <input type="text" name="title" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Content</label>
                    <textarea name="content" required rows="6" class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition resize-none"></textarea>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Cover Image (Optional)</label>
                    <div class="relative">
                        <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-accent/10 file:text-accent hover:file:bg-accent/20 cursor-pointer transition">
                    </div>
                </div>
                
                <div class="pt-2">
                    <button type="submit" class="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-accent hover:bg-forest transition transform hover:-translate-y-0.5 uppercase tracking-wide">
                        Publish Article <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: News List -->
    <div class="xl:col-span-2">
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/80">
                <h3 class="font-bold text-navy text-lg">Published Articles</h3>
                <span class="bg-accent/10 text-accent text-xs font-bold px-3 py-1 rounded-full"><?php echo count($news_items); ?> Total</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Article Details</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Date Published</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        <?php foreach($news_items as $n): ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <?php if(!empty($n['image'])): ?>
                                        <img src="<?php echo $base_url; ?>/assets/img/uploads/<?php echo htmlspecialchars($n['image']); ?>" class="w-12 h-12 rounded-lg object-cover shadow-sm">
                                    <?php else: ?>
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center">
                                            <i class="fa-solid fa-image text-lg"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="text-sm font-bold text-navy mb-1 line-clamp-1"><?php echo htmlspecialchars($n['title']); ?></div>
                                        <div class="text-xs text-gray-400 line-clamp-1"><?php echo htmlspecialchars(strip_tags($n['content'])); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo date('M d, Y h:i A', strtotime($n['created_at'])); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <form method="POST" action="manage_news.php" onsubmit="return confirm('Are you sure you want to delete this article?');" class="inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $n['id']; ?>">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center" title="Delete Article">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($news_items)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400 text-sm">No articles published yet. Use the form to publish your first update.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
