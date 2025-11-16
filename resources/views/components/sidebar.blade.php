<!-- FILE: resources/views/components/sidebar.blade.php -->
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
        <!-- Sidebar component -->
        <div class="flex flex-col h-0 flex-1 bg-white border-r border-gray-200">
            <!-- Logo -->
            <div class="flex items-center h-16 flex-shrink-0 px-4 border-b border-gray-200">
                <img class="h-8 w-auto" src="{{ asset('images/knott-logo.png') }}" alt="Knott">
            </div>
            
            <!-- Navigation -->
            <div class="flex-1 flex flex-col overflow-y-auto">
                <nav class="flex-1 px-2 py-4 space-y-1">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <!-- Admin Navigation -->
                            <a href="{{ route('admin.dashboard') }}" 
                               class="{{ request()->routeIs('admin.dashboard') ? 'bg-purple-50 border-r-2 border-purple-600 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                </svg>
                                Dashboard
                            </a>
                            
                            <a href="#" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Vendor Approvals
                                <span class="ml-auto bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">5</span>
                            </a>
                            
                            <a href="#" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Analytics
                            </a>
                            
                            <a href="#" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                Revenue
                            </a>
                            
                        @elseif(auth()->user()->role === 'vendor')
                            <!-- Vendor Navigation -->
                            <a href="{{ route('vendor.dashboard') }}" 
                               class="{{ request()->routeIs('vendor.dashboard') ? 'bg-purple-50 border-r-2 border-purple-600 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                </svg>
                                Dashboard
                            </a>
                            
                            <a href="#" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                            
                            <a href="#" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Services
                            </a>
                            
                            <a href="#" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v8a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Quote Requests
                                <span class="ml-auto bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full">3</span>
                            </a>
                            
                            <a href="#" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6M5 21V9a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2z" />
                                </svg>
                                Bookings
                            </a>
                            
                        @elseif(auth()->user()->role === 'couple')
                            <!-- Couple Navigation -->
                            <a href="{{ route('couple.dashboard') }}" 
                               class="{{ request()->routeIs('couple.dashboard') ? 'bg-purple-50 border-r-2 border-purple-600 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                </svg>
                                Dashboard
                            </a>
                            
                            <a href="{{ route('couple.vendors.index') }}" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Vendor Directory
                            </a>
                            
                            <a href="{{ route('couple.budget.index') }}" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                Budget
                            </a>
                            
                            <a href="{{ route('couple.guests.index') }}" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Guest List
                            </a>
                            
                            <a href="{{ route('couple.todos.index') }}" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                To-Do List
                            </a>
                            
<a href="{{ route('couple.quotes.index') }}" class="{{ request()->routeIs('couple.quotes.index') ? 'bg-purple-50 border-r-2 border-purple-600 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Quote Requests
                            </a>
                            
<a href="{{ route('couple.compare-quotes') }}" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Compare Quotes
                            </a>
                            
                            <a href="{{ route('couple.profile.edit') }}" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                            
                        @elseif(auth()->user()->role === 'guest')
                            <!-- Guest Navigation -->
                            <a href="{{ route('guest.dashboard') }}" 
                               class="{{ request()->routeIs('guest.dashboard') ? 'bg-purple-50 border-r-2 border-purple-600 text-purple-700' : 'text-gray-600 hover:bg-gray-50' }} group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                </svg>
                                Dashboard
                            </a>
                            
                            <a href="#" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V12a9 9 0 1118 0v3.546z" />
                                </svg>
                                Gift Wells
                            </a>
                            
                            <a href="#" class="text-gray-600 hover:bg-gray-50 group flex items-center px-2 py-2 text-sm font-medium rounded-l-lg transition-colors">
                                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                My Contributions
                            </a>
                        @endif
                    @endauth
                </nav>
                
                <!-- Bottom section -->
                <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <span class="text-sm font-medium text-purple-600">
                                    {{ strtoupper(substr(auth()->user()->name ?? '', 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role ?? 'Guest' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile sidebar (hidden by default) -->
<div class="md:hidden">
    <div class="fixed inset-0 z-40 flex" id="mobile-menu" style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" onclick="document.getElementById('mobile-menu').style.display='none'"></div>
        
        <!-- Sidebar -->
        <div class="relative flex flex-col flex-1 w-full max-w-xs bg-white">
            <!-- Close button -->
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button onclick="document.getElementById('mobile-menu').style.display='none'" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Mobile menu content (same as desktop) -->
            <div class="flex-shrink-0 flex items-center px-4 py-4 border-b border-gray-200">
                <img class="h-8 w-auto" src="{{ asset('images/knott-logo.png') }}" alt="Knott">
            </div>
            
            <div class="mt-5 flex-1 h-0 overflow-y-auto">
                <!-- Mobile navigation items would go here - same structure as desktop -->
            </div>
        </div>
    </div>
</div>
