<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <!-- Banner Image -->
    <div class="w-full mb-4">
        <img src="{{ asset('images/lcr.jpeg') }}" alt="Registration Banner" class="w-full h-48 object-cover rounded-lg">
    </div>
    @if ($submitted)
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-green-600">Thank You for Registering!</h2>
            <p class="text-gray-600 mt-2">We have received your registration.</p>
            <button wire:click="$set('submitted', false)"
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Register Another
            </button>
        </div>
    @else
        <h2 class="text-2xl font-bold mb-4 text-center">Love-Courtship-Relationship Registration Form</h2>
        <form wire:submit.prevent="submit" class="space-y-4">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium">First Name</label>
                    <input type="text" wire:model="first_name" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                    @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Middle Name</label>
                    <input type="text" wire:model="middle_name" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium">Last Name</label>
                    <input type="text" wire:model="last_name" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                    @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Suffix</label>
                    <input type="text" wire:model="suffix" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Nickname</label>
                <input type="text" wire:model="nickname" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Birthday</label>
                <input type="date" wire:model="birthday" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                @error('birthday') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Contact Number</label>
                <input type="text" wire:model="contact_number" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                @error('contact_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Gender</label>
                <div class="flex space-x-4 mt-2">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="gender" value="Male" class="form-radio text-blue-600">
                        <span class="ml-2">Male</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="gender" value="Female" class="form-radio text-pink-600">
                        <span class="ml-2">Female</span>
                    </label>
                </div>
                @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Are you a visitor?</label>
                <div class="flex space-x-4 mt-2">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model.live="is_visitor" value="Yes" class="form-radio text-blue-600">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model.live="is_visitor" value="No" class="form-radio text-pink-600">
                        <span class="ml-2">No</span>
                    </label>
                </div>
                @error('is_visitor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            @if($is_visitor == "No")
            <div>
                <label class="block text-gray-700 font-medium">Church</label>
                <select required name="church" id="church" wire:model="church" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                    <option value="">Select</option>
                    <option value="FCC Bugayong">FCC Bugayong</option>
                    <option value="FCC San Bonifacio">FCC San Bonifacio</option>
                </select>
                @error('church') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            @endif

            <hr>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                Submit
            </button>
        </form>
    @endif
</div>
