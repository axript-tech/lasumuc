<?php
require_once 'includes/db.php';
include 'includes/header.php';

if(isset($_SESSION['user_id'])) {
    header("Location: " . $base_url . "/index.php");
    exit;
}
?>
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-gray-50">
    <!-- Decorative Background Shapes -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] bg-accent opacity-5 rounded-full blur-[100px]"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] bg-navy opacity-5 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-4xl w-full bg-white rounded-[2.5rem] shadow-[0_20px_60px_rgba(0,0,0,0.05)] border-[3px] border-accent/10 relative z-10 overflow-hidden flex flex-col md:flex-row">
        
        <!-- Left Side: Branding/Welcome -->
        <div class="w-full md:w-5/12 bg-navy p-10 flex flex-col justify-center relative overflow-hidden text-center md:text-left">
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%23059669\\' fill-opacity=\\'1\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            
            <div class="relative z-10">
                <i class="fa-solid fa-moon text-5xl text-accent mb-6 drop-shadow-[0_0_15px_rgba(5,150,105,0.4)]"></i>
                <h2 class="text-3xl font-serif font-bold text-white mb-4">Welcome Back</h2>
                <p class="text-gray-300 font-light leading-relaxed text-sm">Sign in to your LASUMUC account to manage your profile, view donations, and connect with the community.</p>
                
                <div class="mt-8 pt-8 border-t border-white/20 hidden md:block">
                    <p class="text-xs text-gray-400">Don't have an account?</p>
                    <a href="<?php echo $base_url; ?>/register.php" class="inline-block mt-3 text-sm font-bold text-accent hover:text-white transition uppercase tracking-wider">Create Account <i class="fa-solid fa-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="w-full md:w-7/12 p-8 md:p-12 bg-white flex flex-col justify-center">
            <div class="text-center md:text-left mb-8 md:hidden">
                <h2 class="text-2xl font-bold text-navy">Welcome Back</h2>
                <p class="text-sm text-gray-500 mt-2">Don't have an account? <a href="<?php echo $base_url; ?>/register.php" class="text-accent font-bold hover:underline">Create Account</a></p>
            </div>

            <form action="<?php echo $base_url; ?>/ajax/auth_login.php" method="POST" class="ajax-form space-y-6">
                <div>
                    <label for="email" class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-regular fa-envelope text-gray-400"></i></div>
                        <input type="email" id="email" name="email" required class="block w-full pl-11 pr-3 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-lock text-gray-400"></i></div>
                        <input type="password" id="password" name="password" required class="block w-full pl-11 pr-3 py-3 border border-gray-200 rounded-xl text-sm focus:ring-accent focus:border-accent bg-gray-50 hover:bg-white transition">
                    </div>
                    <div class="flex justify-end mt-2">
                        <a href="#" class="text-xs text-gray-400 hover:text-accent transition">Forgot Password?</a>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex items-center justify-center py-4 px-4 border border-transparent rounded-xl shadow-[0_4px_15px_rgba(5,150,105,0.2)] text-sm font-bold text-white bg-accent hover:bg-forest transition duration-500 hover:shadow-[0_10px_25px_rgba(5,150,105,0.4)] transform hover:-translate-y-1 uppercase tracking-widest">
                        Sign In <i class="fa-solid fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
