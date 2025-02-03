<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <!-- Banner Image -->
    <div class="w-full mb-4">
        <img src="{{ asset('images/couples.jpg') }}" alt="Couples Registration Banner"
            class="w-full h-48 object-cover rounded-lg">
    </div>

    @if ($submitted)
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-green-600">Thank You for Registering!</h2>
            <p class="text-gray-600 mt-2">We have received your registration.</p>
            <button wire:click="$set('submitted', false)"
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Register Another Couple
            </button>
        </div>
    @else
        <h2 class="text-2xl font-bold mb-4 text-center">Couples Registration Form</h2>

        <p class="text-center text-gray-700 mb-4">
            <strong>📅 Prayer for the Couple</strong><br>
            🗓 <strong>February 22, 2025 - 3:00 PM</strong><br>
            💰 <strong>Registration Fee: ₱300 per couple (Non-refundable)</strong><br>
            🍽 <strong>Heavy Snacks:</strong> Fried Chicken + Pansit + Drinks
        </p>

        <form wire:submit.prevent="submit" class="space-y-4">

            <div>
                <label class="block text-gray-700 font-medium">Husband's Name (Fullname)</label>
                <input type="text" wire:model="husband_name"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                @error('husband_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Wife's Name (Fullname)</label>
                <input type="text" wire:model="wife_name"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                @error('wife_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Address</label>
                <input type="text" wire:model="address"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                @error('address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Contact Number</label>
                <input type="text" wire:model="contact_number"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                @error('contact_number')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                Submit Registration
            </button>
        </form>
    @endif
</div>
