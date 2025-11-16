// resources/views/negotiator/dashboard.blade.php
<x-app-layout>
    <div class="py-6">
        <!-- Header Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Negotiations</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $negotiator->total_negotiations }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Average Rating</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($negotiator->rating, 1) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar & Bookings -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Calendar -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">My Calendar</h3>
                </div>
                <div class="p-6">
                    <div id="calendar"></div>
                </div>
            </div>
            
            <!-- Recent Bookings -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Bookings</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentBookings as $booking)
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $booking->couple->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $booking->scheduled_date->format('M j, Y \a\t g:i A') }}</p>
                                <p class="text-sm text-gray-500">{{ $booking->meeting_type === 'in_person' ? 'In Person' : 'Video Call' }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center">
                        <p class="text-gray-500">No recent bookings</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($bookings->map(function($booking) {
                    return [
                        'id' => $booking->id,
                        'title' => $booking->couple->name,
                        'start' => $booking->scheduled_date->toISOString(),
                        'color' => $booking->status === 'confirmed' ? '#10B981' : '#F59E0B'
                    ];
                }))
            });
            calendar.render();
        });
    </script>
    @endpush
</x-app-layout>