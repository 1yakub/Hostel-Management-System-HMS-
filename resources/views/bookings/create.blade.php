<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('New Booking') }}
            </h2>
            <a href="{{ route('bookings.index') }}"
                class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                Back to Bookings
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Guest Selection -->
                        <div>
                            <x-input-label for="guest_ids" value="Guests" />
                            <select id="guest_ids" name="guest_ids[]" multiple
                                class="mt-1 block w-full border-luxury-200 dark:border-luxury-700 bg-white/50 dark:bg-gray-900/50 text-luxury-900 dark:text-luxury-100 focus:border-luxury-500 dark:focus:border-luxury-600 focus:ring-luxury-500 dark:focus:ring-luxury-600 rounded-lg shadow-sm min-h-[120px]">
                                @foreach ($guests as $guest)
                                    <option value="{{ $guest->id }}"
                                        {{ in_array($guest->id, old('guest_ids', [])) ? 'selected' : '' }}
                                        data-name="{{ $guest->name }}" data-id-number="{{ $guest->id_number }}">
                                        {{ $guest->name }} ({{ $guest->id_number }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('guest_ids')" class="mt-2" />
                            <x-input-error :messages="$errors->get('guest_ids.*')" class="mt-2" />
                            <div class="mt-2">
                                <a href="{{ route('guests.create') }}"
                                    class="text-sm text-luxury-600 dark:text-luxury-400 hover:text-luxury-700 dark:hover:text-luxury-300">
                                    + Register new guest
                                </a>
                            </div>
                        </div>

                        <!-- Selected Guests Preview -->
                        <div id="selected-guests-preview" class="space-y-2 hidden">
                            <h4 class="text-sm font-medium text-luxury-700 dark:text-luxury-300">Selected Guests:</h4>
                            <div id="selected-guests-list" class="space-y-2">
                            </div>
                        </div>

                        <!-- Room Selection -->
                        <div>
                            <x-input-label for="room_id" value="Room" />
                            <select id="room_id" name="room_id"
                                class="mt-1 block w-full border-luxury-200 dark:border-luxury-700 bg-white/50 dark:bg-gray-900/50 text-luxury-900 dark:text-luxury-100 focus:border-luxury-500 dark:focus:border-luxury-600 focus:ring-luxury-500 dark:focus:ring-luxury-600 rounded-lg shadow-sm">
                                <option value="">Select a room</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}"
                                        {{ old('room_id') == $room->id ? 'selected' : '' }}
                                        data-price="{{ $room->price_per_night }}">
                                        Room {{ $room->room_number }} ({{ $room->capacity }} persons) -
                                        ${{ number_format($room->price_per_night, 2) }}/night
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                        </div>

                        <!-- Check-in Date -->
                        <div>
                            <x-input-label for="check_in_date" value="Check-in Date" />
                            <x-text-input id="check_in_date" name="check_in_date" type="date"
                                class="mt-1 block w-full" :value="old('check_in_date')" required min="{{ date('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('check_in_date')" class="mt-2" />
                        </div>

                        <!-- Check-out Date -->
                        <div>
                            <x-input-label for="check_out_date" value="Check-out Date" />
                            <x-text-input id="check_out_date" name="check_out_date" type="date"
                                class="mt-1 block w-full" :value="old('check_out_date')" required min="{{ date('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('check_out_date')" class="mt-2" />
                        </div>

                        <!-- Total Amount Preview -->
                        <div
                            class="bg-luxury-50 dark:bg-luxury-900/50 p-4 rounded-lg border border-luxury-200 dark:border-luxury-800">
                            <div class="flex justify-between items-center">
                                <span class="text-luxury-800 dark:text-luxury-200">Total Amount:</span>
                                <span class="text-2xl font-bold text-luxury-600 dark:text-luxury-400"
                                    id="total-amount">$0.00</span>
                            </div>
                            <p class="text-sm text-luxury-600/70 dark:text-luxury-400/70 mt-1" id="nights-count">
                                0 nights
                            </p>
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Create Booking') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function calculateTotal() {
                const checkIn = new Date(document.getElementById('check_in_date').value);
                const checkOut = new Date(document.getElementById('check_out_date').value);
                const roomSelect = document.getElementById('room_id');
                const selectedOption = roomSelect.options[roomSelect.selectedIndex];
                const guestsSelect = document.getElementById('guest_ids');
                const selectedGuests = guestsSelect.selectedOptions.length;

                if (checkIn && checkOut && selectedOption && selectedOption.value) {
                    const nights = Math.max(1, Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24)));
                    const pricePerNight = parseFloat(selectedOption.dataset.price || 0);
                    const total = nights * pricePerNight;

                    document.getElementById('total-amount').textContent = `$${total.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })}`;
                    document.getElementById('nights-count').textContent =
                        `${nights} night${nights !== 1 ? 's' : ''} • ${selectedGuests} guest${selectedGuests !== 1 ? 's' : ''}`;
                } else {
                    document.getElementById('total-amount').textContent = '$0.00';
                    document.getElementById('nights-count').textContent =
                        `0 nights • ${selectedGuests} guest${selectedGuests !== 1 ? 's' : ''}`;
                }
            }

            function updateGuestPreview() {
                const guestSelect = document.getElementById('guest_ids');
                const previewContainer = document.getElementById('selected-guests-preview');
                const previewList = document.getElementById('selected-guests-list');
                const selectedOptions = Array.from(guestSelect.selectedOptions);

                if (selectedOptions.length > 0) {
                    previewContainer.classList.remove('hidden');
                    previewList.innerHTML = selectedOptions.map(option => `
                        <div class="flex items-center justify-between p-2 bg-luxury-50 dark:bg-luxury-900/50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-luxury-800 dark:text-luxury-200">${option.dataset.name}</p>
                                <p class="text-xs text-luxury-600/70 dark:text-luxury-400/70">${option.dataset.idNumber}</p>
                            </div>
                            ${selectedOptions.indexOf(option) === 0 ?
                                '<span class="text-xs font-medium text-luxury-600 dark:text-luxury-400">Primary Guest</span>' :
                                '<span class="text-xs text-luxury-600/70 dark:text-luxury-400/70">Additional Guest</span>'
                            }
                        </div>
                    `).join('');
                } else {
                    previewContainer.classList.add('hidden');
                }
                calculateTotal();
            }

            // Initialize everything when the DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                const elements = {
                    checkIn: document.getElementById('check_in_date'),
                    checkOut: document.getElementById('check_out_date'),
                    room: document.getElementById('room_id'),
                    guests: document.getElementById('guest_ids')
                };

                // Add multiple event listeners to each element
                ['change', 'input', 'keyup', 'mouseup'].forEach(eventType => {
                    elements.checkIn.addEventListener(eventType, calculateTotal);
                    elements.checkOut.addEventListener(eventType, calculateTotal);
                    elements.room.addEventListener(eventType, calculateTotal);
                    elements.guests.addEventListener(eventType, function() {
                        updateGuestPreview();
                        calculateTotal();
                    });
                });

                // Update checkout minimum date when check-in changes
                elements.checkIn.addEventListener('input', function() {
                    const checkInDate = this.value;
                    elements.checkOut.min = checkInDate;

                    if (elements.checkOut.value && elements.checkOut.value < checkInDate) {
                        elements.checkOut.value = checkInDate;
                    }
                    calculateTotal();
                });

                // Monitor select box using MutationObserver
                const observer = new MutationObserver(calculateTotal);
                observer.observe(elements.guests, {
                    attributes: true,
                    childList: true,
                    subtree: true
                });
                observer.observe(elements.room, {
                    attributes: true,
                    childList: true,
                    subtree: true
                });

                // Initial calculations
                updateGuestPreview();
                calculateTotal();
            });
        </script>
    @endpush
</x-app-layout>
