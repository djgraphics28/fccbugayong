<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Attendance as AttendanceModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Attendance extends Component
{
    use WithPagination, LivewireAlert;

    public $search = '';
    public $filterDate;
    public $selectedMember = null;

    protected $queryString = ['search', 'filterDate'];

    protected $listeners = ['markAttendanceConfirmed' => 'markAttendanceConfirmed'];

    public function mount()
    {
        $this->filterDate = Carbon::today()->format('Y-m-d');
    }

    public function markAttendance($memberId)
{
    $this->selectedMember = $memberId;
    $this->confirm('Are you sure you want to mark attendance?', [
        'position' => 'center',
        'showConfirmButton' => true,
        'showCancelButton' => true,
        'confirmButtonText' => 'Yes',
        'cancelButtonText' => 'No',
        'onConfirmed' => 'markAttendanceConfirmed',
        'onDismissed' => '',
        'data' => [
            'memberId' => $memberId
        ]
    ]);
}
    public function markAttendanceConfirmed()
    {
        AttendanceModel::updateOrCreate(
            [
                'member_id' => $this->selectedMember,
                'service_date' => $this->filterDate,
            ],
            [
                'time_in' => now(),
            ]
        );

        $this->alert('success', 'Attendance marked successfully');
    }

    public function deleteAttendance($attendanceId)
    {
        AttendanceModel::find($attendanceId)->delete();
        $this->alert('success', 'Attendance record deleted');
    }

    public function render()
    {
        $members = Member::query()
            ->leftJoin('attendances', function ($join) {
                $join->on('members.id', '=', 'attendances.member_id')
                    ->where('attendances.service_date', $this->filterDate);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('members.first_name', 'like', "%{$this->search}%")
                        ->orWhere('members.last_name', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('attendances.time_in', 'asc')
            ->select('members.*', 'attendances.id as attendance_id', 'attendances.time_in', 'attendances.is_present')
            ->paginate(10);

        return view('livewire.attendance', [
            'members' => $members,
        ]);
    }
}
