$(document).ready(function() {
    const playlistContainer = $('#surah-playlist');
    const quranContainer = $('#quran-container');
    const loading = $('#quran-loading');
    const initialMsg = $('#quran-initial');
    const errorMsg = $('#quran-error');
    const playlistLoading = $('#playlist-loading');
    const searchInput = $('#surah-search');

    // Global audio object to manage currently playing verse
    let currentAudio = null;
    let currentPlayingBtn = null;

    if (playlistContainer.length === 0) return; // Not on Quran page

    let allSurahs = [];

    // Fetch surah list
    $.get('https://api.alquran.cloud/v1/surah', function(response) {
        if (response.code === 200) {
            allSurahs = response.data;
            renderPlaylist(allSurahs);
            playlistLoading.addClass('hidden');
        }
    }).fail(function() {
        console.error("Failed to fetch surahs");
        playlistLoading.html('<p class="text-red-500 text-sm p-4">Failed to load playlist.</p>');
    });

    // Render Playlist
    function renderPlaylist(surahs) {
        let html = '';
        surahs.forEach(surah => {
            html += `
                <button class="surah-item w-full text-left p-5 border-b border-gray-100 hover:bg-accent/5 transition duration-300 flex items-center justify-between group relative overflow-hidden" data-number="${surah.number}">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-accent transform -translate-x-full group-hover:translate-x-0 transition duration-300"></div>
                    <div class="flex items-center gap-5 relative z-10">
                        <div class="w-12 h-12 rounded-lg bg-navy/5 flex items-center justify-center text-navy font-bold text-sm group-hover:bg-accent group-hover:text-white transition duration-500 border border-navy/10 transform rotate-45 group-hover:rotate-0">
                            <span class="transform -rotate-45 group-hover:rotate-0 transition duration-500 block">${surah.number}</span>
                        </div>
                        <div>
                            <div class="font-bold text-navy group-hover:text-accent transition duration-300 text-lg">${surah.englishName}</div>
                            <div class="text-sm text-gray-500 font-light italic">${surah.englishNameTranslation}</div>
                        </div>
                    </div>
                    <div class="font-arabic text-navy text-2xl opacity-60 group-hover:opacity-100 group-hover:text-accent transition duration-500 drop-shadow-sm">${surah.name}</div>
                </button>
            `;
        });
        playlistContainer.html(html);
    }

    // Handle Search
    searchInput.on('input', function() {
        const query = $(this).val().toLowerCase();
        const filtered = allSurahs.filter(surah => 
            surah.englishName.toLowerCase().includes(query) || 
            surah.englishNameTranslation.toLowerCase().includes(query) ||
            surah.number.toString() === query
        );
        renderPlaylist(filtered);
    });

    // Handle surah click using event delegation
    playlistContainer.on('click', '.surah-item', function() {
        let surahNumber = $(this).data('number');
        if (!surahNumber) return;

        // Stop any currently playing audio
        if(currentAudio) {
            currentAudio.pause();
            currentAudio = null;
        }

        // Active state styling
        $('.surah-item').removeClass('bg-accent/10');
        $('.surah-item').find('.absolute.left-0').removeClass('translate-x-0').addClass('-translate-x-full');
        
        $(this).addClass('bg-accent/10');
        $(this).find('.absolute.left-0').removeClass('-translate-x-full').addClass('translate-x-0');

        quranContainer.html('');
        initialMsg.addClass('hidden');
        loading.removeClass('hidden');
        errorMsg.addClass('hidden');

        // Scroll to top of main area
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Fetch Arabic text and English translation together
        let reqArabic = $.get(`https://api.alquran.cloud/v1/surah/${surahNumber}`);
        let reqEnglish = $.get(`https://api.alquran.cloud/v1/surah/${surahNumber}/en.asad`);

        $.when(reqArabic, reqEnglish).done(function(arabicRes, englishRes) {
            if (arabicRes[0].code === 200 && englishRes[0].code === 200) {
                let surahData = arabicRes[0].data;
                let ayahs = surahData.ayahs;
                let translations = englishRes[0].data.ayahs;
                let html = '';

                // Ornate Surah Header
                html += `
                    <div class="bg-navy rounded-[3rem] p-12 md:p-20 mb-16 text-center relative overflow-hidden shadow-[0_20px_60px_rgba(0,0,0,0.3)] border-[6px] border-accent/20">
                        <!-- Intricate Background Pattern -->
                        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%23D32F2F\\' fill-opacity=\\'1\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        <div class="absolute top-1/2 left-1/2 w-[40rem] h-[40rem] bg-accent opacity-20 rounded-full blur-[100px] transform -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
                        
                        <div class="relative z-10">
                            <!-- Top Arch Ornament -->
                            <div class="flex justify-center items-center mb-8">
                                <svg class="w-24 h-10 text-accent opacity-90 filter drop-shadow-[0_0_8px_rgba(5,150,105,0.5)]" viewBox="0 0 100 30" fill="currentColor">
                                    <path d="M50 0 C60 20, 80 25, 100 30 L0 30 C20 25, 40 20, 50 0 Z"></path>
                                </svg>
                            </div>

                            <div class="flex justify-center items-center space-x-6 mb-8">
                                <div class="h-px bg-gradient-to-l from-accent to-transparent w-24 opacity-80"></div>
                                <span class="text-accent text-sm font-bold tracking-[0.3em] uppercase bg-navy px-4 py-1 rounded-full border border-accent/30 shadow-[0_0_15px_rgba(5,150,105,0.2)]">${surahData.revelationType} &nbsp;&bull;&nbsp; ${surahData.numberOfAyahs} Ayahs</span>
                                <div class="h-px bg-gradient-to-r from-accent to-transparent w-24 opacity-80"></div>
                            </div>
                            
                            <h2 class="text-7xl md:text-8xl lg:text-9xl font-arabic text-white mb-6 drop-shadow-[0_10px_20px_rgba(0,0,0,0.8)]" style="font-family: 'Mirza', serif;">${surahData.name}</h2>
                            <h3 class="text-4xl md:text-5xl font-serif font-bold text-white mb-4 drop-shadow-lg">${surahData.englishName}</h3>
                            <p class="text-gray-300 font-light text-xl md:text-2xl italic tracking-wide">"${surahData.englishNameTranslation}"</p>
                            
                            <div class="mt-10 flex justify-center">
                                <div class="inline-flex items-center space-x-3 bg-black/40 backdrop-blur-xl px-6 py-3 rounded-full border border-white/20 shadow-2xl">
                                    <i class="fa-solid fa-headphones text-accent text-lg filter drop-shadow-[0_0_5px_rgba(5,150,105,0.5)]"></i>
                                    <span class="text-white text-sm font-bold uppercase tracking-[0.2em]">Recitation by As-Sudais</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Add Bismillah if not Surah 1 or 9
                if (surahNumber != 1 && surahNumber != 9) {
                    html += `
                        <div class="text-center mb-16 relative">
                            <div class="text-5xl md:text-7xl font-arabic text-navy mb-8 drop-shadow-md" style="line-height: 1.5;">بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ</div>
                            <div class="flex justify-center items-center">
                                <div class="h-px bg-gradient-to-l from-accent to-transparent w-32 opacity-50"></div>
                                <i class="fa-solid fa-star-and-crescent text-accent mx-8 text-xl opacity-90 drop-shadow-[0_0_5px_rgba(5,150,105,0.3)]"></i>
                                <div class="h-px bg-gradient-to-r from-accent to-transparent w-32 opacity-50"></div>
                            </div>
                        </div>
                    `;
                }

                ayahs.forEach((ayah, index) => {
                    let arabicText = ayah.text;
                    
                    // Dynamic EveryAyah URL generation
                    let paddedSurah = String(surahNumber).padStart(3, '0');
                    let paddedAyah = String(ayah.numberInSurah).padStart(3, '0');
                    let audioUrl = `https://everyayah.com/data/Abdurrahmaan_As-Sudais_192kbps/${paddedSurah}${paddedAyah}.mp3`;
                    
                    // Strip bismillah from the first ayah of each surah (except Fatiha)
                    if (index === 0 && surahNumber != 1) {
                        const b1 = "بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ";
                        const b2 = "بِسۡمِ ٱللَّهِ ٱلرَّحۡمَـٰنِ ٱلرَّحِیمِ";
                        const b3 = "بسم الله الرحمن الرحيم";
                        const b4 = "بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ";

                        arabicText = arabicText.replace(new RegExp(`^${b1}\\s*`), "");
                        arabicText = arabicText.replace(new RegExp(`^${b2}\\s*`), "");
                        arabicText = arabicText.replace(new RegExp(`^${b3}\\s*`), "");
                        arabicText = arabicText.replace(new RegExp(`^${b4}\\s*`), "");
                        
                        arabicText = arabicText.replace(/^بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ ?/, "");
                    }

                    html += `
                        <div class="bg-white/80 backdrop-blur-md p-10 md:p-16 rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.05)] border-[3px] border-accent/10 mb-20 hover:border-accent/40 hover:shadow-[0_20px_60px_rgba(5,150,105,0.1)] transition duration-700 relative group overflow-hidden arabian-border" id="ayah-card-${index}">
                            
                            <!-- Massive Decorative background number -->
                            <div class="absolute -right-8 -bottom-12 text-[15rem] font-black text-navy opacity-[0.03] select-none pointer-events-none font-serif group-hover:text-accent group-hover:opacity-[0.05] transition duration-700">
                                ${ayah.numberInSurah}
                            </div>

                            <div class="flex flex-col gap-10 relative z-10">
                                <!-- Header Row: Number & Audio -->
                                <div class="flex justify-between items-center border-b-2 border-dashed border-accent/20 pb-6">
                                    <div class="w-16 h-16 rounded-full border-4 border-accent/20 flex items-center justify-center bg-white group-hover:bg-accent group-hover:border-accent transition duration-500 shadow-md relative overflow-hidden">
                                        <div class="absolute inset-1 border border-accent/30 rounded-full group-hover:border-white/50 border-dashed"></div>
                                        <span class="font-bold text-2xl text-navy group-hover:text-white transition duration-500 relative z-10">${ayah.numberInSurah}</span>
                                    </div>
                                    
                                    <button class="play-audio-btn w-16 h-16 rounded-full bg-white border-4 border-accent/10 text-navy hover:bg-accent hover:text-white hover:border-accent transition duration-500 flex items-center justify-center shadow-lg transform hover:scale-110" data-audio="${audioUrl}" data-index="${index}" title="Play Ayah">
                                        <i class="fa-solid fa-play ml-1 text-xl"></i>
                                    </button>
                                </div>

                                <!-- Content -->
                                <div class="space-y-12">
                                    <!-- Arabic Text -->
                                    <div class="text-right font-arabic text-navy text-4xl md:text-5xl lg:text-[4rem] leading-[2.5] md:leading-[2.5] lg:leading-[2.5] drop-shadow-sm">
                                        ${arabicText}
                                    </div>

                                    <!-- Translation Divider -->
                                    <div class="flex items-center justify-center py-2">
                                        <div class="w-1/3 h-px bg-gradient-to-r from-transparent to-accent/40"></div>
                                        <div class="w-3 h-3 rotate-45 border border-accent/60 mx-4"></div>
                                        <div class="w-1/3 h-px bg-gradient-to-l from-transparent to-accent/40"></div>
                                    </div>

                                    <!-- Translation -->
                                    <div class="font-sans text-gray-700 text-xl lg:text-2xl leading-relaxed font-light text-left bg-[#fcfbf9] p-8 md:p-10 rounded-[2rem] border border-accent/10 shadow-inner">
                                        ${translations[index].text}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                quranContainer.html(html);
                loading.addClass('hidden');
                
                // Audio controls event listener
                attachAudioListeners();
                
            } else {
                showError();
            }
        }).fail(showError);
    });

    function attachAudioListeners() {
        $('.play-audio-btn').on('click', function() {
            let btn = $(this);
            let audioUrl = btn.data('audio');
            let icon = btn.find('i');
            
            // If clicking the same button that is currently playing
            if(currentPlayingBtn && currentPlayingBtn.get(0) === btn.get(0) && currentAudio) {
                if(currentAudio.paused) {
                    currentAudio.play();
                    icon.removeClass('fa-play text-navy').addClass('fa-pause text-white');
                } else {
                    currentAudio.pause();
                    icon.removeClass('fa-pause text-white').addClass('fa-play text-white');
                }
                return;
            }
            
            // Reset previous button if exists
            if(currentPlayingBtn) {
                currentPlayingBtn.find('i').removeClass('fa-pause text-white').addClass('fa-play text-navy');
                currentPlayingBtn.removeClass('bg-accent text-white border-accent').addClass('bg-white text-navy border-accent/10');
                currentPlayingBtn.closest('.bg-white\\/80').removeClass('ring-4 ring-accent border-accent shadow-lg');
            }
            
            // Stop existing audio
            if(currentAudio) {
                currentAudio.pause();
            }
            
            // Create and play new audio
            currentAudio = new Audio(audioUrl);
            currentPlayingBtn = btn;
            
            // UI updates for playing state
            icon.removeClass('fa-play text-navy').addClass('fa-pause text-white');
            btn.removeClass('bg-white text-navy border-accent/10').addClass('bg-accent text-white border-accent');
            btn.closest('.bg-white\\/80').addClass('ring-4 ring-accent border-accent shadow-lg');
            
            currentAudio.play();
            
            // Handle audio end
            currentAudio.onended = function() {
                icon.removeClass('fa-pause text-white').addClass('fa-play');
                btn.removeClass('bg-accent text-white border-accent').addClass('bg-white text-navy border-accent/10');
                btn.closest('.bg-white\\/80').removeClass('ring-4 ring-accent border-accent shadow-[0_0_40px_rgba(5,150,105,0.2)]');
                
                // Autoplay next verse
                let nextBtn = btn.closest('.bg-white\\/80').next().find('.play-audio-btn');
                if(nextBtn.length > 0) {
                    // Scroll to next ayah
                    $('html, body').animate({
                        scrollTop: nextBtn.closest('.bg-white\\/80').offset().top - 100
                    }, 500);
                    nextBtn.click();
                }
            };
        });
    }

    function showError() {
        loading.addClass('hidden');
        errorMsg.removeClass('hidden');
    }
});
