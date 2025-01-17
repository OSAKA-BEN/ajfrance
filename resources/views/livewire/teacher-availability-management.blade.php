<div class="container-fluid py-4">
  @foreach($teachers as $teacher)
    <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-gradient-dark">
                        <div class="d-flex align-items-center">
                            <img src="{{ $teacher->profile_image ? asset('storage/'.$teacher->profile_image) : '../assets/img/avatar-placeholder-none.png' }}" 
                                 class="avatar avatar-xxl me-4" 
                                 alt="teacher image">
                            <h2 class="mb-0 text-white">{{ $teacher->name }}</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session()->has("message.$teacher->id"))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text text-white">{{ session("message.$teacher->id") }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Disponibilités -->
                        <div class="mb-4">
                            <h5>Regular Availabilities</h5>
                            <form wire:submit.prevent="saveAvailability({{ $teacher->id }})">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Day</label>
                                            <select class="form-control @error('newAvailability.'.$teacher->id.'.day_of_week') is-invalid @enderror" wire:model="newAvailability.{{ $teacher->id }}.day_of_week">
                                                <option value="">Select a day</option>
                                                <option value="1">Monday</option>
                                                <option value="2">Tuesday</option>
                                                <option value="3">Wednesday</option>
                                                <option value="4">Thursday</option>
                                                <option value="5">Friday</option>
                                                <option value="6">Saturday</option>
                                                <option value="7">Sunday</option>
                                            </select>
                                            @error('newAvailability.'.$teacher->id.'.day_of_week')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <input type="time" class="form-control @error('newAvailability.'.$teacher->id.'.opening_time') is-invalid @enderror" 
                                                   wire:model="newAvailability.{{ $teacher->id }}.opening_time">
                                            @error('newAvailability.'.$teacher->id.'.opening_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <input type="time" class="form-control @error('newAvailability.'.$teacher->id.'.closing_time') is-invalid @enderror" 
                                                   wire:model="newAvailability.{{ $teacher->id }}.closing_time">
                                            @error('newAvailability.'.$teacher->id.'.closing_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn bg-gradient-dark btn-sm d-block w-100">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive mt-3">
                                <table class="table align-items-center mb-0">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Day</th>
                                            <th>Hours</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($teacher->availabilities as $availability)
                                            <tr>
                                                <td>{{ ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'][$availability->day_of_week - 1] }}</td>
                                                <td>{{ $availability->formatted_start_time }} - {{ $availability->formatted_end_time }}</td>
                                                <td>
                                                    <span class="badge badge-sm bg-gradient-success">
                                                        Available
                                                    </span>
                                                </td>
                                                <td>
                                                    <button wire:click="deleteAvailability({{ $availability->id }})" 
                                                            class="btn btn-sm text-xs mb-0 px-2 py-1 btn-danger"
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

                        <!-- Absences -->
                        <div>
                            <h5>Absences</h5>
                            <form wire:submit.prevent="saveAbsence({{ $teacher->id }})">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select class="form-control @error('newAbsence.'.$teacher->id.'.type') is-invalid @enderror" wire:model="newAbsence.{{ $teacher->id }}.type">
                                                <option value="">Select type</option>
                                                <option value="vacation">Vacation</option>
                                                <option value="sick_leave">Sick Leave</option>
                                                <option value="other">Other</option>
                                            </select>
                                            @error('newAbsence.'.$teacher->id.'.type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Reason</label>
                                            <input type="text" class="form-control @error('newAbsence.'.$teacher->id.'.reason') is-invalid @enderror" 
                                                   wire:model="newAbsence.{{ $teacher->id }}.reason">
                                            @error('newAbsence.'.$teacher->id.'.reason')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" class="form-control @error('newAbsence.'.$teacher->id.'.start_date') is-invalid @enderror" 
                                                   wire:model="newAbsence.{{ $teacher->id }}.start_date">
                                            @error('newAbsence.'.$teacher->id.'.start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" class="form-control @error('newAbsence.'.$teacher->id.'.end_date') is-invalid @enderror" 
                                                   wire:model="newAbsence.{{ $teacher->id }}.end_date">
                                            @error('newAbsence.'.$teacher->id.'.end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn bg-gradient-dark btn-sm d-block w-100">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive mt-3">
                                <table class="table align-items-center mb-0">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Type</th>
                                            <th>Dates</th>
                                            <th>Reason</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach($teacher->absences as $absence)
                                            <tr>
                                                <td>
                                                    <span class="badge badge-sm bg-gradient-info">
                                                        {{ ucfirst($absence->type) }}
                                                    </span>
                                                </td>
                                                <td>{{ $absence->start_date->format('d/m/Y') }} - {{ $absence->end_date->format('d/m/Y') }}</td>
                                                <td>{{ $absence->reason }}</td>
                                                <td>
                                                    <button wire:click="deleteAbsence({{ $absence->id }})" 
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
      @endforeach
</div> 