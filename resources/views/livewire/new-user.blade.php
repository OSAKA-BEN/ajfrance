<main class="main-content mt-1 border-radius-lg">
        <div class="container-fluid py-4">
        @if ($showSuccessNotification)
            <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
                <span class="alert-text text-white">The user has been created successfully!</span>
                <button wire:click="$set('showSuccessNotification', false)" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        @endif

        @if ($showErrorNotification)
            <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-icon text-white"><i class="bi bi-exclamation-triangle-fill"></i></span>
                <span class="alert-text text-white">{{ $errorMessage }}</span>
                <button wire:click="$set('showErrorNotification', false)" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="multisteps-form mb-5">
                    <!--progress bar-->
                    <div class="row">
                        <div class="col-12 col-lg-8 mx-auto my-5">
                            <div class="multisteps-form__progress">
                                <button class="multisteps-form__progress-btn {{ $currentStep >= 1 ? 'js-active' : '' }}" type="button" title="User Info">
                                    <span>User Info</span>
                                </button>
                                <button class="multisteps-form__progress-btn {{ $currentStep >= 2 ? 'js-active' : '' }}" type="button" title="Address">
                                    <span>Address</span>
                                </button>
                                <button class="multisteps-form__progress-btn {{ $currentStep >= 3 ? 'js-active' : '' }}" type="button" title="Picture">
                                    <span>Picture</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--form panels-->
                    <div class="row">
                        <div class="col-12 col-lg-8 m-auto">
                            <form wire:submit="save" class="multisteps-form__form mb-8">
                                <!--single form panel-->
                                <div class="card multisteps-form__panel p-3 border-radius-xl bg-white {{ $currentStep === 1 ? 'js-active' : '' }}"
                                    data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">User Information</h5>
                                    <div class="multisteps-form__content">
                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-6">
                                                <label>Name *</label>
                                                <input wire:model="name" class="multisteps-form__input form-control @error('name') is-invalid @enderror" type="text"
                                                    placeholder="eg. Michael" required />
                                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                <label>Phone</label>
                                                <input wire:model="phone" class="multisteps-form__input form-control @error('phone') is-invalid @enderror" type="tel"
                                                    placeholder="eg. +33 6 12 34 56 78" />
                                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label>Email Address *</label>
                                                <input wire:model="email" class="multisteps-form__input form-control @error('email') is-invalid @enderror" type="email"
                                                    placeholder="eg. soft@dashboard.com" required />
                                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-6">
                                                <label>Password *</label>
                                                <input wire:model="password" class="multisteps-form__input form-control @error('password') is-invalid @enderror" type="password"
                                                    placeholder="******" required />
                                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                <label>Repeat Password *</label>
                                                <input wire:model="password_confirmation" class="multisteps-form__input form-control @error('password_confirmation') is-invalid @enderror" type="password"
                                                    placeholder="******" required />
                                                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="button-row d-flex mt-4">
                                            <button wire:click="nextStep" class="btn bg-gradient-dark ms-auto mb-0" type="button">Next</button>
                                        </div>
                                    </div>
                                </div>
                                <!--single form panel-->
                                <div class="card multisteps-form__panel p-3 border-radius-xl bg-white {{ $currentStep === 2 ? 'js-active' : '' }}"
                                    data-animation="FadeIn">
                                    <h5 class="font-weight-bolder">Address</h5>
                                    <div class="multisteps-form__content">
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label>Country</label>
                                                <input wire:model="country" class="multisteps-form__input form-control @error('country') is-invalid @enderror" type="text"
                                                    placeholder="eg. France" />
                                                @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col">
                                                <label>Address</label>
                                                <input wire:model="address" class="multisteps-form__input form-control @error('address') is-invalid @enderror" type="text"
                                                    placeholder="eg. Street 111" />
                                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-6">
                                                <label>City</label>
                                                <input wire:model="city" class="multisteps-form__input form-control @error('city') is-invalid @enderror" type="text"
                                                    placeholder="eg. Paris" />
                                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-6 col-sm-3 mt-3 mt-sm-0">
                                                <label>State</label>
                                                <input wire:model="state" class="multisteps-form__input form-control @error('state') is-invalid @enderror" type="text"
                                                    placeholder="eg. Île-de-France" />
                                                @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-6 col-sm-3 mt-3 mt-sm-0">
                                                <label>Zip</label>
                                                <input wire:model="zipcode" class="multisteps-form__input form-control @error('zipcode') is-invalid @enderror" type="text"
                                                    placeholder="eg. 75001" />
                                                @error('zipcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="button-row d-flex mt-4">
                                            <button wire:click="previousStep" class="btn bg-gradient-light mb-0" type="button">Prev</button>
                                            <button wire:click="nextStep" class="btn bg-gradient-dark ms-auto mb-0" type="button">Next</button>
                                        </div>
                                    </div>
                                </div>
                                <!--single form panel-->
                                <div class="card multisteps-form__panel p-3 border-radius-xl bg-white {{ $currentStep === 3 ? 'js-active' : '' }}"
                                    data-animation="FadeIn">
                                    <h5 class="font-weight-bolder">Profile Picture</h5>
                                    <div class="multisteps-form__content">
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label>Profile Image</label>
                                                <input wire:model="profile_image" type="file" class="form-control @error('profile_image') is-invalid @enderror" accept="image/*">
                                                @error('profile_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="button-row d-flex mt-4">
                                            <button wire:click="previousStep" class="btn bg-gradient-light mb-0" type="button">Prev</button>
                                            <button type="submit" class="btn bg-gradient-dark ms-auto mb-0">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="../../../assets/js/plugins/multistep-form.js"></script>
