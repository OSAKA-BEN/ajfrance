<x-layouts.base>
    {{-- If the user is authenticated --}}
    @auth()
        {{-- If the user is authenticated on the static sign up or the sign up page --}}
        @if (in_array(request()->route()->getName(),['static-sign-up', 'sign-up'],))
            {{ $slot }}
            {{-- If the user is authenticated on the static sign in or the login page --}}
        @elseif (in_array(request()->route()->getName(),['sign-in', 'login'],))
            {{ $slot }}
        @elseif (in_array(request()->route()->getName(),['profile', 'my-profile'],))
            <div class="main-content position-relative bg-gray-100">
                @include('layouts.navbars.auth.nav-profile')
                <div>
                    {{ $slot }}
                </div>
            </div>
            @include('components.plugins.fixed-plugin')
        @else
            @include('layouts.navbars.auth.sidebar')
            @include('layouts.navbars.auth.nav')
            @include('components.plugins.fixed-plugin')
            {{ $slot }}
        @endif
    @endauth

    {{-- If the user is not authenticated (if the user is a guest) --}}
    @guest
        {{-- If the user is on the login page --}}
        @if (!auth()->check() && in_array(request()->route()->getName(),['login'],))
            {{ $slot }}

            {{-- If the user is on the sign up page --}}
        @elseif (!auth()->check() && in_array(request()->route()->getName(),['sign-up'],))
            <div>
                {{ $slot }}
            </div>
        @endif
    @endguest

</x-layouts.base>
