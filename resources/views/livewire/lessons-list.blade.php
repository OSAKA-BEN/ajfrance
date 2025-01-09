<main class="main-content mt-1 border-radius-lg">
    @if($lessons->count() > 0)
    <div class="container-fluid py-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h5>{{ __('List of Lessons') }}</h5>
                    <p class="text-sm">List of your lessons</p>
                </div>
                <div class="px-3 pt-4">
                    {{ $lessons->links() }}
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    @if(auth()->user()->isAdmin())
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Teacher') }}</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Student') }}</th>
                                    @elseif(auth()->user()->isTeacher())
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Student') }}</th>
                                    @else
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Teacher') }}</th>
                                    @endif
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Date') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Statut') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Type') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lessons as $lesson)
                                    <tr>
                                        @if(auth()->user()->isAdmin())
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ $lesson->teacher->profile_image ? asset('storage/'.$lesson->teacher->profile_image) : asset('assets/img/team-2.jpg') }}" class="avatar avatar-sm me-3">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $lesson->teacher->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $lesson->teacher->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ $lesson->student->profile_image ? asset('storage/'.$lesson->student->profile_image) : asset('assets/img/team-3.jpg') }}" class="avatar avatar-sm me-3">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $lesson->student->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $lesson->student->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        @elseif(auth()->user()->isTeacher())
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ $lesson->student->profile_image ? asset('storage/'.$lesson->student->profile_image) : asset('assets/img/team-3.jpg') }}" class="avatar avatar-sm me-3">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $lesson->student->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $lesson->student->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        @else
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ $lesson->teacher->profile_image ? asset('storage/'.$lesson->teacher->profile_image) : asset('assets/img/team-2.jpg') }}" class="avatar avatar-sm me-3">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $lesson->teacher->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $lesson->teacher->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $lesson->formatted_start_datetime }}</span>
                                            <br>
                                            <span class="text-secondary text-xs font-weight-bold">{{ $lesson->formatted_start_time }} - {{ $lesson->formatted_end_time }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if($lesson->status === 'reserved')
                                                <span class="badge badge-sm bg-gradient-info">{{ __($lesson->status) }}</span>
                                            @elseif($lesson->status === 'cancelled')
                                                <span class="badge badge-sm bg-gradient-danger">{{ __($lesson->status) }}</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">{{ __($lesson->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center ">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $lesson->lesson_type }}</span>
                                        </td>
                                        <td class="align-middle text-center ">
                                            @if($lesson->status === 'reserved' && \Carbon\Carbon::parse($lesson->start_datetime)->isFuture())
                                                <button wire:click="cancelLesson({{ $lesson->id }})" 
                                                        class="btn btn-danger btn-sm text-xs mb-0 px-2 py-1" 
                                                        data-toggle="tooltip" 
                                                        data-original-title="Cancel lesson">
                                                    {{ __('Cancel') }}
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <p>No lessons found !</p>
    @endif
</main>
