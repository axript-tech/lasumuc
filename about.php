<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<!-- Premium Header -->
<div class="relative bg-navy overflow-hidden py-24 text-center">
    <!-- Abstract pattern overlay -->
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23d4af37\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="absolute top-0 right-0 -mr-40 -mt-40 w-96 h-96 bg-accent rounded-full opacity-20 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="text-5xl font-serif font-extrabold text-white sm:text-6xl tracking-tight mb-6">About <span class="text-accent-gradient">LASUMUC</span></h1>
        <div class="w-24 h-1 bg-accent mx-auto mb-6 rounded-full opacity-70"></div>
        <p class="text-xl text-gray-300 max-w-2xl mx-auto font-light leading-relaxed">Discover our mission, vision, and the core values that drive the Lagos State University Muslim Community.</p>
    </div>
</div>

<div class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="space-y-12">
                <div>
                    <h2 class="text-sm text-accent font-bold tracking-widest uppercase mb-2">Our Purpose</h2>
                    <h3 class="text-4xl font-serif font-extrabold text-navy mb-6">Our Mission</h3>
                    <p class="text-gray-600 text-lg leading-relaxed font-light">
                        To foster a united, spiritually grounded, and academically excellent Muslim community within Lagos State University. We strive to provide a supportive environment that encourages the practice of Islam according to the Quran and Sunnah, offering a premium experience for all members.
                    </p>
                </div>
                <div>
                    <h2 class="text-sm text-accent font-bold tracking-widest uppercase mb-2">Our Future</h2>
                    <h3 class="text-4xl font-serif font-extrabold text-navy mb-6">Our Vision</h3>
                    <p class="text-gray-600 text-lg leading-relaxed font-light">
                        To be the leading student Islamic body in Nigeria, renowned for nurturing future leaders who are morally upright, intellectually sound, and socially responsible, reflecting the highest standards of Islamic excellence.
                    </p>
                </div>
            </div>
            
            <div class="relative">
                <div class="absolute inset-0 bg-accent transform translate-x-4 translate-y-4 rounded-2xl opacity-20"></div>
                <div class="bg-navy rounded-2xl p-10 shadow-[0_20px_50px_rgba(10,35,37,0.3)] relative overflow-hidden">
                    <i class="fa-solid fa-book-quran text-[10rem] text-accent opacity-5 absolute -right-10 -bottom-10"></i>
                    <h3 class="text-3xl font-serif font-bold text-white mb-8 border-b border-white/10 pb-4">Core Values</h3>
                    <ul class="space-y-6">
                        <li class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center mr-4 flex-shrink-0 mt-1 border border-accent/30">
                                <i class="fa-solid fa-star text-accent text-sm"></i>
                            </div>
                            <div>
                                <span class="font-bold text-lg text-white block font-serif tracking-wide">Taqwa (Piety)</span>
                                <span class="text-gray-400 text-sm font-light mt-1 block">Putting Allah first in all our endeavors.</span>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center mr-4 flex-shrink-0 mt-1 border border-accent/30">
                                <i class="fa-solid fa-users text-accent text-sm"></i>
                            </div>
                            <div>
                                <span class="font-bold text-lg text-white block font-serif tracking-wide">Ukhuwah (Brotherhood)</span>
                                <span class="text-gray-400 text-sm font-light mt-1 block">Promoting love, peace, and unity among members.</span>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center mr-4 flex-shrink-0 mt-1 border border-accent/30">
                                <i class="fa-solid fa-book-open text-accent text-sm"></i>
                            </div>
                            <div>
                                <span class="font-bold text-lg text-white block font-serif tracking-wide">Iqra (Education)</span>
                                <span class="text-gray-400 text-sm font-light mt-1 block">Striving for academic and Islamic excellence.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
