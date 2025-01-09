<main>
  <div class="container-fluid my-3 py-3 d-flex flex-column">

  @if ($showSuccessNotification)
      <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
          <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
          <span class="alert-text text-white">The information has been successfully updated.</span>
          <button wire:click="$set('showSuccessNotification', false)" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
      </div>
  @endif

  @if ($showErrorNotification)
      <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
          <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
          <span class="alert-text text-white">{{ $errorMessage }}</span>
          <button wire:click="$set('showErrorNotification', false)" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
      </div>
  @endif

    <div class="row mb-5 justify-content-center align-items-center">
          <div class="col-lg-9 mt-lg-0 mt-4">
              <!-- Card Basic Info -->
              <div class="card" id="basic-info">
                  <div class="card-header">
                      <h5>Edit User</h5>
                  </div>

                  <div class="card-body pt-0">
                      <form wire:submit.prevent="save">
                          <div class="row">
                              <div class="col-12 col-md-4">
                                  <!-- Profile Picture -->
                                  <div class="form-group">
                                      <label class="form-label">Profile Picture</label>
                                      <div class="mb-3">
                                          @if ($user->profile_image)
                                              <img src="{{ asset('storage/' . $user->profile_image) }}" class="avatar avatar-xl">
                                          @else
                                              <img src="{{ '../assets/img/marie.jpg' }}" class="avatar avatar-xxl avatar-scale-up">
                                          @endif
                                      </div>
                                      <input type="file" wire:model="profile_image" class="form-control">
                                      @error('profile_image') <span class="text-danger">{{ $message }}</span> @enderror
                                  </div>
                              </div>

                              <div class="col-12 col-md-8">
                                  <!-- Informations de base -->
                                  <div class="row">
                                      <div class="col-6">
                                          <div class="form-group">
                                              <label class="form-label">Name</label>
                                              <input wire:model="user.name" type="text" class="form-control" required>
                                              @error('user.name') <span class="text-danger">{{ $message }}</span> @enderror
                                          </div>
                                      </div>
                                      <div class="col-6">
                                          <div class="form-group">
                                              <label class="form-label">Email</label>
                                              <input wire:model="user.email" type="email" class="form-control" required>
                                              @error('user.email') <span class="text-danger">{{ $message }}</span> @enderror
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-6">
                                          <div class="form-group">
                                              <label class="form-label">New Password</label>
                                              <input wire:model="new_password" type="password" class="form-control">
                                              @error('new_password') <span class="text-danger">{{ $message }}</span> @enderror
                                          </div>
                                      </div>
                                      <div class="col-6">
                                          <div class="form-group">
                                              <label class="form-label">Phone</label>
                                              <input wire:model="user.phone" type="text" class="form-control">
                                              @error('user.phone') <span class="text-danger">{{ $message }}</span> @enderror
                                          </div>
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="form-label">About</label>
                                      <textarea wire:model="user.about" class="form-control" rows="3"></textarea>
                                      @error('user.about') <span class="text-danger">{{ $message }}</span> @enderror
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

                          <div class="row">
                              <div class="col-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Zipcode</label>
                                      <input wire:model="user.zipcode" type="text" class="form-control">
                                      @error('user.zipcode') <span class="text-danger">{{ $message }}</span> @enderror
                                  </div>
                              </div>
                              <div class="col-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Country</label>
                                      <input wire:model="user.country" type="text" class="form-control">
                                      @error('user.country') <span class="text-danger">{{ $message }}</span> @enderror
                                  </div>
                              </div>
                          </div>

                          @if($user->canHaveCredits())
                          <div class="row">
                              <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Role</label>
                                    <select wire:model="user.role" class="form-control" required>
                                        <option value="guest">Guest</option>
                                        <option value="student">Student</option>
                                        <option value="teacher">Teacher</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                    @error('user.role') <span class="text-danger">{{ $message }}</span> @enderror
                                  </div>
                              </div>
                              <div class="col-12 col-md-4">
                                  <div class="form-group">
                                      <label class="form-label">Credits</label>
                                      <input wire:model="user.credits" type="number" min="0" class="form-control">
                                      @error('user.credits') <span class="text-danger">{{ $message }}</span> @enderror
                                      </div>
                                  </div>
                              </div>
                          </div>
                          @endif

                          <div class="mx-3 mb-3">
                              <button type="submit"
                                  class="btn bg-gradient-dark btn-sm float-end">{{ __('Save changes') }}</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
