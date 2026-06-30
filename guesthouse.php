<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<div class="bg-navy py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-serif font-bold text-white mb-4">LASUMUC Guest House</h1>
            <p class="text-gray-300 text-lg max-w-2xl mx-auto">Experience comfort and tranquility at our premium guest house facilities, perfect for visiting scholars and guests.</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-12 text-center">
        <i class="fa-solid fa-bed text-6xl text-accent mb-6 opacity-80"></i>
        <h2 class="text-2xl font-bold text-navy mb-4">Under Construction</h2>
        <p class="text-gray-600">We are currently preparing the booking system and photos for the LASUMUC Guest House. Please check back soon!</p>
        
        <div class="mt-8">
            <a href="<?php echo $base_url; ?>/contact.php" class="inline-block px-8 py-3 bg-forest text-white rounded-xl font-bold hover:bg-green-800 transition">Contact Us for Inquiries</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
