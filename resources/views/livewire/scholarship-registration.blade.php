<div>
    <div class="max-w-4xl mx-auto" x-data="{ showInstructions: true, acceptedTerms: false }">

        @if ($showSuccess)
            <!-- Success Card -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mt-3 text-lg font-medium text-gray-900 dark:text-gray-100">Application Submitted
                        Successfully!</h3>
                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <p>Thank you for applying to the FCC Scholarship Program.</p>
                        <p class="mt-1">We will review your application and contact you soon.</p>
                    </div>
                    <div class="mt-6">
                        <button wire:click="applyAnother" type="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Apply Another
                        </button>
                    </div>
                </div>
            </div>
        @else
            <!-- Modal Overlay -->
            <div x-show="showInstructions" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[80vh] overflow-y-auto"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <!-- Modal Header -->
                    <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg sticky top-0">
                        <h2 class="text-xl font-bold">FCC Bugayong Church Scholarship Program</h2>
                        <p class="text-blue-100 text-sm">Please read the requirements carefully</p>
                    </div>

                    <!-- Modal Content -->
                    <div class="p-6 space-y-4 text-gray-700 dark:text-gray-300">
                        <div class="space-y-4">
                            <h3 class="font-bold text-lg">Basic Requirements:</h3>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Must be an active FCC Bugayong member for at least 6 months</li>
                                <li>Regularly attends Sunday worship and Bible study</li>
                                <li>Currently serving in a church ministry (worship, media, kids, youth, etc.)</li>
                                <li>Maintains at least 80% average grade in school</li>
                                <li>Good moral character with no disciplinary issues</li>
                                <li>Demonstrated financial need (will need to submit proof)</li>
                            </ul>

                            <h3 class="font-bold text-lg">Required Documents:</h3>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Fully completed application form</li>
                                <li>Recent ID photo (1x1 or 2x2)</li>
                                <li>Latest school grades/transcript</li>
                                <li>Current enrollment certificate</li>
                                <li>Good Moral Certificate from school</li>
                                <li>Letter from your ministry leader</li>
                                <li>Pastor's recommendation letter</li>
                                <li>Short personal testimony (1-2 paragraphs)</li>
                                <li>Parents' income documents</li>
                            </ul>

                            <div
                                class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                <p class="font-medium text-yellow-700 dark:text-yellow-300">Important: Applications with
                                    missing requirements will not be processed.</p>
                            </div>
                        </div>

                        <!-- Email Requirement -->
                        {{-- <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email Address <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500">(Required for application updates)</span>
                            </label>
                            <input type="email" wire:model.defer="email" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                            @error('email')
                                <span class="block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}
                    </div>

                    <!-- Modal Footer -->
                    <div
                        class="bg-gray-50 dark:bg-gray-700/30 px-6 py-4 rounded-b-lg flex flex-col sm:flex-row justify-between items-center gap-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" x-model="acceptedTerms"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">I understand and agree to all
                                requirements</span>
                        </label>

                        <button @click="showInstructions = false" :disabled="!acceptedTerms || !email"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            Continue to Application
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Application Form (hidden initially) -->
            <div x-show="!showInstructions" x-cloak>
                <!-- Blue Banner Header -->
                <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg shadow">
                    <h1 class="text-2xl md:text-3xl font-bold">FCC Scholarship Application Form</h1>
                    <p class="text-blue-100 mt-1">Please fill out all required fields (*) to complete your application
                    </p>
                </div>

                <!-- Form Container -->
                <div class="p-6 bg-white dark:bg-gray-800 shadow-lg rounded-b-lg">
                    @if (session()->has('success'))
                        <div
                            class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-300 rounded-lg border border-green-100 dark:border-green-900">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="submit" class="space-y-6">
                        <!-- Personal Information Section -->
                        <div class="space-y-6 p-6 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Personal Information</h2>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model.defer="first_name"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                    @error('first_name')
                                        <span
                                            class="block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Middle
                                        Name</label>
                                    <input type="text" wire:model.defer="middle_name"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model.defer="last_name"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                    @error('last_name')
                                        <span
                                            class="block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Suffix</label>
                                    <input type="text" wire:model.defer="suffix"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender
                                        <span class="text-red-500">*</span></label>
                                    <select wire:model.defer="gender"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                        <option value="">-- Select --</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                    @error('gender')
                                        <span
                                            class="block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of
                                        Birth
                                        <span class="text-red-500">*</span></label>
                                    <input type="date" wire:model.defer="birth_date"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                    @error('birth_date')
                                        <span
                                            class="block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Age</label>
                                    <input type="number" wire:model.defer="age"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact
                                    Number
                                    <span class="text-red-500">*</span></label>
                                <input type="text" wire:model.defer="contact_number"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                @error('contact_number')
                                    <span class="block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email
                                        <span class="text-red-500">*</span></label>
                                    <input type="email" wire:model.defer="email" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                    @error('email')
                                        <span
                                            class="block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facebook
                                        Profile (optional)</label>
                                    <input type="text" wire:model.defer="facebook"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Home Address
                                    <span class="text-red-500">*</span></label>
                                <textarea wire:model.defer="address" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition"></textarea>
                                @error('address')
                                    <span class="block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Parent & Guardian Information Section -->
                        <div class="space-y-6 p-6 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Parent & Guardian
                                Information
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Father's Information -->
                                <div
                                    class="space-y-4 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <h3 class="font-medium text-gray-800 dark:text-gray-200">Father's Information</h3>
                                    <div class="space-y-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Father's
                                            Name <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model.defer="father_name"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                        @error('father_name')
                                            <span
                                                class="block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Father's
                                            Occupation</label>
                                        <input type="text" wire:model.defer="father_occupation"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Father's
                                            Contact Number</label>
                                        <input type="text" wire:model.defer="father_contact"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                    </div>
                                </div>

                                <!-- Mother's Information -->
                                <div
                                    class="space-y-4 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <h3 class="font-medium text-gray-800 dark:text-gray-200">Mother's Information</h3>
                                    <div class="space-y-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mother's
                                            Name <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model.defer="mother_name"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                        @error('mother_name')
                                            <span
                                                class="block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mother's
                                            Occupation</label>
                                        <input type="text" wire:model.defer="mother_occupation"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mother's
                                            Contact Number</label>
                                        <input type="text" wire:model.defer="mother_contact"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                    </div>
                                </div>
                            </div>

                            <!-- Guardian Information -->
                            <div
                                class="space-y-4 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <h3 class="font-medium text-gray-800 dark:text-gray-200">Guardian Information (if not
                                    living with parents)</h3>
                                <div class="space-y-2">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Guardian's
                                        Name</label>
                                    <input type="text" wire:model.defer="guardian_name"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Relationship
                                            to Applicant</label>
                                        <input type="text" wire:model.defer="guardian_relation"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Guardian's
                                            Contact Number</label>
                                        <input type="text" wire:model.defer="guardian_contact"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 transition">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-70"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>Submit Registration</span>
                                <span wire:loading>
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    @endif

    <!-- Add this to your CSS -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
