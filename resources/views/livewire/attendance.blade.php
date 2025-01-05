<div>
    <div class="flex flex-col sm:flex-row justify-center sm:justify-between items-center mb-4">
        <!-- Search and Filters -->
        <div class="flex items-center gap-4">
            <input type="text" wire:model.live="search" placeholder="Search by name" class="border rounded px-4 py-2">
            <input type="date" wire:model.live="filterDate" class="border rounded px-4 py-2">
        </div>
    </div>
    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Avatar</th>
                <th class="border px-4 py-2">Full Name</th>
                <th class="border px-4 py-2">Time In</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td class="border px-4 py-2">
                        <img src="{{ $member->getFirstMediaUrl('avatar') }}" alt="Avatar"
                            class="w-10 h-10 rounded-full">
                    </td>
                    <td class="border px-4 py-2">
                        {{ $member->first_name }} {{ $member->last_name }} {{ $member->ext_name }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $member->time_in ? \Carbon\Carbon::parse($member->time_in)->format('h:i A') : 'N/A' }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $member->is_present ? 'Present' : 'Absent' }} </td>
                    <td class="border px-4 py-2 flex space-x-2">
                        @if (!$member->attendance_id)
                            <button wire:click="markAttendance({{ $member->id }})"
                                class="bg-blue-500 text-white px-4 py-2 rounded">Mark</button>
                        @else
                            <button wire:click="deleteAttendance({{ $member->attendance_id }})"
                                class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-4">No members found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $members->links() }}
    </div>
</div>
