<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<!-- Luxurious Arabian Page Header -->
<div class="relative bg-navy overflow-hidden py-16 text-center border-b-[8px] border-accent/80">
    <!-- Ornate Islamic Geometric Background Pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%23d4af37\\' fill-opacity=\\'1\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="absolute top-0 right-0 w-[40rem] h-[40rem] bg-accent opacity-10 rounded-full blur-[100px] transform translate-x-1/3 -translate-y-1/3"></div>
    <div class="absolute bottom-0 left-0 w-[40rem] h-[40rem] bg-forest opacity-20 rounded-full blur-[100px] transform -translate-x-1/3 translate-y-1/3"></div>

    <div class="w-full mx-auto px-4 lg:px-12 relative z-10">
        <!-- Top Arch Ornament -->
        <div class="flex justify-center items-center mb-8">
            <svg class="w-32 h-12 text-accent opacity-80" viewBox="0 0 100 30" fill="currentColor">
                <path d="M50 0 C60 20, 80 25, 100 30 L0 30 C20 25, 40 20, 50 0 Z"></path>
            </svg>
        </div>
        
        <h1 class="text-5xl font-serif font-extrabold text-white md:text-6xl mb-4 tracking-tight" style="text-shadow: 0 4px 20px rgba(0,0,0,0.5);">The Holy <span class="text-accent-gradient">Al-Quran</span></h1>
        
        <div class="flex justify-center items-center mb-6">
            <div class="w-32 h-px bg-gradient-to-l from-accent to-transparent"></div>
            <i class="fa-solid fa-star-and-crescent text-accent mx-6 text-xl opacity-90 filter drop-shadow-[0_0_10px_rgba(248,188,44,0.8)]"></i>
            <div class="w-32 h-px bg-gradient-to-r from-accent to-transparent"></div>
        </div>
        <p class="text-xl text-gray-200 font-light max-w-3xl mx-auto">Immerse yourself in the divine words. Select a Surah from the playlist to read.</p>
    </div>
</div>

<!-- Main Content Area with Full-Width Sidebar Layout -->
<div class="py-12 min-h-screen relative" style="background-color: #ffffff; background-image: url('data:image/svg+xml,%3Csvg width=\\'40\\' height=\\'40\\' viewBox=\\'0 0 40 40\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'%231a365d\\' fill-opacity=\\'0.02\\' fill-rule=\\'evenodd\\'%3E%3Cpath d=\\'M0 40L40 0H20L0 20M40 40V20L20 40\\'/ %3E%3C/g%3E%3C/svg%3E');">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-12 relative z-10">
        
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            
            <!-- Sidebar: Surah Playlist -->
            <div class="lg:w-[350px] xl:w-[400px] flex-shrink-0">
                <div class="bg-white/90 backdrop-blur-md rounded-[2rem] shadow-[0_15px_50px_rgba(0,0,0,0.06)] border-2 border-accent/10 overflow-hidden sticky top-24 h-[85vh] flex flex-col">
                    
                    <div class="p-8 border-b-4 border-accent/80 bg-navy relative overflow-hidden text-center">
                        <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%23d4af37\\' fill-opacity=\\'1\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        <h2 class="text-2xl font-serif font-bold text-white tracking-widest relative z-10">
                            <span class="block text-accent mb-2 text-sm uppercase">Index</span>
                            Surah Playlist
                        </h2>
                    </div>
                    
                    <div class="p-5 bg-[#fcfbf9] border-b border-gray-200">
                        <div class="relative">
                            <input type="text" id="surah-search" placeholder="Search Surah..." class="w-full bg-white border-2 border-accent/20 rounded-2xl py-4 pl-12 pr-4 text-sm font-medium focus:outline-none focus:border-accent focus:ring-4 focus:ring-accent/10 transition shadow-inner text-navy placeholder-gray-400">
                            <i class="fa-solid fa-search absolute left-5 top-4.5 text-accent opacity-70 text-lg" style="margin-top: 2px;"></i>
                        </div>
                    </div>

                    <!-- List Container -->
                    <div class="overflow-y-auto flex-grow custom-scrollbar bg-white/50" id="surah-playlist">
                        <!-- Loading State for Playlist -->
                        <div class="p-12 text-center" id="playlist-loading">
                            <i class="fa-solid fa-spinner fa-spin text-3xl text-accent mb-4"></i>
                            <p class="text-sm text-navy font-bold uppercase tracking-widest">Loading Index...</p>
                        </div>
                        <!-- Surahs injected via JS -->
                    </div>
                </div>
            </div>

            <!-- Main Reading Area (Full Width Remaining) -->
            <div class="flex-grow">
                
                <!-- Initial State -->
                <div id="quran-initial" class="bg-white/90 backdrop-blur-md rounded-[3rem] shadow-[0_15px_50px_rgba(0,0,0,0.06)] border-2 border-forest/10 p-20 text-center h-full flex flex-col items-center justify-center min-h-[70vh] relative overflow-hidden">
                    <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%2320803c\\' fill-opacity=\\'1\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                    
                    <div class="w-32 h-32 rounded-full bg-forest/5 flex items-center justify-center mb-8 border border-forest/20 relative">
                        <div class="absolute inset-2 border border-forest/30 rounded-full border-dashed"></div>
                        <i class="fa-solid fa-book-quran text-6xl text-forest opacity-80"></i>
                    </div>
                    <h3 class="text-4xl font-serif font-extrabold text-forest mb-4">Select a Surah</h3>
                    <p class="text-navy font-light text-xl max-w-md mx-auto">Choose a chapter from the playlist sidebar to begin your recitation.</p>
                </div>

                <!-- Loading State -->
                <div id="quran-loading" class="hidden py-32 text-center bg-white/90 backdrop-blur-md rounded-[3rem] shadow-[0_15px_50px_rgba(0,0,0,0.06)] border-2 border-forest/10 min-h-[70vh] flex flex-col items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%2320803c\\' fill-opacity=\\'1\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                    
                    <div class="relative inline-block w-28 h-28 mb-8">
                        <div class="absolute inset-0 border-[6px] border-forest/10 rounded-full"></div>
                        <div class="absolute inset-0 border-[6px] border-forest rounded-full border-t-transparent animate-spin"></div>
                        <i class="fa-solid fa-book-quran absolute inset-0 m-auto flex items-center justify-center text-4xl text-forest"></i>
                    </div>
                    <p class="text-forest font-bold tracking-[0.3em] uppercase text-lg">Loading Divine Revelation...</p>
                </div>

                <!-- Error State -->
                <div id="quran-error" class="hidden bg-red-50 border-2 border-red-200 rounded-[3rem] p-12 shadow-[0_15px_50px_rgba(0,0,0,0.06)] text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-100 mb-6 border border-red-200">
                        <i class="fa-solid fa-circle-exclamation text-4xl text-red-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-red-800 mb-3">Connection Error</h3>
                    <p class="text-lg font-medium text-red-600">Failed to load the Surah from the server. Please check your internet connection and try again.</p>
                </div>

                <!-- Quran Content Container -->
                <div id="quran-container" class="space-y-0">
                    <!-- Content will be injected here via quran.js -->
                </div>

            </div>
        </div>

    </div>
</div>

<style>
/* Custom Scrollbar for Sidebar */
.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.02); 
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(248,188,44,0.2); 
    border-radius: 20px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(248,188,44,0.4); 
}

/* Arabian Arch Decorative Border for Ayah Cards (applied in JS) */
.arabian-border {
    position: relative;
}
.arabian-border::before {
    content: '';
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    bottom: 10px;
    border: 1px solid rgba(248,188,44,0.1);
    border-radius: 2rem;
    pointer-events: none;
    z-index: 0;
}
</style>

<?php include 'includes/footer.php'; ?>
