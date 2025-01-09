<main>
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" class="w-100 border-radius-lg shadow-sm">
                    @else
                        <img src="{{ '../assets/img/marie.jpg' }}" class="w-100 border-radius-lg shadow-sm">
                    @endif
                    <input wire:model="profile_image" type="file"
                        class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                    </input>
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->name }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ auth()->user()->role }}
                        </p>
                    </div>
                </div>
                @if($user->canHaveCredits())
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                            <li class="nav-link text-xl">
                                <i class="bi bi-currency-exchange fs-4"></i>
                                <span class="fs-4">{{ $user->canHaveCredits() ? $user->credits : '0' }}</span>
                                <span class="fs-6">credits</span>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Profile Information') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">

                @if ($showDemoNotification)
                    <div wire:model.live="showDemoNotification" class="mt-3  alert alert-primary alert-dismissible fade show"
                        role="alert">
                        <span class="alert-text text-white">
                            {{ __('You are in a demo version, you can\'t update the profile.') }}</span>
                        <button wire:click="$set('showDemoNotification', false)" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                @endif

                @if ($showSuccesNotification)
                    <div wire:model.live="showSuccesNotification"
                        class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
                        <span
                            class="alert-text text-white">{{ __('Your profile information have been successfuly saved!') }}</span>
                        <button wire:click="$set('showSuccesNotification', false)" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                @endif

                <form wire:submit="save" action="#" method="POST" role="form text-left">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-name" class="form-control-label">{{ __('Full Name') }}</label>
                                <div class="@error('user.name')border border-danger rounded-3 @enderror">
                                    <input wire:model.live="user.name" class="form-control" type="text" placeholder="Name"
                                        id="user-name">
                                </div>
                                @error('user.name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-email" class="form-control-label">{{ __('Email') }}</label>
                                <div class="@error('user.email')border border-danger rounded-3 @enderror">
                                    <input wire:model.live="user.email" class="form-control" type="email"
                                        placeholder="@example.com" id="user-email">
                                </div>
                                @error('user.email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input wire:model="user.phone" type="text" class="form-control">
                                @error('user.phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.country" class="form-control-label">{{ __('Country') }}</label>
                                <div class="@error('user.country') border border-danger rounded-3 @enderror">
                                    <input wire:model.live="user.country" class="form-control" type="text"
                                        placeholder="Country" id="name">
                                </div>
                                @error('user.country') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                              <div class="col-12 col-md-6">
                                  <!-- Adresse -->
                                  <div class="form-group">
                                      <label class="form-label">Adress</label>
                                      <input wire:model="user.address" type="text" class="form-control">
                                      @error('user.address') <span class="text-danger">{{ $message }}</span> @enderror
                                  </div>
                              </div>
                              <div class="col-12 col-md-6">
                                  <div class="row">
                                      <div class="col-6">
                                          <div class="form-group">
                                              <label class="form-label">City</label>
                                              <input wire:model="user.city" type="text" class="form-control">
                                              @error('user.city') <span class="text-danger">{{ $message }}</span> @enderror
                                          </div>
                                      </div>
                                      <div class="col-6">
                                          <div class="form-group">
                                              <label class="form-label">State</label>
                                              <input wire:model="user.state" type="text" class="form-control">
                                              @error('user.state') <span class="text-danger">{{ $message }}</span> @enderror
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    <div class="form-group">
                        <label for="about">{{ 'About Me' }}</label>
                        <div class="@error('user.about')border border-danger rounded-3 @enderror">
                            <textarea wire:model.live="user.about" class="form-control" id="about" rows="3"
                                placeholder="Say something about yourself"></textarea>
                        </div>
                        @error('user.about') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</main>
