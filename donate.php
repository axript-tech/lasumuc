<?php
require_once 'includes/db.php';
include 'includes/header.php';

$campaign_id = isset($_GET['campaign']) ? (int)$_GET['campaign'] : 0;
$selected_campaign = null;

if($campaign_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM campaigns WHERE id = ?");
    $stmt->execute([$campaign_id]);
    $selected_campaign = $stmt->fetch();
}

$stmt = $pdo->query("SELECT * FROM campaigns ORDER BY created_at DESC");
$campaigns = $stmt->fetchAll();

// Get User details if logged in
$user_id = $_SESSION['user_id'] ?? null;
$email = $_SESSION['email'] ?? '';

// Fetch Settings
$settings = [];
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
$bank_name = $settings['bank_name'] ?? 'Guaranty Trust Bank (GTB)';
$paystack_public_key = $settings['paystack_public_key'] ?? 'pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
$account_name = $settings['account_name'] ?? 'LASUMUC General Fund';
$account_number = $settings['account_number'] ?? '0000000000';

$global_bank = [
    'bank_name' => $bank_name,
    'account_name' => $account_name,
    'account_number' => $account_number
];

$campaigns_json = [];
foreach($campaigns as $c) {
    if(!empty($c['account_number']) || !empty($c['image'])) {
        $campaigns_json[$c['id']] = [
            'bank_name' => !empty($c['bank_name']) ? $c['bank_name'] : $bank_name,
            'account_name' => !empty($c['account_name']) ? $c['account_name'] : $account_name,
            'account_number' => !empty($c['account_number']) ? $c['account_number'] : $account_number,
            'image' => !empty($c['image']) ? $c['image'] : null
        ];
    }
}
?>

<div class="bg-navy py-16 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23d4af37\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <h1 class="text-4xl font-serif font-extrabold text-white sm:text-5xl mb-4">Make a <span class="text-accent-gradient">Donation</span></h1>
        <div class="w-16 h-1 bg-accent mx-auto mb-4 rounded-full opacity-70"></div>
        <p class="text-gray-300 font-light">Support the LASUMUC community. Your generous contributions empower our mission.</p>
    </div>
</div>

<div class="bg-slate-50 py-16 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_60px_rgb(0,0,0,0.05)] border-[3px] border-accent/10 relative overflow-hidden flex flex-col lg:flex-row">
            
            <!-- Left Panel: Information & Impact -->
            <div class="w-full lg:w-5/12 bg-navy p-10 md:p-14 text-white relative flex flex-col justify-between overflow-hidden">
                <!-- Dynamic Image Background -->
                <div id="campaign-bg-layer" class="absolute inset-0 bg-cover bg-center transition-opacity duration-700 opacity-0 mix-blend-luminosity"></div>
                <!-- Default SVG Background -->
                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23059669\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-navy via-navy/90 to-navy/70 pointer-events-none"></div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-accent opacity-10 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>

                <div class="relative z-10">
                    <i class="fa-solid fa-hand-holding-heart text-5xl text-accent mb-6 drop-shadow-[0_0_15px_rgba(5,150,105,0.4)]"></i>
                    <h2 class="text-3xl font-serif font-bold mb-4 leading-tight">Your Support <br><span class="text-gold">Transforms Lives</span></h2>
                    <p class="text-gray-300 font-light mb-8 leading-relaxed">
                        Every contribution helps us maintain the mosque, support community outreach, organize educational programs, and assist students in need.
                    </p>
                    
                    <ul class="space-y-5 mb-8 font-medium">
                        <li class="flex items-center gap-4 bg-white/5 p-3 rounded-xl border border-white/10">
                            <div class="w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center text-accent"><i class="fa-solid fa-lock"></i></div>
                            <span>100% Secure Payments</span>
                        </li>
                        <li class="flex items-center gap-4 bg-white/5 p-3 rounded-xl border border-white/10">
                            <div class="w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center text-accent"><i class="fa-solid fa-bullseye"></i></div>
                            <span>Direct Community Impact</span>
                        </li>
                        <li class="flex items-center gap-4 bg-white/5 p-3 rounded-xl border border-white/10">
                            <div class="w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center text-accent"><i class="fa-solid fa-scale-balanced"></i></div>
                            <span>Transparent Usage</span>
                        </li>
                    </ul>
                </div>

                <div class="relative z-10 mt-8 pt-8 border-t border-white/10">
                    <div class="flex gap-4 items-start">
                        <i class="fa-solid fa-quote-left text-2xl text-accent/50 pt-1"></i>
                        <p class="text-sm text-gray-400 italic leading-relaxed">
                            "The believer's shade on the Day of Resurrection will be their charity."<br>
                            <span class="text-accent font-bold mt-2 block">— Hadith (Tirmidhi)</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Form -->
            <div class="w-full lg:w-7/12 bg-white p-10 md:p-14 relative z-10">
                <form id="donation-form" class="space-y-7">
                    
                    <?php if($user_id): ?>
                        <div class="bg-emerald-50/50 p-5 rounded-2xl border border-accent/20 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-navy flex items-center justify-center text-gold mr-4 shadow-inner">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Logged In As</p>
                                    <p class="text-navy font-bold text-lg"><?php echo htmlspecialchars($email); ?></p>
                                    <input type="hidden" id="email" value="<?php echo htmlspecialchars($email); ?>">
                                </div>
                            </div>
                            <i class="fa-solid fa-check-circle text-accent text-2xl"></i>
                        </div>
                    <?php else: ?>
                        <div>
                            <label for="email" class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Email Address <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400"><i class="fa-solid fa-envelope"></i></div>
                                <input type="email" id="email" required class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl text-base focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition" placeholder="Enter your email">
                            </div>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label for="campaign" class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Select Campaign</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400"><i class="fa-solid fa-bullhorn"></i></div>
                            <select id="campaign" class="block w-full pl-11 pr-10 py-3.5 border border-gray-200 rounded-xl text-base text-navy font-medium focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition appearance-none cursor-pointer">
                                <option value="">General Fund (No specific campaign)</option>
                                <?php foreach($campaigns as $c): ?>
                                    <option value="<?php echo $c['id']; ?>" <?php echo ($selected_campaign && $selected_campaign['id'] == $c['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($c['title']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-accent">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                        
                        <!-- Campaign Preview Image -->
                        <div id="campaign-image-preview" class="hidden mt-4 rounded-xl overflow-hidden shadow-sm border border-gray-200 h-48">
                            <img id="campaign-image-el" src="" alt="Campaign Preview" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-3">Select Amount (NGN) <span class="text-red-500">*</span></label>
                        
                        <!-- Predefined Amount Buttons -->
                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4" id="amount-presets">
                            <button type="button" class="amount-btn bg-gray-50 border border-gray-200 rounded-xl py-3 font-bold text-navy hover:border-accent hover:text-accent hover:bg-emerald-50 transition" data-amount="2000">₦2K</button>
                            <button type="button" class="amount-btn bg-gray-50 border border-gray-200 rounded-xl py-3 font-bold text-navy hover:border-accent hover:text-accent hover:bg-emerald-50 transition" data-amount="5000">₦5K</button>
                            <button type="button" class="amount-btn bg-gray-50 border border-gray-200 rounded-xl py-3 font-bold text-navy hover:border-accent hover:text-accent hover:bg-emerald-50 transition" data-amount="10000">₦10K</button>
                            <button type="button" class="amount-btn bg-gray-50 border border-gray-200 rounded-xl py-3 font-bold text-navy hover:border-accent hover:text-accent hover:bg-emerald-50 transition" data-amount="50000">₦50K</button>
                        </div>

                        <!-- Custom Amount Input -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-navy font-bold text-lg">₦</span>
                            </div>
                            <input type="number" id="amount" min="100" required class="block w-full pl-10 pr-4 py-4 border border-gray-200 rounded-xl text-xl font-bold text-navy focus:ring-accent focus:border-accent bg-white transition shadow-inner" placeholder="Custom Amount">
                        </div>
                        <p class="text-xs text-gray-400 mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info text-accent"></i> Minimum donation is ₦100.</p>
                    </div>

                    <div class="pt-6 border-t border-gray-100">
                        <button type="button" onclick="payWithPaystack()" class="w-full bg-accent text-white px-8 py-5 rounded-xl hover:bg-forest transition duration-300 font-bold tracking-wider uppercase text-lg shadow-[0_10px_20px_rgba(5,150,105,0.2)] hover:shadow-[0_15px_30px_rgba(5,150,105,0.4)] transform hover:-translate-y-1 flex justify-center items-center gap-3 group">
                            Donate Securely <i class="fa-solid fa-lock text-gold group-hover:scale-110 transition"></i>
                        </button>
                        <div class="text-center mt-6 flex flex-col items-center justify-center space-y-2">
                            <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
                                <i class="fa-solid fa-shield-halved text-accent"></i> Guaranteed Safe & Secure Checkout
                            </div>
                            <img src="https://checkout.paystack.com/assets/images/secured-by-paystack-badge.png" alt="Secured by Paystack" class="h-6 opacity-70 hover:opacity-100 transition">
                        </div>
                    </div>
                </form>

                <!-- Direct Bank Transfer Section -->
                <div class="mt-12 pt-8 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 text-center">Alternative: Direct Transfer</h3>
                    
                    <div class="bg-navy rounded-2xl p-6 relative overflow-hidden shadow-lg border border-navy group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-accent opacity-10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                        
                        <div class="relative z-10 flex flex-col sm:flex-row items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0 border border-white/10 group-hover:scale-105 transition transform duration-300">
                                <i class="fa-solid fa-building-columns text-2xl text-gold"></i>
                            </div>
                            
                            <div class="flex-1 w-full text-center sm:text-left">
                                <div id="display_bank_name" class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1"><?php echo htmlspecialchars($bank_name); ?></div>
                                <div class="text-white font-serif text-2xl sm:text-3xl font-bold tracking-wider mb-1 cursor-pointer hover:text-gold transition flex items-center justify-center sm:justify-start gap-2" title="Click to copy" onclick="copyAccountNumber()">
                                    <span id="display_account_number"><?php echo htmlspecialchars($account_number); ?></span> <i class="fa-regular fa-copy text-sm opacity-50 hover:opacity-100"></i>
                                </div>
                                <div id="display_account_name" class="text-gray-300 text-sm font-medium"><?php echo htmlspecialchars($account_name); ?></div>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-3"><i class="fa-solid fa-circle-info text-accent"></i> After making a manual transfer, please contact the secretariat to have your donation recorded.</p>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
const globalBankDetails = <?php echo json_encode($global_bank); ?>;
const campaignBankDetails = <?php echo json_encode($campaigns_json); ?>;

function copyAccountNumber() {
    const accNum = document.getElementById('display_account_number').innerText;
    navigator.clipboard.writeText(accNum).then(() => alert('Account number copied!'));
}

document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const amountBtns = document.querySelectorAll('.amount-btn');

    amountBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active state from all
            amountBtns.forEach(b => {
                b.classList.remove('border-accent', 'text-accent', 'bg-emerald-50');
                b.classList.add('border-gray-200', 'text-navy', 'bg-gray-50');
            });
            
            // Add active state to clicked
            this.classList.remove('border-gray-200', 'text-navy', 'bg-gray-50');
            this.classList.add('border-accent', 'text-accent', 'bg-emerald-50');
            
            // Update input
            amountInput.value = this.getAttribute('data-amount');
        });
    });

    // Clear button states if manual input occurs
    amountInput.addEventListener('input', function() {
        amountBtns.forEach(b => {
            b.classList.remove('border-accent', 'text-accent', 'bg-emerald-50');
            b.classList.add('border-gray-200', 'text-navy', 'bg-gray-50');
        });
    });

    // Handle Campaign Dropdown Change to update Bank Details & Background
    const campaignSelect = document.getElementById('campaign');
    const displayBankName = document.getElementById('display_bank_name');
    const displayAccountName = document.getElementById('display_account_name');
    const displayAccountNumber = document.getElementById('display_account_number');
    const bgLayer = document.getElementById('campaign-bg-layer');
    const previewContainer = document.getElementById('campaign-image-preview');
    const previewImg = document.getElementById('campaign-image-el');

    campaignSelect.addEventListener('change', function() {
        const campaignId = this.value;
        let details = globalBankDetails;
        let bgImage = null;

        if (campaignId && campaignBankDetails[campaignId]) {
            details = campaignBankDetails[campaignId];
            if (campaignBankDetails[campaignId].image) {
                bgImage = 'assets/img/' + campaignBankDetails[campaignId].image;
            }
        }

        // Animate background image and show preview
        if (bgImage) {
            bgLayer.style.backgroundImage = `url('${bgImage}')`;
            bgLayer.style.opacity = 0.4;
            
            previewImg.src = bgImage;
            previewContainer.classList.remove('hidden');
        } else {
            bgLayer.style.opacity = 0;
            setTimeout(() => bgLayer.style.backgroundImage = 'none', 700);
            
            previewContainer.classList.add('hidden');
            previewImg.src = '';
        }

        // Animate the text change
        const elements = [displayBankName, displayAccountName, displayAccountNumber];
        elements.forEach(el => el.style.opacity = 0);
        
        setTimeout(() => {
            displayBankName.innerText = details.bank_name;
            displayAccountName.innerText = details.account_name;
            displayAccountNumber.innerText = details.account_number;
            
            elements.forEach(el => el.style.opacity = 1);
        }, 200);
    });
    
    // Set initial state on load if a campaign is pre-selected via URL
    if (campaignSelect.value) {
        campaignSelect.dispatchEvent(new Event('change'));
    }
});

function payWithPaystack() {
    let email = document.getElementById('email').value;
    let amount = document.getElementById('amount').value;
    let campaign = document.getElementById('campaign').value;

    if(!email || !amount || amount < 100) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Input',
            text: 'Please enter a valid email and amount (minimum NGN 100).',
            confirmButtonColor: '#0f3b2e'
        });
        return;
    }

    let paystackPublicKey = '<?php echo htmlspecialchars($paystack_public_key); ?>';

    let handler = PaystackPop.setup({
        key: paystackPublicKey,
        email: email,
        amount: amount * 100, // Paystack uses kobo
        currency: 'NGN',
        metadata: {
            custom_fields: [
                {
                    display_name: "Campaign ID",
                    variable_name: "campaign_id",
                    value: campaign
                }
            ]
        },
        callback: function(response) {
            let reference = response.reference;
            // Verify payment on the backend
            $.post(BASE_URL + '/ajax/verify_payment.php', {
                reference: reference,
                campaign_id: campaign,
                amount: amount,
                email: email
            }, function(res) {
                if(res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thank You!',
                        text: 'Your donation was successful. May Allah reward you.',
                        confirmButtonColor: '#d4af37'
                    }).then(() => {
                        window.location.href = BASE_URL + '/index.php';
                    });
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json').fail(function() {
                Swal.fire('Error', 'Verification failed.', 'error');
            });
        },
        onClose: function() {
            Swal.fire({
                title: 'Cancelled',
                text: 'Transaction was not completed.',
                icon: 'info',
                confirmButtonColor: '#0f3b2e'
            });
        }
    });

    handler.openIframe();
}
</script>

<?php include 'includes/footer.php'; ?>
