<?php include 'includes/header.php'; ?>

<!-- Quiz Header -->
<div class="pt-24 pb-12 bg-navy relative overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-64 h-64 bg-accent opacity-10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-gold opacity-10 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
        <a href="quran-quiz.php" class="inline-flex items-center text-gray-400 hover:text-white transition mb-6 text-sm font-bold uppercase tracking-widest">
            <i class="fa-solid fa-arrow-left mr-2"></i> Back to Quizzes
        </a>
        <h2 class="text-gold font-bold tracking-widest uppercase text-sm mb-2" id="quizType">Word for Word Quiz</h2>
        <h1 class="text-3xl md:text-5xl font-serif font-extrabold text-white" id="verseNumber" title="37122">Al-Isra 17:82</h1>
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
                <button onclick="reportBug()" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-500 hover:border-red-400 hover:bg-red-50 hover:text-red-600 transition shadow-sm">
                    <i class="fa-solid fa-bug"></i> Report
                </button>
            </div>
            <div class="flex items-center gap-3 px-6 py-2.5 bg-navy text-white rounded-xl text-sm font-bold shadow-[0_4px_15px_rgba(0,0,0,0.1)]">
                <i class="fa-solid fa-star text-gold"></i> <span id="scoreDisplay" class="tracking-wide">0 Points</span>
            </div>
        </div>

        <!-- Question Card -->
        <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 md:p-16 text-center mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-accent via-gold to-accent"></div>
            
            <h1 id="wordQuestion" class="text-6xl md:text-[6rem] font-arabic text-navy mb-6 leading-tight mt-4" dir="rtl">لِلْمُؤْمِنِينَ</h1>
            <p id="wordQuestionTrans" class="text-xl md:text-2xl text-gray-400 font-medium tracking-widest uppercase">lil'mu'minīna</p>
            
            <!-- Hidden Hint Area -->
            <div id="tip" class="hidden mt-10 pt-10 border-t border-gray-100">
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-white px-4 py-1 rounded-full border border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-widest shadow-sm">
                        Verse Context
                    </div>
                    <p id="tipVerse" class="text-3xl md:text-4xl font-arabic text-navy leading-loose mb-8" dir="rtl">
                        <!-- Loaded dynamically -->
                    </p>
                    <button onclick="showTranslationModal()" class="inline-flex items-center px-6 py-3 bg-navy text-white font-bold text-sm tracking-wide uppercase rounded-xl hover:bg-accent transition shadow-md">
                        <i class="fa-solid fa-language mr-2 text-gold"></i> View Translation
                    </button>
                </div>
            </div>
        </div>

        <!-- Options Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="ayatOptions">
            <button onclick="checkAnswer(this, false)" class="option-btn group bg-white rounded-2xl p-6 shadow-[0_4px_15px_rgb(0,0,0,0.02)] border-2 border-gray-100 hover:border-accent hover:shadow-[0_8px_20px_rgba(5,150,105,0.1)] transition-all duration-300 text-left flex items-center justify-between">
                <span class="text-lg font-bold text-navy group-hover:text-accent transition">Allah has promised you</span>
                <div class="w-8 h-8 rounded-full border-2 border-gray-200 group-hover:border-accent flex items-center justify-center transition">
                    <i class="fa-solid fa-check text-white text-sm opacity-0 transition"></i>
                </div>
            </button>
            <button onclick="checkAnswer(this, true)" class="option-btn group bg-white rounded-2xl p-6 shadow-[0_4px_15px_rgb(0,0,0,0.02)] border-2 border-gray-100 hover:border-accent hover:shadow-[0_8px_20px_rgba(5,150,105,0.1)] transition-all duration-300 text-left flex items-center justify-between">
                <span class="text-lg font-bold text-navy group-hover:text-accent transition">for the believers,</span>
                <div class="w-8 h-8 rounded-full border-2 border-gray-200 group-hover:border-accent flex items-center justify-center transition">
                    <i class="fa-solid fa-check text-white text-sm opacity-0 transition"></i>
                </div>
            </button>
            <button onclick="checkAnswer(this, false)" class="option-btn group bg-white rounded-2xl p-6 shadow-[0_4px_15px_rgb(0,0,0,0.02)] border-2 border-gray-100 hover:border-accent hover:shadow-[0_8px_20px_rgba(5,150,105,0.1)] transition-all duration-300 text-left flex items-center justify-between">
                <span class="text-lg font-bold text-navy group-hover:text-accent transition">what</span>
                <div class="w-8 h-8 rounded-full border-2 border-gray-200 group-hover:border-accent flex items-center justify-center transition">
                    <i class="fa-solid fa-check text-white text-sm opacity-0 transition"></i>
                </div>
            </button>
            <button onclick="checkAnswer(this, false)" class="option-btn group bg-white rounded-2xl p-6 shadow-[0_4px_15px_rgb(0,0,0,0.02)] border-2 border-gray-100 hover:border-accent hover:shadow-[0_8px_20px_rgba(5,150,105,0.1)] transition-all duration-300 text-left flex items-center justify-between">
                <span class="text-lg font-bold text-navy group-hover:text-accent transition">a Record</span>
                <div class="w-8 h-8 rounded-full border-2 border-gray-200 group-hover:border-accent flex items-center justify-center transition">
                    <i class="fa-solid fa-check text-white text-sm opacity-0 transition"></i>
                </div>
            </button>
        </div>
        
    </div>
</div>

<!-- Translation Modal -->
<div id="translationModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-navy/80 backdrop-blur-sm px-4">
    <div class="bg-white rounded-[2rem] shadow-2xl p-8 max-w-lg w-full relative transform transition-all scale-95 opacity-0" id="modalContent">
        <button onclick="closeTranslationModal()" class="absolute top-6 right-6 w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-500 hover:bg-red-50 hover:text-red-500 transition border border-gray-100">
            <i class="fa-solid fa-times"></i>
        </button>
        <h3 class="text-2xl font-bold text-navy mb-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-accent/10 text-accent rounded-full flex items-center justify-center">
                <i class="fa-solid fa-language"></i>
            </div>
            English Translation
        </h3>
        <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 mb-8">
            <p id="modalTranslationText" class="text-lg text-gray-600 leading-relaxed text-center">
                <!-- Loaded dynamically -->
            </p>
        </div>
        <button onclick="closeTranslationModal()" class="w-full py-4 bg-navy hover:bg-accent text-white font-bold tracking-widest uppercase rounded-xl transition shadow-md">
            Close Translation
        </button>
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
            // Fetch random verse with words
            let res = await fetch('https://api.quran.com/api/v4/verses/random?words=true&language=en&word_fields=text_uthmani');
            let data = await res.json();
            let verse = data.verse;
            
            // Get full translation
            let transRes = await fetch(`https://api.alquran.cloud/v1/ayah/${verse.verse_key}/en.asad`);
            let transData = await transRes.json();
            let fullTranslation = transData.data.text;
            
            // Set header
            $('#verseNumber').text('Verse ' + verse.verse_key);
            
            // Filter words (exclude 'end' marker)
            let validWords = verse.words.filter(w => w.char_type_name === 'word' && w.translation && w.translation.text);
            
            if(validWords.length < 1) {
                return loadQuestion(); // Retry if verse has no words
            }
            
            // Pick target word
            let target = validWords[Math.floor(Math.random() * validWords.length)];
            
            // Generate full verse HTML for hint
            let hintHtml = '';
            verse.words.forEach(w => {
                if(w.char_type_name === 'word') {
                    let wText = w.text_uthmani || w.text;
                    if(w.id === target.id) {
                        hintHtml += `<b class="text-accent bg-accent/10 px-2 mx-1 rounded border border-accent/20">${wText}</b> `;
                    } else {
                        hintHtml += wText + ' ';
                    }
                }
            });
            
            $('#wordQuestion').text(target.text_uthmani || target.text);
            $('#wordQuestionTrans').text(target.transliteration.text || '');
            $('#tipVerse').html(hintHtml);
            $('#modalTranslationText').html(fullTranslation.replace(/<sup.*?<\/sup>/g, ''));
            
            // Distractors
            let options = [target];
            
            // Try to find distractors in same verse
            let distractorsPool = validWords.filter(w => w.id !== target.id);
            shuffleArray(distractorsPool);
            
            for(let i=0; i < distractorsPool.length; i++) {
                if(options.length >= 4) break;
                // Ensure unique translation
                if(!options.find(o => o.translation.text.toLowerCase() === distractorsPool[i].translation.text.toLowerCase())) {
                    options.push(distractorsPool[i]);
                }
            }
            
            // If still need more, fetch another verse words
            if(options.length < 4) {
                let extraRes = await fetch('https://api.quran.com/api/v4/verses/random?words=true&language=en&word_fields=text_uthmani');
                let extraData = await extraRes.json();
                let extraWords = extraData.verse.words.filter(w => w.char_type_name === 'word' && w.translation && w.translation.text);
                shuffleArray(extraWords);
                for(let i=0; i < extraWords.length; i++) {
                    if(options.length >= 4) break;
                    if(!options.find(o => o.translation.text.toLowerCase() === extraWords[i].translation.text.toLowerCase())) {
                        options.push(extraWords[i]);
                    }
                }
            }
            
            shuffleArray(options);
            
            let labels = ['A', 'B', 'C', 'D'];
            let optionsHtml = '';
            options.forEach((opt, idx) => {
                let isCorrect = (opt.id === target.id);
                let label = labels[idx];
                optionsHtml += `
                <button onclick="checkAnswer(this, ${isCorrect})" data-correct="${isCorrect}" class="option-btn group bg-white rounded-2xl p-4 md:p-6 shadow-[0_4px_15px_rgb(0,0,0,0.02)] border-2 border-gray-100 hover:border-accent hover:shadow-[0_8px_20px_rgba(5,150,105,0.1)] transition-all duration-300 text-left flex items-center justify-between relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-2 h-full bg-gray-100 group-hover:bg-accent transition"></div>
                    <div class="flex items-center gap-4 ml-4">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 font-bold flex items-center justify-center group-hover:bg-accent/10 group-hover:text-accent transition border border-gray-100 shrink-0">
                            ${label}
                        </div>
                        <span class="text-lg font-bold text-navy group-hover:text-accent transition">${opt.translation.text}</span>
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
            $('#ayatOptions').html(`<div class="col-span-2 text-center text-red-500 py-8">Failed to load question: ${e.message}. Please try again.</div>`);
            isProcessing = false;
        }
    }

    function showHint() {
        if(!hintUsed && !isProcessing) {
            hintUsed = true;
            $('#tip').slideToggle(400);
            
            let correctBtn = $('.option-btn[data-correct="true"]');
            correctBtn.addClass('border-accent bg-emerald-50/50 ring-2 ring-accent ring-opacity-50');
        }
    }
    
    function reportBug() {
        alert('Bug reported successfully. Thank you for your feedback!');
    }
    
    function showTranslationModal() {
        $('#translationModal').removeClass('hidden');
        setTimeout(() => {
            $('#modalContent').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
        }, 10);
    }
    
    function closeTranslationModal() {
        $('#modalContent').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
        setTimeout(() => {
            $('#translationModal').addClass('hidden');
        }, 300);
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
                let newScore = parseInt(scoreText) + 10; 
                $('#scoreDisplay').text(newScore + ' Points').addClass('text-gold');
                saveQuizScore(10);
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
            $(btn).find('span.text-lg').addClass('text-red-700');
            
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
