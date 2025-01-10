<div class="container-fluid py-4">
    @if (session()->has('message'))
        <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
            <span class="alert-text text-white">{{ is_array(session('message')) ? implode(', ', session('message')) : session('message') }}</span>
            <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Horaires réguliers -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Opening School Hours</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveSchedule">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="day_of_week">Day</label>
                                    <select class="form-control" wire:model="newSchedule.day_of_week">
                                        <option value="">Select a day</option>
                                        <option value="1">Monday</option>
                                        <option value="2">Tuesday</option>
                                        <option value="3">Wednesday</option>
                                        <option value="4">Thursday</option>
                                        <option value="5">Friday</option>
                                        <option value="6">Saturday</option>
                                        <option value="7">Sunday</option>
                                    </select>
                                    @error('newSchedule.day_of_week') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="opening_time">Opening Time</label>
                                    <input type="time" class="form-control" wire:model="newSchedule.opening_time">
                                    @error('newSchedule.opening_time') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="closing_time">Closing Time</label>
                                    <input type="time" class="form-control" wire:model="newSchedule.closing_time">
                                    @error('newSchedule.closing_time') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn bg-gradient-dark d-block w-100">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive mt-4">
                        <table class="table align-items-center mb-0">
                            <thead class="text-center">
                                <tr>
                                    <th>Day</th>
                                    <th>Opening Hours</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($schedules as $schedule)
                                    <tr>
                                        <td>
                                            {{ ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'][$schedule->day_of_week - 1] }}
                                        </td>
                                        <td>{{ $schedule->formatted_opening_time }} - {{ $schedule->formatted_closing_time }}</td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-{{ $schedule->is_open ? 'success' : 'danger' }}">
                                                {{ $schedule->is_open ? 'Open' : 'Closed' }}
                                            </span>
                                        </td>
                                        <td>
                                        <button wire:click="toggleDay({{ $schedule->id }})" 
                                                class="btn btn-sm text-xs px-2 py-1 mb-0 btn-{{ $schedule->is_open ? 'danger' : 'success' }}">
                                            {{ $schedule->is_open ? 'Close' : 'Open' }}
                                        </button>
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

    <div class="row">
              <!-- Fermetures exceptionnelles -->
              <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Closing School Hours</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveClosure">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" wire:model="newClosure.title">
                                    @error('newClosure.title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" wire:model="newClosure.type">
                                        <option value="">Select type</option>
                                        <option value="holiday">public holiday</option>
                                        <option value="vacation">Vacation</option>
                                        <option value="special_event">Special Event</option>
                                    </select>
                                    @error('newClosure.type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" wire:model="newClosure.start_date">
                                    @error('newClosure.start_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" class="form-control" wire:model="newClosure.end_date">
                                    @error('newClosure.end_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label>Description</label>
                            <textarea class="form-control" wire:model="newClosure.description" rows="3"></textarea>
                            @error('newClosure.description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-dark">Add Closure</button>
                        </div>
                    </form>

                    <div class="table-responsive mt-4">
                        <table class="table align-items-center mb-0">
                            <thead class="text-center">
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Dates</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($closures as $closure)
                                    <tr>
                                        <td>{{ $closure->title }}</td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info">
                                                {{ ucfirst($closure->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $closure->start_date->format('d/m/Y') }} - 
                                            {{ $closure->end_date->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <button wire:click="deleteClosure({{ $closure->id }})" 
                                                    class="btn btn-danger btn-sm text-xs mb-0 px-2 py-1"
                                                    onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
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
</div>