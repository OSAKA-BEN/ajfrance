<main class="container-fluid">
    <div class="row mt-4">
        <div class="col-12">
            <h5>Teachers</h5>
            <p class="text-sm">Make a reservation with your teacher</p>

            @foreach($teachers as $teacher)
            <div class="card mt-2">
                <div class="card-body">
                    @if (isset($showSuccessNotification[$teacher->id]) && $showSuccessNotification[$teacher->id])
                        <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                            <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text text-white">Reservation created successfully!</span>
                            <button wire:click="$set('showSuccessNotification', false)" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif

                    @if (isset($showErrorNotification[$teacher->id]) && $showErrorNotification[$teacher->id])
                        <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text text-white">{{ $errorMessage[$teacher->id] }}</span>
                            <button wire:click="$set('showErrorNotification.{{$teacher->id}}', false)" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-5 text-center justify-content-left align-items-start d-flex">
                          <img src="{{ $teacher->profile_image ? asset('storage/'.$teacher->profile_image) : '../assets/img/marie.jpg' }}"  alt="img-blur-shadow"
                          class="img-fluid shadow border-radius-xl"
                          style="height: 200px; width: 200px;">
                        </div>
                        <div class="col-7">
                            <h3 class="">{{ $teacher->name }}</h3>
                            <label class="mt-4">Description</label>
                              <p class="mb-4 text-sm">
                                {{ $teacher->about }}
                              </p>
                            <div class="row mt-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="me-3">
                                      <label for="selectedDates.{{$teacher->id}}">Date</label>
                                        <input type="date" 
                                               class="form-control @error('selectedDates.' . $teacher->id) is-invalid @enderror" 
                                               wire:model="selectedDates.{{$teacher->id}}" />
                                        @error('selectedDates.' . $teacher->id) <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="me-3">
                                        <label for="selectedTimes.{{$teacher->id}}">Time</label>
                                        <select class="form-control @error('selectedTimes.' . $teacher->id) is-invalid @enderror" 
                                                wire:model="selectedTimes.{{$teacher->id}}">
                                            <option value="">Select a time</option>
                                            @for ($i = 9; $i <= 17; $i++)
                                                <option value="{{ $i }}">{{ $i }}:00</option>
                                            @endfor
                                        </select>
                                        @error('selectedTimes.' . $teacher->id) <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="me-3">
                                        <label for="selectedTypes.{{$teacher->id}}">Type</label>
                                        <div>
                                            <div>
                                                <input type="radio" id="type_skype_{{$teacher->id}}" name="selectedTypes.{{$teacher->id}}" value="skype" wire:model="selectedTypes.{{$teacher->id}}">
                                                <label for="type_skype_{{$teacher->id}}">Skype</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="type_private_{{$teacher->id}}" name="selectedTypes.{{$teacher->id}}" value="private" wire:model="selectedTypes.{{$teacher->id}}">
                                                <label for="type_private_{{$teacher->id}}">Private</label>
                                            </div>
                                        </div>
                                        @error('selectedTypes.' . $teacher->id) <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <button type="button" 
                                            class="btn btn-info btn-sm mb-0"
                                            wire:click="makeReservation({{ $teacher->id }})">
                                        Make a reservation
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                @endforeach
        </div>
    </div>
</div>
</main>

