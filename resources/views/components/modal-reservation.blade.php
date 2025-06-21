<!-- Reservation Details Modal -->
<div x-show="view" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
    <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
        <button @click="view = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
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
                            <div class="mt-2" x-html="getStatusBadge(selectedReservation.status)">
                                <!-- Status Badge -->
                                {{-- <template x-if="selectedReservation.status === 'confirmed'">
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
                                </template> --}}
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Check-in</p>
                                <p class="font-semibold flex items-center">
                                    <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                                    <span x-text="formatDate(selectedReservation.checkIn, 'MMM dd, yyyy')"></span>
                                </p>
                                <p class="text-xs text-gray-500">After 3:00 PM</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Check-out</p>
                                <p class="font-semibold flex items-center">
                                    <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                                    <span x-text="formatDate(selectedReservation.checkOut, 'MMM dd, yyyy')"></span>
                                </p>
                                <p class="text-xs text-gray-500">Before 11:00 AM</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Guests</p>
                                <p class="font-semibold flex items-center">
                                    <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                                    <span x-text="selectedReservation.guests + ' Guests'"></span>
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-500">Nights</p>
                                <p class="font-semibold flex items-center">
                                    <i data-lucide="bed" class="w-4 h-4 mr-2"></i>
                                    <span x-text="selectedReservation.nights + ' Nights'"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Amenities -->
                <div>
                    <h4 class="font-semibold mb-3">Room Amenities</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <template x-for="amenity in selectedReservation.amenities" :key="amenity">
                            <div class="flex items-center">
                                <i data-lucide="check-circle" class="w-4 h-4 text-green-600 mr-2"></i>
                                <span class="text-sm" x-text="amenity"></span>
                            </div>
                        </template>
                    </div>
                </div>
                <!-- Pricing Breakdown -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold mb-3">Pricing Breakdown</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Room rate (<span x-text="selectedReservation.nights"></span> nights)</span>
                            <span x-text="'$' + Math.round(selectedReservation.priceBreakdown.roomCharge)"></span>
                        </div>
                        <div class="">
                            <span>Optional Services</span>
                            <template x-for="service in selectedReservation.optionalServices" :key="service.id">
                                <div class="flex justify-between">
                                    <span x-text="service.name" class="text-gray-500"></span>
                                    <span x-text="'$' + Math.round(service.price * service.quantity)"
                                        class="text-gray-500"></span>
                                </div>
                            </template>
                        </div>

                        <div class="flex justify-between">
                            <span>Sub Total</span>
                            <span x-text="'$' + Math.round(selectedReservation.priceBreakdown.subTotal)"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Discount Total</span>
                            <span x-text="'$' + Math.round(selectedReservation.priceBreakdown.discountTotal)"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Taxes & fees</span>
                            <span x-text="'$' + Math.round(selectedReservation.priceBreakdown.taxes)"></span>
                        </div>
                        <div class="border-t my-2"></div>
                        <div class="flex justify-between font-semibold">
                            <span>Total</span>
                            <span x-text="'$' + Math.round(selectedReservation.priceBreakdown.grandTotal)"></span>
                        </div>
                    </div>
                </div>
                <!-- Cancellation Policy -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-semibold mb-2 flex items-center">
                        <i data-lucide="circle-alert" class="w-4 h-4 mr-2 text-blue-600"></i>
                        Cancellation Policy
                    </h4>
                    <p class="text-sm text-blue-800">
                        Free cancellation until 24 hours before check-in. After that, you will be charged for one night.
                    </p>
                </div>
                <!-- Action Buttons -->
                <div class="flex space-x-3 pt-4">
                    <template
                        x-if="selectedReservation.status === 'confirmed_guaranteed' || selectedReservation.status === 'confirmed_no_cc_hold'">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded flex items-center"
                            @click="view = false; $dispatch('editReservation', selectedReservation); edit = true;">
                            <i data-lucide="square-pen" class="w-4 h-4 mr-2"></i>
                            Modify Reservation
                        </button>
                    </template>
                    {{-- Cancellation allow only before hotel arriavl date and confirmed reservations --}}
                    <template
                        x-if="(selectedReservation.status === 'confirmed_guaranteed' || selectedReservation.status === 'confirmed_no_cc_hold') && new Date(selectedReservation.checkIn) > new Date()">
                        <button class="bg-red-600 text-white px-4 py-2 rounded flex items-center">
                            <i data-lucide="ban" class="w-4 h-4 mr-2"></i>
                            Cancel Reservation</button>
                    </template>
                    <button class="border border-gray-300 px-4 py-2 rounded flex items-center">
                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                        Download Receipt
                    </button>
                    <button class="border border-gray-300 px-4 py-2 rounded" @click="view = false">Close</button>
                </div>
            </div>
        </template>
    </div>
</div>

<!-- Modify Reservation Modal -->
<div x-show="edit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
    @editReservation.window="selectedReservation = $event.detail;">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
        <button @click="edit = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div>
            <h2 class="text-2xl font-bold mb-1">Modify Reservation</h2>
            <p class="text-gray-600 mb-6">Update your reservation details for <span
                    x-text="selectedReservation.hotelName"></span></p>
        </div>
        <template x-if="selectedReservation">
            <div class="space-y-6">
                <div class="flex items-center bg-blue-50 p-3 rounded">
                    <i data-lucide="circle-alert" class="w-4 h-4 mr-2 text-blue-600"></i>
                    <span class="text-blue-800 text-sm">Changes may affect your room rate. You'll see the updated
                        pricing before confirming.</span>
                </div>
                <!-- Current Reservation Info -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold mb-2">Current Reservation</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Check-in</p>
                            <p class="font-medium" x-text="formatDate(selectedReservation.checkIn, 'MMM dd, yyyy')">
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500">Check-out</p>
                            <p class="font-medium" x-text="formatDate(selectedReservation.checkOut, 'MMM dd, yyyy')">
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500">Nights</p>
                            <p class="font-medium"><span x-text="selectedReservation.nights"></span> nights</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Total</p>
                            <p class="font-medium">$<span
                                    x-text="selectedReservation.priceBreakdown.grandTotal"></span></p>
                        </div>
                    </div>
                </div>
                <!-- Modification Form -->
                <form class="space-y-4" @submit.prevent="handleSaveModification">
                    <template x-if="new Date(selectedReservation.checkIn) > new Date()">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="newCheckIn" class="block text-sm font-medium mb-1">New Check-in
                                    Date</label>
                                <input id="newCheckIn" type="date" x-model="selectedReservation.checkIn"
                                    :min="today" class="w-full border rounded px-2 py-1" />
                            </div>
                            <div>
                                <label for="newCheckOut" class="block text-sm font-medium mb-1">New Check-out
                                    Date</label>
                                <input id="newCheckOut" type="date" x-model="selectedReservation.checkOut"
                                    :min="selectedReservation.checkIn || today" class="w-full border rounded px-2 py-1" />
                            </div>
                        </div>
                    </template>
                    <!-- Add-ons -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium">Additional Services</label>
                        <div class="space-y-2">
                            <template x-for="service in availableOptionalServices" :key="service.id">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" :id="'service-' + service.id"
                                        x-model="modifyFormData.selectedServices[service.id]" class="rounded"
                                        :checked="modifyFormData.selectedServices[service.id]" />
                                    <label :for="'service-' + service.id" class="text-sm">
                                        <span x-text="service.name"></span>
                                        <span class="text-gray-500">(+ $<span x-text="service.price"></span>)</span>
                                    </label>
                                </div>
                            </template>
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
                                <span>Room rate (<span x-text="selectedReservation.nights"></span> nights)</span>
                                <span x-text="'$' + Math.round(selectedReservation.priceBreakdown.roomCharge)"></span>
                            </div>
                            <div class="">
                                <span>Optional Services</span>
                                <template x-for="service in selectedReservation.optionalServices"
                                    :key="service.id">
                                    <div class="flex justify-between">
                                        <span x-text="service.name" class="text-gray-500"></span>
                                        <span x-text="'$' + Math.round(service.price * service.quantity)"
                                            class="text-gray-500"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="flex justify-between">
                                <span>Sub Total</span>
                                <span x-text="'$' + Math.round(selectedReservation.priceBreakdown.subTotal)"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Discount Total</span>
                                <span
                                    x-text="'$' + Math.round(selectedReservation.priceBreakdown.discountTotal)"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Taxes & fees</span>
                                <span x-text="'$' + Math.round(selectedReservation.priceBreakdown.taxes)"></span>
                            </div>
                            <div class="border-t my-2"></div>
                            <div class="flex justify-between font-semibold">
                                <span>New Total</span>
                                <span>$0</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-600">
                                <span>Difference from original</span>
                                <span class="text-red-600">+$0</span>
                            </div>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex space-x-3 pt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
                        <button type="button" class="border border-gray-300 px-4 py-2 rounded"
                            @click="edit = false">Cancel</button>
                    </div>
                </form>
            </div>
        </template>
    </div>
</div>

<!-- Payment Methods Management Modal -->
<div x-data="{ paymentMethodEdit: $persist(false).as('showPaymentMethods'), showAddPayment: false }" x-show="paymentMethodEdit" x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
    @keydown.escape.window="paymentMethodEdit = false">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
        <button @click="paymentMethodEdit = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

            flatpickr("#newCheckIn", {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function(selectedDates, dateStr) {
                    const checkOutPicker = flatpickr("#newCheckOut");
                    checkOutPicker.set('minDate', selectedDates[0]);
                    if (selectedDates.length > 0) {
                        checkOutPicker.setDate(selectedDates[0], true);
                    }
                }
            });

            flatpickr("#newCheckOut", {
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function(selectedDates, dateStr) {
                    const checkInPicker = flatpickr("#newCheckIn");
                    checkInPicker.set('maxDate', selectedDates[0]);
                }
            });
        });
    </script>

@endpush
