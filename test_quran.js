

async function testWord4Word() {
    try {
        let res = await fetch('https://api.quran.com/api/v4/verses/random?words=true&language=en');
        let data = await res.json();
        let verse = data.verse;
        
        console.log("Random verse:", verse.verse_key);
        
        let transRes = await fetch(`https://api.alquran.cloud/v1/ayah/${verse.verse_key}/en.asad`);
        let transData = await transRes.json();
        let fullTranslation = transData.data.text;
        
        console.log("Full Translation:", fullTranslation);
    } catch(e) {
        console.error("Word4Word Error:", e.message);
    }
}

async function testSurahs() {
    try {
        let promises = [];
        for(let i=0; i<4; i++) {
            let rnd = Math.floor(Math.random() * 6236) + 1;
            promises.push(fetch(`https://api.alquran.cloud/v1/ayah/${rnd}/editions/quran-uthmani,en.asad`).then(r => r.json()));
        }
        
        let results = await Promise.all(promises);
        console.log("Surahs success. Target:", results[0].data[1].text);
    } catch(e) {
        console.error("Surahs Error:", e.message);
    }
}

testWord4Word().then(testSurahs);
