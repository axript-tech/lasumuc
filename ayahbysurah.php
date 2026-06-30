<?php include 'includes/header.php'; ?>

<!-- Quiz Header -->
<div class="pt-24 pb-12 bg-navy relative overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-64 h-64 bg-accent opacity-10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-red-500 opacity-10 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
        <a href="quran-quiz.php" class="inline-flex items-center text-gray-400 hover:text-white transition mb-6 text-sm font-bold uppercase tracking-widest">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Quizzes
        </a>
        <h2 class="text-red-400 font-bold tracking-widest uppercase text-sm mb-2" id="quizType">Ayah in Surah Quiz</h2>
        <h1 class="text-3xl md:text-5xl font-serif font-extrabold text-white" id="verseNumber">Identify the Surah</h1>
    </div>
</div>

<!-- Quiz Interface -->
<div class="py-12 bg-gray-50 border-t border-gray-100 min-h-[60vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Score & Actions Row -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-3">
                <button onclick="showHint()" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-navy hover:border-accent hover:text-accent transition shadow-sm">
                    <i class="fa-solid fa-lightbulb text-gold"></i> Hint
                </button>
            </div>
            <div class="flex items-center gap-3 px-6 py-2.5 bg-navy text-white rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(0,0,0,0.1)]">
                <i class="fa-solid fa-star text-gold"></i> <span id="scoreDisplay" class="tracking-wide">0 Points</span>
            </div>
        </div>

        <!-- Question Card -->
        <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 md:p-16 text-center mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-400 via-accent to-red-400"></div>
            
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">Which Surah is this verse from?</p>
            <h1 id="verseQuestion" class="text-3xl md:text-5xl font-arabic text-navy leading-loose mb-6" dir="rtl">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</h1>
            <p id="verseTranslation" class="text-xl text-gray-500 font-light">
                <!-- Loaded dynamically -->
            </p>
            
            <!-- Hidden Hint Area -->
            <div id="tip" class="hidden mt-10 pt-10 border-t border-gray-100">
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-white px-4 py-1 rounded-full border border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-widest shadow-sm">
                        Hint
                    </div>
                    <div id="tipHint">
                        <!-- Loaded dynamically -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Options Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="ayatOptions">
            <button onclick="checkAnswer(this, false)" class="option-btn group bg-white rounded-2xl p-6 shadow-[0_4px_15px_rgb(0,0,0,0.02)] border-2 border-gray-100 hover:border-accent hover:shadow-[0_8px_20px_rgba(5,150,105,0.1)] transition-all duration-300 text-left flex items-center justify-between">
                <span class="text-xl font-bold text-navy group-hover:text-accent transition">Al-Baqarah (The Cow)</span>
                <div class="w-8 h-8 rounded-full border-2 border-gray-200 group-hover:border-accent flex items-center justify-center transition">
                    <i class="fa-solid fa-check text-white text-sm opacity-0 transition"></i>
                </div>
            </button>
            <button onclick="checkAnswer(this, true)" class="option-btn group bg-white rounded-2xl p-6 shadow-[0_4px_15px_rgb(0,0,0,0.02)] border-2 border-gray-100 hover:border-accent hover:shadow-[0_8px_20px_rgba(5,150,105,0.1)] transition-all duration-300 text-left flex items-center justify-between">
                <span class="text-xl font-bold text-navy group-hover:text-accent transition">Al-Fatihah (The Opening)</span>
                <div class="w-8 h-8 rounded-full border-2 border-gray-200 group-hover:border-accent flex items-center justify-center transition">
                    <i class="fa-solid fa-check text-white text-sm opacity-0 transition"></i>
                </div>
            </button>
            <button onclick="checkAnswer(this, false)" class="option-btn group bg-white rounded-2xl p-6 shadow-[0_4px_15px_rgb(0,0,0,0.02)] border-2 border-gray-100 hover:border-accent hover:shadow-[0_8px_20px_rgba(5,150,105,0.1)] transition-all duration-300 text-left flex items-center justify-between">
                <span class="text-xl font-bold text-navy group-hover:text-accent transition">Al-Ikhlas (The Sincerity)</span>
                <div class="w-8 h-8 rounded-full border-2 border-gray-200 group-hover:border-accent flex items-center justify-center transition">
                    <i class="fa-solid fa-check text-white text-sm opacity-0 transition"></i>
                </div>
            </button>
            <button onclick="checkAnswer(this, false)" class="option-btn group bg-white rounded-2xl p-6 shadow-[0_4px_15px_rgb(0,0,0,0.02)] border-2 border-gray-100 hover:border-accent hover:shadow-[0_8px_20px_rgba(5,150,105,0.1)] transition-all duration-300 text-left flex items-center justify-between">
                <span class="text-xl font-bold text-navy group-hover:text-accent transition">Al-Kahf (The Cave)</span>
                <div class="w-8 h-8 rounded-full border-2 border-gray-200 group-hover:border-accent flex items-center justify-center transition">
                    <i class="fa-solid fa-check text-white text-sm opacity-0 transition"></i>
                </div>
            </button>
        </div>
        
    </div>
</div>

<script>
    let score = 0;
    let isProcessing = false;
    let hintUsed = false;

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    async function loadQuestion() {
        isProcessing = true;
        hintUsed = false;
        $('#tip').hide();
        $('#ayatOptions').html('<div class="col-span-2 text-center text-gray-400 py-8"><i class="fa-solid fa-spinner fa-spin text-3xl"></i> Loading...</div>');
        
        try {
            let promises = [];
            for(let i=0; i<4; i++) {
                let rnd = Math.floor(Math.random() * 6236) + 1;
                promises.push(fetch(`https://api.alquran.cloud/v1/ayah/${rnd}/editions/quran-uthmani,en.asad`).then(r => r.json()));
            }
            
            let results = await Promise.all(promises);
            let targetData = results[0].data;
            let targetArabic = targetData[0].text;
            let targetEnglish = targetData[1].text;
            let targetSurahName = targetData[0].surah.englishName;
            let targetSurahNumber = targetData[0].surah.number;
            
            $('#verseNumber').text(`Identify the Surah`);
            $('#verseQuestion').text(targetArabic);
            $('#verseTranslation').text(`"${targetEnglish}"`);
            
            // Build hint block 
            $('#tipHint').html(`
                <p class="text-lg text-navy font-medium text-center">
                    This verse belongs to Surah number <b class="text-accent">${targetSurahNumber}</b> in the Quran.
                </p>
            `);
            
            let options = [];
            let seenSurahs = new Set();
            
            for(let i=0; i<results.length; i++) {
                let sName = results[i].data[0].surah.englishName;
                if(!seenSurahs.has(sName)) {
                    seenSurahs.add(sName);
                    options.push({
                        text: sName,
                        isCorrect: (sName === targetSurahName)
                    });
                }
            }
            
            // If we don't have 4 unique options (rare but possible), pad with hardcoded common surahs
            const fallbacks = ["Al-Baqarah", "Yaseen", "Al-Kahf", "Ar-Rahman", "Al-Mulk", "Al-Ikhlas"];
            while(options.length < 4) {
                let f = fallbacks[Math.floor(Math.random() * fallbacks.length)];
                if(!seenSurahs.has(f)) {
                    seenSurahs.add(f);
                    options.push({ text: f, isCorrect: false });
                }
            }
            
            shuffleArray(options);
            
            let labels = ['A', 'B', 'C', 'D'];
            let optionsHtml = '';
            options.forEach((opt, idx) => {
                let label = labels[idx];
                optionsHtml += `
                <button onclick="checkAnswer(this, ${opt.isCorrect})" data-correct="${opt.isCorrect}" class="option-btn group bg-white rounded-2xl p-4 md:p-6 shadow-[0_4px_15px_rgb(0,0,0,0.02)] border-2 border-gray-100 hover:border-accent hover:shadow-[0_8px_20px_rgba(5,150,105,0.1)] transition-all duration-300 text-left flex items-center justify-between relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-2 h-full bg-gray-100 group-hover:bg-accent transition"></div>
                    <div class="flex items-center gap-4 ml-4">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 font-bold flex items-center justify-center group-hover:bg-accent/10 group-hover:text-accent transition border border-gray-100 shrink-0">
                            ${label}
                        </div>
                        <span class="text-xl font-bold text-navy group-hover:text-accent transition">${opt.text}</span>
                    </div>
                    <div class="w-8 h-8 rounded-full border-2 border-gray-200 group-hover:border-accent flex items-center justify-center transition shrink-0">
                        <i class="fa-solid fa-check text-white text-sm opacity-0 transition"></i>
                    </div>
                </button>`;
            });
            
            $('#ayatOptions').html(optionsHtml);
            isProcessing = false;
        } catch(e) {
            console.error(e);
            $('#ayatOptions').html(`<div class="col-span-2 md:col-span-4 text-center text-red-500 py-8">Failed to load question: ${e.message}. Please try again.</div>`);
            isProcessing = false;
        }
    }

    function showHint() {
        if(!hintUsed && !isProcessing) {
            hintUsed = true;
            $('#tip').slideToggle(400);
            
            // Highlight correct answer
            let correctBtn = $('.option-btn[data-correct="true"]');
            correctBtn.addClass('border-accent bg-emerald-50/50 ring-2 ring-accent ring-opacity-50');
        }
    }
    
    function checkAnswer(btn, isCorrect) {
        if(isProcessing) return;
        isProcessing = true;
        
        $('.option-btn').prop('disabled', true).css('cursor', 'not-allowed');
        let iconContainer = $(btn).find('div.w-8.h-8.rounded-full');
        let icon = $(btn).find('i.fa-solid, i.fa-check');
        
        if(isCorrect) {
            playAudioEffect('correct');
            $(btn).removeClass('border-gray-100 hover:border-accent').addClass('border-accent bg-emerald-50/50');
            $(btn).find('.absolute.w-2').removeClass('bg-gray-100 group-hover:bg-accent').addClass('bg-accent');
            iconContainer.removeClass('border-gray-200 group-hover:border-accent').addClass('bg-accent border-accent shadow-[0_0_15px_rgba(5,150,105,0.4)]');
            icon.removeClass('opacity-0 fa-xmark').addClass('opacity-100 fa-check');
            
            if(!hintUsed) {
                let scoreText = $('#scoreDisplay').text();
                let newScore = parseInt(scoreText) + 30; 
                $('#scoreDisplay').text(newScore + ' Points').addClass('text-gold');
                saveQuizScore(30);
            }
            
            setTimeout(() => {
                loadQuestion();
            }, 1500);
        } else {
            playAudioEffect('wrong');
            $(btn).removeClass('border-gray-100 hover:border-accent').addClass('border-red-500 bg-red-50');
            $(btn).find('.absolute.w-2').removeClass('bg-gray-100 group-hover:bg-accent').addClass('bg-red-500');
            iconContainer.removeClass('border-gray-200 group-hover:border-accent').addClass('bg-red-500 border-red-500');
            icon.removeClass('fa-check opacity-0').addClass('fa-xmark opacity-100');
            $(btn).find('span.text-xl').addClass('text-red-700');
            
            // Highlight the correct answer automatically
            let correctBtn = $('.option-btn[data-correct="true"]');
            correctBtn.addClass('border-accent bg-emerald-50/50 ring-2 ring-accent ring-opacity-50');
            correctBtn.find('div.w-8.h-8.rounded-full').removeClass('border-gray-200 group-hover:border-accent').addClass('bg-accent border-accent shadow-[0_0_15px_rgba(5,150,105,0.4)]');
            correctBtn.find('i.fa-solid, i.fa-check').removeClass('opacity-0 fa-xmark').addClass('opacity-100 fa-check');
            correctBtn.find('.absolute.w-2').removeClass('bg-gray-100 group-hover:bg-accent').addClass('bg-accent');
            
            setTimeout(() => {
                loadQuestion();
            }, 2500);
        }
    }

    $(document).ready(function() {
        loadQuestion();
    });
</script>

<?php include 'includes/footer.php'; ?>
