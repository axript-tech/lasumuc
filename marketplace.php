<?php
require_once 'includes/db.php';
include 'includes/header.php';

// Fetch products from database
$products = [];
try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Silently handle error, $products remains empty
}

// Group categories for the filter
$categories = [];
if (!empty($products)) {
    foreach ($products as $p) {
        if (!in_array($p['category'], $categories)) {
            $categories[] = $p['category'];
        }
    }
}
?>

<!-- Hero Section -->
<div class="relative bg-navy overflow-hidden py-16 text-center">
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23d4af37\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <h1 class="text-4xl font-serif font-extrabold text-white sm:text-5xl mb-4">Muslim <span class="text-accent-gradient">Marketplace</span></h1>
        <div class="w-16 h-1 bg-accent mx-auto mb-4 rounded-full opacity-70"></div>
        <p class="text-gray-300 font-light text-lg">Support the community. Discover and buy quality halal products directly from Muslim entrepreneurs.</p>
    </div>
</div>

<div class="bg-slate-50 py-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filters & Search Bar -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 bg-white p-6 rounded-2xl shadow-[0_4px_15px_rgb(0,0,0,0.02)] border border-gray-100">
            <div class="flex items-center overflow-x-auto gap-2 pb-2 md:pb-0 w-full md:w-auto hide-scrollbar">
                <button class="filter-btn active whitespace-nowrap px-5 py-2 rounded-full text-sm font-bold transition duration-300 bg-accent text-white shadow-md border border-accent" data-filter="all">All Products</button>
                <?php foreach($categories as $cat): ?>
                    <button class="filter-btn whitespace-nowrap px-5 py-2 rounded-full text-sm font-bold text-gray-600 bg-gray-50 border border-gray-200 hover:border-accent hover:text-accent transition duration-300" data-filter="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></button>
                <?php endforeach; ?>
            </div>
            
            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-search text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" placeholder="Search products..." class="block w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition shadow-inner">
            </div>
        </div>

        <!-- Products Grid -->
        <?php if(empty($products)): ?>
            <div class="text-center py-24 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <i class="fa-solid fa-store-slash text-6xl text-gray-200 mb-4"></i>
                <h3 class="text-xl font-bold text-navy mb-2">No Products Found</h3>
                <p class="text-gray-500">There are currently no products listed in the marketplace. Check back later!</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="productsGrid">
                <?php foreach($products as $product): ?>
                    <div class="product-card group bg-white rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(5,150,105,0.15)] border border-gray-100 hover:border-accent/30 transition-all duration-300 flex flex-col h-full" data-category="<?php echo htmlspecialchars($product['category']); ?>">
                        <!-- Image -->
                        <div class="relative h-56 overflow-hidden bg-gray-100">
                            <?php if(!empty($product['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-emerald-50 text-accent/30">
                                    <i class="fa-solid fa-image text-4xl"></i>
                                </div>
                            <?php endif; ?>
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-xs font-bold text-navy shadow-sm border border-white/20">
                                <?php echo htmlspecialchars($product['category']); ?>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="product-title text-xl font-bold text-navy mb-2 group-hover:text-accent transition line-clamp-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-grow"><?php echo htmlspecialchars($product['description']); ?></p>
                            
                            <div class="flex items-center gap-2 mb-6">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-accent flex items-center justify-center text-xs border border-accent/20">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <span class="text-sm font-semibold text-gray-600"><?php echo htmlspecialchars($product['seller_name']); ?></span>
                            </div>
                            
                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                                <div class="text-lg font-bold text-navy">
                                    ₦<?php echo number_format($product['price']); ?>
                                </div>
                                <?php 
                                    // Format phone for Whatsapp (remove + or leading 0, prepend country code if needed)
                                    $waNumber = preg_replace('/[^0-9]/', '', $product['seller_contact']);
                                    if(strpos($waNumber, '234') !== 0 && strlen($waNumber) === 11) {
                                        $waNumber = '234' . substr($waNumber, 1);
                                    }
                                    $waMsg = urlencode("As-salamu alaykum! I saw your product '" . $product['name'] . "' on the LASUMUC Marketplace and I'm interested in buying it.");
                                    $waLink = "https://wa.me/{$waNumber}?text={$waMsg}";
                                ?>
                                <a href="<?php echo $waLink; ?>" target="_blank" class="bg-emerald-50 hover:bg-accent text-accent hover:text-white px-4 py-2 rounded-xl text-sm font-bold transition-all duration-300 shadow-sm border border-accent/20 flex items-center gap-2 group-hover:bg-accent group-hover:text-white">
                                    <i class="fa-brands fa-whatsapp text-lg"></i> Buy
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- No Search Results Message -->
            <div id="noResults" class="hidden text-center py-20">
                <i class="fa-solid fa-search text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-navy mb-2">No matching products</h3>
                <p class="text-gray-500">Try adjusting your search or category filter.</p>
            </div>
        <?php endif; ?>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchInput');
    const productCards = document.querySelectorAll('.product-card');
    const noResults = document.getElementById('noResults');
    const productsGrid = document.getElementById('productsGrid');

    function filterProducts() {
        if(!productsGrid) return;
        
        let activeFilter = document.querySelector('.filter-btn.active').getAttribute('data-filter');
        let searchTerm = searchInput.value.toLowerCase();
        let visibleCount = 0;

        productCards.forEach(card => {
            let category = card.getAttribute('data-category');
            let title = card.querySelector('.product-title').innerText.toLowerCase();
            
            let matchesFilter = (activeFilter === 'all' || category === activeFilter);
            let matchesSearch = title.includes(searchTerm);

            if (matchesFilter && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            productsGrid.classList.add('hidden');
            noResults.classList.remove('hidden');
        } else {
            productsGrid.classList.remove('hidden');
            noResults.classList.add('hidden');
        }
    }

    // Category Buttons click
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active classes
            filterBtns.forEach(b => {
                b.classList.remove('active', 'bg-accent', 'text-white', 'shadow-md', 'border-accent');
                b.classList.add('bg-gray-50', 'text-gray-600', 'border-gray-200');
            });
            // Add active to clicked
            btn.classList.add('active', 'bg-accent', 'text-white', 'shadow-md', 'border-accent');
            btn.classList.remove('bg-gray-50', 'text-gray-600', 'border-gray-200');
            
            filterProducts();
        });
    });

    // Search input keyup
    if(searchInput) {
        searchInput.addEventListener('keyup', filterProducts);
    }
});
</script>

<style>
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>

<?php include 'includes/footer.php'; ?>
