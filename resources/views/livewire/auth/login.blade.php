<section class="h-100-vh mb-8">
    <div class="page-header align-items-start section-height-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">{{ __('Content de te revoir !') }}</h1>
                    <p class="text-lead text-white">
                        {{ __('Connectez vous pour accéder à l\'application Afjfrance.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-header text-center pt-4">
                        <h5>{{ __('Se connecter') }}</h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit="login" action="#" method="POST" role="form text-left">
                            <div class="mb-3">
                                <div class="@error('email') border border-danger rounded-3 @enderror">
                                    <input wire:model.live="email" type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" value="admin@softui.com">
                                </div>
                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <div class="@error('password') border border-danger rounded-3 @enderror">
                                    <input wire:model.live="password" type="password" class="form-control" placeholder="Mot de passe" aria-label="Password" aria-describedby="password-addon" value="secret">
                                </div>
                                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-check form-switch">
                                <input wire:model="remember_me" class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">{{ __('Se souvenir de moi') }}</label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">{{ __('Se connecter') }}</button>
                            </div>
                            <div class="text-left">
                                <p class="text-sm mt-3 mb-0">{{ __('Mot de passe oublié? ') }}
                                    <a href="{{ route('forgot-password') }}" class="text-dark font-weight-bolder">{{ __('Réinitialiser') }}</a>
                                </p>
                            </div>
                            <div class="text-left">
                                <p class="text-sm mt-3 mb-0">{{ __('Vous n\'avez pas de compte? ') }}<a href="{{ route('sign-up') }}" class="text-dark font-weight-bolder">{{ __('S\'inscrire') }}</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            Pour vous connecter, veuillez utiliser les identifiants suivants :
            <br>
            Email : admin@softui.com
            <br>
            Mot de passe : secret
        </div>
    </div>
</section>
