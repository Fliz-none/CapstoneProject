<div class="modal fade" id="work_summary-modal" aria-labelledby="work_summary-modal-label">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h1 class="modal-title text-white fs-5" id="work_summary-modal-label">{{ __('messages.work_schedule.month_summary') }} &nbsp;{{ $range }}</h1>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 ms-auto" style="width: 17rem">
                    <input class="form-control cursor-pointer" id="work_summary-range" type="text" placeholder="Report period" size="25" />
                </div>
                <table class="table table-striped table-hover key-table" id="work_summary-table">
                    <thead>
                        <tr>
                            <th class="text-center">{{ __('messages.work_schedule.name_employee') }}</th>
                            <th class="text-center">{{ __('messages.work_schedule.total_hours') }}</th>
                            <th class="text-center">{{ __('messages.work_schedule.total_time_late') }} / {{ __('messages.work_schedule.total_shift') }}</th>
                             <th class="text-center">{{ __('messages.work_schedule.salary') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($summarys as $summary)
                            <tr>
                                <td class="text-center fs-6">{{ $summary['user']->name }}<br>
                                    <span class="fw-bold text-info">{{ $summary['user']->code }}</span>
                                </td>
                                <td class="text-center">{{ $summary['total_hours'] }}</td>
                                <td class="text-center">{{ $summary['total_late'] }} / {{ $summary['total_shifts'] }}</td>
                                <td class="text-center">{{ $summary['salary'] }}</td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4"><span class="text-primary fw-bold"> {{ __('messages.work_schedule.no_shift') }}</span></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
