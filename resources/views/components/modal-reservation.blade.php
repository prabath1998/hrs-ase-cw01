<!-- Reservation Details Modal -->
<div x-data="{ open: $persist(false).as('showReservationDetails') }" x-show="open" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
    @keydown.escape.window="open = false">
    <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
        <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div>
            <h2 class="text-2xl font-bold mb-1">Reservation Details</h2>
            <p class="text-gray-600 mb-6">Complete information for reservation <span
                    x-text="selectedReservation?.id"></span></p>
        </div>
        <template x-if="selectedReservation">
            <div class="space-y-6">
                <!-- Hotel and Room Information -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <img :src="selectedReservation.roomImage || '/placeholder.svg'"
                            :alt="selectedReservation.roomName" width="400" height="250"
                            class="rounded-lg object-cover w-full" />
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-2xl font-bold" x-text="selectedReservation.roomName"></h3>
                            <p class="text-lg text-gray-600" x-text="selectedReservation.hotelName"></p>
                            <div class="mt-2">
                                <!-- Status Badge -->
                                <template x-if="selectedReservation.status === 'confirmed'">
                                    <span
                                        class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2l4-4"></path>
                                            <circle cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="2" fill="none"></circle>
                                        </svg>
                                        Confirmed
                                    </span>
                                </template>
                                <template x-if="selectedReservation.status === 'completed'">
                                    <span
                                        class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2l4-4"></path>
                                            <circle cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="2" fill="none"></circle>
                                        </svg>
                                        Completed
                                    </span>
                                </template>
                                <template x-if="selectedReservation.status === 'cancelled'">
                                    <span
                                        class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3"></path>
                                            <circle cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="2" fill="none"></circle>
                                        </svg>
                                        Cancelled
                                    </span>
                                </template>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Check-in</p>
                                <p class="font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"
                                            stroke="currentColor" fill="none" />
                                        <path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" />
                                    </svg>
                                    <span x-text="formatDate(selectedReservation.checkIn)"></span>
                                </p>
                                <p class="text-xs text-gray-500">After 3:00 PM</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Check-out</p>
                                <p class="font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"
                                            stroke="currentColor" fill="none" />
                                        <path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" />
                                    </svg>
                                    <span x-text="formatDate(selectedReservation.checkOut)"></span>
                                </p>
                                <p class="text-xs text-gray-500">Before 11:00 AM</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Guests</p>
                                <p class="font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M17 21v-2a4 4 0 0 0-3-3.87M9 21v-2a4 4 0 0 1 3-3.87M12 7a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"
                                            stroke="currentColor" stroke-width="2" fill="none" />
                                    </svg>
                                    <span x-text="selectedReservation.guests"></span> guests
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-500">Nights</p>
                                <p class="font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M3 7v10a4 4 0 0 0 4 4h10a4 4 0 0 0 4-4V7" stroke="currentColor"
                                            stroke-width="2" fill="none" />
                                        <path d="M16 3v4M8 3v4M3 11h18" stroke="currentColor" stroke-width="2" />
                                    </svg>
                                    <span x-text="selectedReservation.nights"></span> nights
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Amenities -->
                <div>
                    <h4 class="font-semibold mb-3">Room Amenities</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="flex items-center space-x-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M2 8.5A6.5 6.5 0 0 1 8.5 2h7A6.5 6.5 0 0 1 22 8.5v7A6.5 6.5 0 0 1 15.5 22h-7A6.5 6.5 0 0 1 2 15.5v-7z"
                                    stroke="currentColor" stroke-width="2" fill="none" />
                                <path d="M8 12h8M12 8v8" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <span>Free WiFi</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M3 17v-2a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v2" stroke="currentColor"
                                    stroke-width="2" fill="none" />
                                <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"
                                    fill="none" />
                            </svg>
                            <span>Free Parking</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M8 17v-1a4 4 0 0 1 8 0v1" stroke="currentColor" stroke-width="2"
                                    fill="none" />
                                <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"
                                    fill="none" />
                            </svg>
                            <span>Coffee Maker</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M4 21v-7a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v7" stroke="currentColor"
                                    stroke-width="2" fill="none" />
                                <path d="M16 3v4M8 3v4M3 11h18" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <span>Room Service</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor"
                                    stroke-width="2" fill="none" />
                                <path d="M6 10v4M18 10v4" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <span>Fitness Center</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M2 20h20M2 16h20M2 12h20M2 8h20M2 4h20" stroke="currentColor"
                                    stroke-width="2" />
                            </svg>
                            <span>Swimming Pool</span>
                        </div>
                    </div>
                </div>
                <!-- Pricing Breakdown -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold mb-3">Pricing Breakdown</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Room rate (<span x-text="selectedReservation.nights"></span> nights)</span>
                            <span x-text="Math.round(selectedReservation.total * 0.85)"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Taxes & fees</span>
                            <span x-text="Math.round(selectedReservation.total * 0.15)"></span>
                        </div>
                        <div class="border-t my-2"></div>
                        <div class="flex justify-between font-semibold">
                            <span>Total</span>
                            <span x-text="selectedReservation.total"></span>
                        </div>
                    </div>
                </div>
                <!-- Cancellation Policy -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-semibold mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                                fill="none" />
                            <path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" />
                        </svg>
                        Cancellation Policy
                    </h4>
                    <p class="text-sm text-blue-800">
                        Free cancellation until 24 hours before check-in. After that, you will be charged for one night.
                    </p>
                </div>
                <!-- Action Buttons -->
                <div class="flex space-x-3 pt-4">
                    <template x-if="selectedReservation.status === 'confirmed'">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded flex items-center"
                            @click="open = false; $dispatch('open-modify', selectedReservation)">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 20h9" stroke="currentColor" stroke-width="2" />
                                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"
                                    stroke="currentColor" stroke-width="2" />
                            </svg>
                            Modify Reservation
                        </button>
                    </template>
                    <button class="border border-gray-300 px-4 py-2 rounded flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke="currentColor"
                                stroke-width="2" />
                            <polyline points="7 10 12 15 17 10" stroke="currentColor" stroke-width="2" />
                        </svg>
                        Download Receipt
                    </button>
                    <button class="border border-gray-300 px-4 py-2 rounded" @click="open = false">Close</button>
                </div>
            </div>
        </template>
    </div>
</div>

<!-- Modify Reservation Modal -->
<div x-data="{ open: $persist(false).as('showModifyReservation') }" x-show="open" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
    @keydown.escape.window="open = false" @open-modify.window="selectedReservation = $event.detail; open = true">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
        <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div>
            <h2 class="text-2xl font-bold mb-1">Modify Reservation</h2>
            <p class="text-gray-600 mb-6">Update your reservation details for <span
                    x-text="selectedReservation?.hotelName"></span></p>
        </div>
        <template x-if="selectedReservation">
            <div class="space-y-6">
                <div class="flex items-center bg-blue-50 p-3 rounded">
                    <svg class="h-4 w-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                            fill="none" />
                        <path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" />
                    </svg>
                    <span class="text-blue-800 text-sm">Changes may affect your room rate. You'll see the updated
                        pricing before confirming.</span>
                </div>
                <!-- Current Reservation Info -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold mb-2">Current Reservation</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Check-in</p>
                            <p class="font-medium" x-text="formatDate(selectedReservation.checkIn)"></p>
                        </div>
                        <div>
                            <p class="text-gray-500">Check-out</p>
                            <p class="font-medium" x-text="formatDate(selectedReservation.checkOut)"></p>
                        </div>
                        <div>
                            <p class="text-gray-500">Guests</p>
                            <p class="font-medium"><span x-text="selectedReservation.guests"></span> guests</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Total</p>
                            <p class="font-medium">$<span x-text="selectedReservation.total"></span></p>
                        </div>
                    </div>
                </div>
                <!-- Modification Form -->
                <form class="space-y-4" @submit.prevent="handleSaveModification">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="newCheckIn" class="block text-sm font-medium mb-1">New Check-in Date</label>
                            <input id="newCheckIn" type="date" x-model="modifyFormData.checkIn"
                                :min="formatDateInput(new Date())" class="w-full border rounded px-2 py-1" />
                        </div>
                        <div>
                            <label for="newCheckOut" class="block text-sm font-medium mb-1">New Check-out Date</label>
                            <input id="newCheckOut" type="date" x-model="modifyFormData.checkOut"
                                :min="modifyFormData.checkIn" class="w-full border rounded px-2 py-1" />
                        </div>
                    </div>
                    <div>
                        <label for="newGuests" class="block text-sm font-medium mb-1">Number of Guests</label>
                        <select id="newGuests" x-model.number="modifyFormData.guests"
                            class="w-full border rounded px-2 py-1">
                            <option value="1">1 Guest</option>
                            <option value="2">2 Guests</option>
                            <option value="3">3 Guests</option>
                            <option value="4">4 Guests</option>
                        </select>
                    </div>
                    <!-- Add-ons -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium">Additional Services</label>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="addBreakfast" x-model="modifyFormData.addBreakfast"
                                    class="rounded" />
                                <label for="addBreakfast" class="text-sm">Add breakfast (+$25/person/day)</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="earlyCheckIn" x-model="modifyFormData.earlyCheckIn"
                                    class="rounded" />
                                <label for="earlyCheckIn" class="text-sm">Early check-in (+$30)</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="lateCheckOut" x-model="modifyFormData.lateCheckOut"
                                    class="rounded" />
                                <label for="lateCheckOut" class="text-sm">Late check-out (+$30)</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="specialRequests" class="block text-sm font-medium mb-1">Special Requests</label>
                        <textarea id="specialRequests" x-model="modifyFormData.specialRequests"
                            placeholder="Any special requests or requirements..." rows="3" class="w-full border rounded px-2 py-1"></textarea>
                    </div>
                    <!-- Updated Pricing -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Updated Pricing</h4>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span>Room rate (3 nights)</span>
                                <span>$747</span>
                            </div>
                            <template x-if="modifyFormData.addBreakfast">
                                <div class="flex justify-between">
                                    <span>Breakfast</span>
                                    <span>$150</span>
                                </div>
                            </template>
                            <template x-if="modifyFormData.earlyCheckIn">
                                <div class="flex justify-between">
                                    <span>Early check-in</span>
                                    <span>$30</span>
                                </div>
                            </template>
                            <template x-if="modifyFormData.lateCheckOut">
                                <div class="flex justify-between">
                                    <span>Late check-out</span>
                                    <span>$30</span>
                                </div>
                            </template>
                            <div class="flex justify-between">
                                <span>Taxes & fees</span>
                                <span>$136</span>
                            </div>
                            <div class="border-t my-2"></div>
                            <div class="flex justify-between font-semibold">
                                <span>New Total</span>
                                <span>$1,093</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-600">
                                <span>Difference from original</span>
                                <span class="text-red-600">+$46</span>
                            </div>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex space-x-3 pt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
                        <button type="button" class="border border-gray-300 px-4 py-2 rounded"
                            @click="open = false">Cancel</button>
                    </div>
                </form>
            </div>
        </template>
    </div>
</div>

<!-- Payment Methods Management Modal -->
<div x-data="{ open: $persist(false).as('showPaymentMethods'), showAddPayment: false }" x-show="open" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
    @keydown.escape.window="open = false">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
        <button @click="open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div>
            <h2 class="text-2xl font-bold mb-1">Manage Payment Methods</h2>
            <p class="text-gray-600 mb-6">Add, edit, or remove your saved payment methods</p>
        </div>
        <div class="space-y-6">
            <!-- Current Payment Methods -->
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <h4 class="font-semibold">Saved Payment Methods</h4>
                    <button class="bg-blue-600 text-white px-3 py-1 rounded flex items-center text-sm"
                        @click="showAddPayment = true">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="2" />
                        </svg>
                        Add New
                    </button>
                </div>
                <template x-for="method in paymentMethods" :key="method.id">
                    <div class="flex items-center justify-between p-4 border rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div
                                :class="method.type === 'visa' ? 'p-2 rounded bg-blue-100' : 'p-2 rounded bg-red-100'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="2" y="7" width="20" height="10" rx="2"
                                        stroke="currentColor" stroke-width="2" fill="none" />
                                    <path d="M2 10h20" stroke="currentColor" stroke-width="2" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium"
                                    x-text="`${method.type === 'visa' ? 'Visa' : 'Mastercard'} ****${method.last4}`">
                                </p>
                                <p class="text-sm text-gray-600">
                                    Expires <span x-text="String(method.expiryMonth).padStart(2, '0')"></span>/<span
                                        x-text="method.expiryYear"></span>
                                </p>
                                <p class="text-xs text-gray-500" x-text="method.cardholderName"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <template x-if="method.isDefault">
                                <span
                                    class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">Default</span>
                            </template>
                            <template x-if="!method.isDefault">
                                <button class="text-blue-600 text-xs px-2 py-1"
                                    @click="handleSetDefaultPayment(method.id)">Set Default</button>
                            </template>
                            <button class="text-red-600 text-xs px-2 py-1"
                                @click="handleDeletePaymentMethod(method.id)" :disabled="method.isDefault">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 6h18M9 6v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V6" stroke="currentColor"
                                        stroke-width="2" />
                                    <path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
            <!-- Add New Payment Method Form -->
            <div x-show="showAddPayment" class="border-t pt-6 space-y-4" x-cloak>
                <h4 class="font-semibold">Add New Payment Method</h4>
                <div>
                    <label for="cardType" class="block text-sm font-medium mb-1">Card Type</label>
                    <select id="cardType" x-model="newPaymentMethod.type" class="w-full border rounded px-2 py-1">
                        <option value="visa">Visa</option>
                        <option value="mastercard">Mastercard</option>
                        <option value="amex">American Express</option>
                    </select>
                </div>
                <div>
                    <label for="cardholderName" class="block text-sm font-medium mb-1">Cardholder Name</label>
                    <input id="cardholderName" x-model="newPaymentMethod.cardholderName" placeholder="John Doe"
                        class="w-full border rounded px-2 py-1" />
                </div>
                <div>
                    <label for="cardNumber" class="block text-sm font-medium mb-1">Card Number</label>
                    <input id="cardNumber" x-model="newPaymentMethod.cardNumber" placeholder="1234 5678 9012 3456"
                        maxlength="19" class="w-full border rounded px-2 py-1" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="expiryDate" class="block text-sm font-medium mb-1">Expiry Date</label>
                        <input id="expiryDate" x-model="newPaymentMethod.expiryDate" placeholder="MM/YY"
                            maxlength="5" class="w-full border rounded px-2 py-1" />
                    </div>
                    <div>
                        <label for="cvv" class="block text-sm font-medium mb-1">CVV</label>
                        <input id="cvv" x-model="newPaymentMethod.cvv" placeholder="123" maxlength="4"
                            class="w-full border rounded px-2 py-1" />
                    </div>
                </div>
                <div>
                    <label for="billingAddress" class="block text-sm font-medium mb-1">Billing Address</label>
                    <textarea id="billingAddress" x-model="newPaymentMethod.billingAddress" placeholder="123 Main St, City, State, ZIP"
                        rows="2" class="w-full border rounded px-2 py-1"></textarea>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="setDefault" x-model="newPaymentMethod.isDefault" class="rounded" />
                    <label for="setDefault" class="text-sm">Set as default payment method</label>
                </div>
                <div class="flex space-x-3">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded" @click="handleAddPaymentMethod">Add
                        Payment Method</button>
                    <button class="border border-gray-300 px-4 py-2 rounded"
                        @click="showAddPayment = false">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

