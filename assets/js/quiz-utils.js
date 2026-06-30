// Shared Logic for Quran Quizzes

const audioCtx = new (window.AudioContext || window.webkitAudioContext)();

function playAudioEffect(type) {
    if(audioCtx.state === 'suspended') {
        audioCtx.resume();
    }
    let osc = audioCtx.createOscillator();
    let gain = audioCtx.createGain();
    
    osc.connect(gain);
    gain.connect(audioCtx.destination);
    
    if (type === 'correct') {
        osc.type = 'sine';
        osc.frequency.setValueAtTime(523.25, audioCtx.currentTime); // C5
        osc.frequency.exponentialRampToValueAtTime(1046.50, audioCtx.currentTime + 0.1); // C6
        gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.3);
    } else if (type === 'wrong') {
        osc.type = 'sawtooth';
        osc.frequency.setValueAtTime(150, audioCtx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(100, audioCtx.currentTime + 0.3);
        gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.3);
    }
}

function saveQuizScore(points) {
    if(points <= 0) return;
    
    $.ajax({
        url: BASE_URL + '/ajax/save_quiz_score.php',
        type: 'POST',
        data: { points: points },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                console.log("Score saved! New Score:", response.new_score);
            }
        }
    });
}
