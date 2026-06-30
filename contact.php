<?php
require_once 'includes/db.php';
include 'includes/header.php';
?>

<!-- Premium Header -->
<div class="relative bg-navy overflow-hidden py-24 text-center">
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23d4af37\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    <div class="absolute bottom-0 left-0 -ml-40 -mb-40 w-96 h-96 bg-accent rounded-full opacity-20 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="text-5xl font-serif font-extrabold text-white sm:text-6xl tracking-tight mb-6">Contact <span class="text-accent-gradient">Us</span></h1>
        <div class="w-24 h-1 bg-accent mx-auto mb-6 rounded-full opacity-70"></div>
        <p class="text-xl text-gray-300 max-w-2xl mx-auto font-light leading-relaxed">Have questions or want to learn more? We'd love to hear from you.</p>
    </div>
</div>

<div class="py-24 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-8">
            
            <!-- Contact Info -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-navy rounded-2xl p-10 shadow-xl border border-navy text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-accent opacity-10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                    
                    <h2 class="text-3xl font-serif font-bold mb-8">Get in Touch</h2>
                    
                    <div class="space-y-8 relative z-10">
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full bg-accent/20 flex items-center justify-center flex-shrink-0 border border-accent/30">
                                <i class="fa-solid fa-location-dot text-accent text-lg"></i>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-sm font-bold text-accent uppercase tracking-wider mb-1">Address</h3>
                                <p class="text-gray-300 font-light leading-relaxed">Lagos State University, Ojo<br>Lagos, Nigeria</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full bg-accent/20 flex items-center justify-center flex-shrink-0 border border-accent/30">
                                <i class="fa-solid fa-phone text-accent text-lg"></i>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-sm font-bold text-accent uppercase tracking-wider mb-1">Phone</h3>
                                <p class="text-gray-300 font-light leading-relaxed">+234 (0) 123 456 7890</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full bg-accent/20 flex items-center justify-center flex-shrink-0 border border-accent/30">
                                <i class="fa-solid fa-envelope text-accent text-lg"></i>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-sm font-bold text-accent uppercase tracking-wider mb-1">Email</h3>
                                <p class="text-gray-300 font-light leading-relaxed">info@lasumuslimcommunity.org</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-10 h-full flex flex-col justify-center">
                    <h2 class="text-sm text-accent font-bold tracking-widest uppercase mb-2">Send Inquiry</h2>
                    <h3 class="text-3xl font-serif font-bold text-navy mb-8">Drop us a Message</h3>
                    
                    <form action="<?php echo $base_url; ?>/ajax/contact_submit.php" method="POST" class="ajax-form space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Your Name</label>
                                <input type="text" name="name" required class="w-full bg-slate-50 border border-gray-200 rounded-lg p-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                                <input type="email" name="email" required class="w-full bg-slate-50 border border-gray-200 rounded-lg p-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Message</label>
                            <textarea name="message" rows="5" required class="w-full bg-slate-50 border border-gray-200 rounded-lg p-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition resize-none"></textarea>
                        </div>
                        <button type="submit" class="bg-navy text-white px-8 py-4 rounded-lg hover:bg-forest transition duration-300 font-bold tracking-wide uppercase text-sm shadow-md inline-flex items-center">
                            Send Message <i class="fa-solid fa-paper-plane ml-3 text-accent"></i>
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
