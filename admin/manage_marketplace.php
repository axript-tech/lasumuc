<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
require_once '../includes/db.php';

$success = '';
$error = '';

// Handle Actions (Add, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;
        $seller_name = $_POST['seller_name'] ?? '';
        $seller_contact = $_POST['seller_contact'] ?? '';
        $category = $_POST['category'] ?? '';
        $image_url = $_POST['image_url'] ?? '';

        // Handle Image Upload if provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $new_file_name = 'product_' . time() . '.' . $ext;
                $upload_dir = '../assets/img/uploads/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                if(move_uploaded_file($tmp_name, $upload_dir . $new_file_name)) {
                    // Update image_url to relative path for frontend
                    $image_url = 'assets/img/uploads/' . $new_file_name;
                }
            } else {
                $error = "Invalid image format. Only JPG, PNG, and WebP are allowed.";
            }
        }

        if (empty($error)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url, seller_name, seller_contact, category) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $description, $price, $image_url, $seller_name, $seller_contact, $category]);
                $success = "Product added successfully.";
            } catch (PDOException $e) {
                $error = "Database Error: " . $e->getMessage();
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = $_POST['product_id'];
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;
        $seller_name = $_POST['seller_name'] ?? '';
        $seller_contact = $_POST['seller_contact'] ?? '';
        $category = $_POST['category'] ?? '';
        $image_url = $_POST['image_url'] ?? '';

        // Handle Image Upload if provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $new_file_name = 'product_' . time() . '.' . $ext;
                $upload_dir = '../assets/img/uploads/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                if(move_uploaded_file($tmp_name, $upload_dir . $new_file_name)) {
                    $image_url = 'assets/img/uploads/' . $new_file_name;
                }
            } else {
                $error = "Invalid image format. Only JPG, PNG, and WebP are allowed.";
            }
        }

        if (empty($error)) {
            try {
                if (!empty($image_url)) {
                    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_url = ?, seller_name = ?, seller_contact = ?, category = ? WHERE id = ?");
                    $stmt->execute([$name, $description, $price, $image_url, $seller_name, $seller_contact, $category, $id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, seller_name = ?, seller_contact = ?, category = ? WHERE id = ?");
                    $stmt->execute([$name, $description, $price, $seller_name, $seller_contact, $category, $id]);
                }
                $success = "Product updated successfully.";
            } catch (PDOException $e) {
                $error = "Database Error: " . $e->getMessage();
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['product_id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $success = "Product deleted successfully.";
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}

// Fetch Products
$products = [];
try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching products: " . $e->getMessage();
}

include 'includes/admin_header.php';
?>

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-serif font-bold text-navy">Manage Marketplace</h1>
        <p class="text-gray-500 mt-1">Add, view, and delete products from the public marketplace.</p>
    </div>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-accent hover:bg-forest text-white px-5 py-2.5 rounded-xl font-bold transition shadow-md flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Add Product
    </button>
</div>

<?php if($success): ?>
    <div class="mb-6 bg-emerald-50 border-l-4 border-accent p-4 rounded-r-lg flex items-start gap-3">
        <i class="fa-solid fa-check-circle text-accent mt-0.5"></i>
        <div>
            <h3 class="font-bold text-accent">Success</h3>
            <p class="text-emerald-800 text-sm"><?php echo htmlspecialchars($success); ?></p>
        </div>
    </div>
<?php endif; ?>

<?php if($error): ?>
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-start gap-3">
        <i class="fa-solid fa-exclamation-circle text-red-500 mt-0.5"></i>
        <div>
            <h3 class="font-bold text-red-700">Error</h3>
            <p class="text-red-600 text-sm"><?php echo htmlspecialchars($error); ?></p>
        </div>
    </div>
<?php endif; ?>

<div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold border-b border-gray-200">Product</th>
                    <th class="px-6 py-4 font-semibold border-b border-gray-200">Price</th>
                    <th class="px-6 py-4 font-semibold border-b border-gray-200">Category</th>
                    <th class="px-6 py-4 font-semibold border-b border-gray-200">Seller</th>
                    <th class="px-6 py-4 font-semibold border-b border-gray-200 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php if(empty($products)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No products found in the marketplace.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($products as $p): ?>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0 border border-gray-200">
                                        <?php if($p['image_url']): ?>
                                            <?php 
                                            // Handle relative paths from DB vs absolute URLs
                                            $imgSrc = strpos($p['image_url'], 'http') === 0 ? $p['image_url'] : $base_url . '/' . $p['image_url']; 
                                            ?>
                                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fa-solid fa-box"></i></div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="font-bold text-navy"><?php echo htmlspecialchars($p['name']); ?></div>
                                        <div class="text-xs text-gray-500 truncate max-w-[200px]"><?php echo htmlspecialchars($p['description']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-navy">
                                ₦<?php echo number_format($p['price']); ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold"><?php echo htmlspecialchars($p['category']); ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-navy font-medium"><?php echo htmlspecialchars($p['seller_name']); ?></div>
                                <div class="text-xs text-gray-500"><?php echo htmlspecialchars($p['seller_contact']); ?></div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button onclick='openEditModal(<?php echo json_encode($p); ?>)' class="text-blue-500 hover:text-blue-700 hover:bg-blue-50 p-2 rounded-lg transition mr-1" title="Edit">
                                    <i class="fa-solid fa-edit"></i>
                                </button>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                                    <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition" title="Delete">
                                        <i class="fa-solid fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-navy/60 backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('addModal').classList.add('hidden')"></div>

        <div class="relative inline-block w-full max-w-2xl text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl overflow-hidden my-8">
            <div class="bg-navy px-6 py-4 border-b border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white font-serif">Add New Product</h3>
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="text-gray-400 hover:text-white transition">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            
            <form action="" method="POST" enctype="multipart/form-data" class="px-6 py-6 space-y-5">
                <input type="hidden" name="action" value="add">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Price (₦) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" step="0.01" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="3" class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Category <span class="text-red-500">*</span></label>
                        <input type="text" name="category" placeholder="e.g. Books, Clothing" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Product Image (File or URL)</label>
                        <div class="space-y-2">
                            <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-accent hover:file:bg-emerald-100 transition">
                            <p class="text-xs text-gray-400 text-center">- OR -</p>
                            <input type="url" name="image_url" placeholder="https://..." class="block w-full px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                        </div>
                    </div>
                </div>
                
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl mt-4">
                    <h4 class="text-sm font-bold text-navy mb-3 border-b border-gray-200 pb-2">Seller Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Seller Name <span class="text-red-500">*</span></label>
                            <input type="text" name="seller_name" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">WhatsApp Number <span class="text-red-500">*</span></label>
                            <input type="text" name="seller_contact" placeholder="e.g. 2348000000000" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-white transition">
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 mt-6">
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-accent hover:bg-forest text-white font-bold rounded-xl shadow-md transition">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-navy/60 backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('editModal').classList.add('hidden')"></div>

        <div class="relative inline-block w-full max-w-2xl text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl overflow-hidden my-8">
            <div class="bg-navy px-6 py-4 border-b border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white font-serif">Edit Product</h3>
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="text-gray-400 hover:text-white transition">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>
            
            <form action="" method="POST" enctype="multipart/form-data" class="px-6 py-6 space-y-5">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="product_id" id="edit_product_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="edit_name" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Price (₦) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" id="edit_price" step="0.01" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" id="edit_description" rows="3" class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Category <span class="text-red-500">*</span></label>
                        <input type="text" name="category" id="edit_category" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Update Image (Leave blank to keep current)</label>
                        <div class="space-y-2">
                            <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-accent hover:file:bg-emerald-100 transition">
                            <p class="text-xs text-gray-400 text-center">- OR -</p>
                            <input type="url" name="image_url" placeholder="https://..." class="block w-full px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                        </div>
                    </div>
                </div>
                
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl mt-4">
                    <h4 class="text-sm font-bold text-navy mb-3 border-b border-gray-200 pb-2">Seller Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Seller Name <span class="text-red-500">*</span></label>
                            <input type="text" name="seller_name" id="edit_seller_name" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-white transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">WhatsApp Number <span class="text-red-500">*</span></label>
                            <input type="text" name="seller_contact" id="edit_seller_contact" required class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-white transition">
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 mt-6">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl shadow-md transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(product) {
    document.getElementById('edit_product_id').value = product.id;
    document.getElementById('edit_name').value = product.name;
    document.getElementById('edit_price').value = product.price;
    document.getElementById('edit_description').value = product.description;
    document.getElementById('edit_category').value = product.category;
    document.getElementById('edit_seller_name').value = product.seller_name;
    document.getElementById('edit_seller_contact').value = product.seller_contact;
    
    document.getElementById('editModal').classList.remove('hidden');
}
</script>

<?php include 'includes/admin_footer.php'; ?>
