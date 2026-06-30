<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<!-- Hero Section -->
<div class="relative bg-navy overflow-hidden py-16 text-center">
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23d4af37\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <h1 class="text-4xl font-serif font-extrabold text-white sm:text-5xl mb-4">Hijri <span class="text-accent-gradient">Calendar</span></h1>
        <div class="w-16 h-1 bg-accent mx-auto mb-4 rounded-full opacity-70"></div>
        <p class="text-gray-300 font-light text-lg">Gregorian & Hijri Dates for the Year <span id="currentYearDisplay" class="font-bold text-white"></span></p>
    </div>
</div>

<!-- Calendar Layout -->
<div class="bg-slate-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Controls & Legend -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-white p-6 rounded-2xl shadow-[0_4px_15px_rgb(0,0,0,0.02)] border border-gray-100">
            <div class="flex items-center gap-4">
                <button id="prevYear" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:text-accent hover:border-accent hover:bg-emerald-50 transition shadow-sm">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <h2 id="calendarTitle" class="text-2xl font-bold font-serif text-navy w-32 text-center"></h2>
                <button id="nextYear" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:text-accent hover:border-accent hover:bg-emerald-50 transition shadow-sm">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
            
            <div class="flex flex-wrap items-center gap-4 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-accent"></div>
                    <span class="text-gray-600">Today</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-gold border border-gold/50"></div>
                    <span class="text-gray-600">Islamic Event</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-navy text-white text-[10px] flex items-center justify-center font-bold">H</div>
                    <span class="text-gray-600">Hijri Day</span>
                </div>
            </div>
        </div>

        <div id="calendar-loading" class="py-24 text-center">
            <i class="fa-solid fa-spinner fa-spin text-5xl text-accent mb-6 drop-shadow-md"></i>
            <p class="text-gray-500 font-bold tracking-widest uppercase text-sm">Generating Full Year Calendar...</p>
        </div>

        <!-- The Grid of Months -->
        <div id="calendar-content" class="hidden grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
            <!-- Rendered via JS -->
        </div>
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentYear = new Date().getFullYear();
    
    // Store data so we don't refetch
    let calendarCache = {};

    function getMonthName(monthNumber) {
        const date = new Date(2000, monthNumber - 1, 1);
        return date.toLocaleString('default', { month: 'long' });
    }

    function renderCalendarGrid(year) {
        $('#calendarTitle').text(year);
        $('#currentYearDisplay').text(year);
        $('#calendar-loading').removeClass('hidden');
        $('#calendar-content').addClass('hidden').empty();

        if (calendarCache[year]) {
            buildDOM(calendarCache[year], year);
            return;
        }

        $.ajax({
            url: `https://api.aladhan.com/v1/calendarByCity/${year}?city=Lagos&country=Nigeria&method=2`,
            method: 'GET',
            success: function(response) {
                if(response.code === 200) {
                    calendarCache[year] = response.data;
                    buildDOM(response.data, year);
                } else {
                    $('#calendar-loading').html('<p class="text-red-500">Failed to load calendar data.</p>');
                }
            },
            error: function() {
                $('#calendar-loading').html('<p class="text-red-500">Failed to connect to calendar service.</p>');
            }
        });
    }

    function buildDOM(data, year) {
        let html = '';
        let today = new Date();
        let currentDay = today.getDate();
        let currentMonth = today.getMonth() + 1;
        let currentYr = today.getFullYear();

        const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        // Loop through 1 to 12 (Months)
        for (let m = 1; m <= 12; m++) {
            let monthData = data[m];
            if (!monthData) continue;

            let monthName = getMonthName(m);
            
            // Identify distinct Hijri months in this Gregorian month
            let hijriMonths = [];
            monthData.forEach(d => {
                let hMonth = d.date.hijri.month.en;
                if (!hijriMonths.includes(hMonth)) {
                    hijriMonths.push(hMonth);
                }
            });

            html += `
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden flex flex-col">
                <div class="bg-navy p-4 flex justify-between items-center border-b-[3px] border-accent">
                    <h3 class="text-white font-serif text-xl font-bold">${monthName}</h3>
                    <span class="text-gold text-sm font-medium tracking-wide text-right">${hijriMonths.join(' / ')}</span>
                </div>
                <div class="p-4 flex-grow">
                    <div class="grid grid-cols-7 gap-1 mb-2">
                        ${weekdays.map(w => `<div class="text-center text-xs font-bold text-gray-400 uppercase tracking-wider">${w}</div>`).join('')}
                    </div>
                    <div class="grid grid-cols-7 gap-1">
            `;

            // Get first day of the month to pad empty cells
            let firstDayDateStr = monthData[0].date.gregorian.date; // DD-MM-YYYY
            let [d1, m1, y1] = firstDayDateStr.split('-');
            let firstDayDate = new Date(y1, m1 - 1, d1);
            let startDayOfWeek = firstDayDate.getDay();

            // Empty cells
            for(let i = 0; i < startDayOfWeek; i++) {
                html += `<div class="p-2 border border-transparent"></div>`;
            }

            monthData.forEach(dayInfo => {
                let gDay = parseInt(dayInfo.date.gregorian.day);
                let hDay = dayInfo.date.hijri.day;
                let holidays = dayInfo.date.hijri.holidays || [];
                
                let isToday = (gDay === currentDay && m === currentMonth && year === currentYr);
                let isEvent = holidays.length > 0;
                
                let cellClasses = "relative p-2 md:p-3 rounded-lg border flex flex-col items-center justify-center aspect-square transition-all duration-300 group ";
                
                if (isToday) {
                    cellClasses += "bg-accent border-accent text-white shadow-[0_4px_15px_rgba(5,150,105,0.4)] transform hover:scale-105 z-10 ";
                } else if (isEvent) {
                    cellClasses += "bg-emerald-50 border-gold/50 text-navy hover:bg-gold hover:text-white hover:border-gold ";
                } else {
                    cellClasses += "bg-gray-50 border-gray-100 text-gray-600 hover:bg-navy hover:text-white hover:border-navy ";
                }

                // Tooltip for holidays
                let tooltipAttr = isEvent ? `title="${holidays.join(', ')}"` : '';

                html += `
                <div class="${cellClasses}" ${tooltipAttr}>
                    ${isEvent && !isToday ? `<div class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-gold rounded-full border border-white animate-pulse"></div>` : ''}
                    <span class="text-base md:text-lg font-bold leading-none ${isToday ? 'text-white' : ''}">${gDay}</span>
                    <span class="text-[10px] md:text-xs mt-1 font-medium ${isToday ? 'text-emerald-100' : 'text-gray-400 group-hover:text-gray-300'}">${hDay}</span>
                </div>`;
            });

            html += `
                    </div>
                </div>
            </div>`;
        }

        $('#calendar-loading').addClass('hidden');
        $('#calendar-content').html(html).removeClass('hidden');
    }

    // Initial load
    renderCalendarGrid(currentYear);

    // Navigation
    $('#prevYear').click(function() {
        currentYear--;
        renderCalendarGrid(currentYear);
    });

    $('#nextYear').click(function() {
        currentYear++;
        renderCalendarGrid(currentYear);
    });
});
</script>

<?php include 'includes/footer.php'; ?>
