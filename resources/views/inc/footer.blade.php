<footer class="bg-[#1A1E2D] text-white">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <!-- Column 1: About -->
            <div class="space-y-4">
                <img src="{{ asset('assets/images/Sun4u.png') }}" alt="{{ config('app.name') }}" class="h-12 mb-4">
                <p class="text-gray-400 text-sm leading-relaxed">We are a real estate company that helps you find your dream home with the best quality and service.</p>
                <div class="flex space-x-4 pt-2">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4 uppercase tracking-wider">Quick Links</h3>
                <ul class="space-y-3">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Home</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">About Us</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Properties</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Agents</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Contact Us</a></li>
                </ul>
            </div>

            <!-- Column 3: Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4 uppercase tracking-wider">Contact Info</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-gray-400"></i>
                        <span class="text-gray-400 text-sm">123 Real Estate, Yangon, Myanmar</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt mr-3 text-gray-400"></i>
                        <span class="text-gray-400 text-sm">+95 9 123 456 789</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-gray-400"></i>
                        <span class="text-gray-400 text-sm">info@mmhouse.com</span>
                    </li>
                </ul>
            </div>

            <!-- Column 4: Newsletter -->
            <div>
                <h3 class="text-lg font-semibold mb-4 uppercase tracking-wider">Newsletter</h3>
                <p class="text-gray-400 text-sm mb-4">Subscribe to our newsletter for the latest updates</p>
                <form class="flex">
                    <input type="email" placeholder="Your email" class="px-4 py-2 bg-[#2A2F45] border border-[#3A3F55] text-white text-sm rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500 w-full" required>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-[#2A2F45] pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500 mb-4 md:mb-0">
                    {{ __("Copyright ") . date('Y') . ' ' . config('app.name') . '. ' . __('All Rights Reserved') }}
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">{{ __('Privacy Policy') }}</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">{{ __('Terms of Service') }}</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">{{ __('Sitemap') }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>