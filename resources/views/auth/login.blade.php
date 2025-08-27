<x-guest-layout>
    <!-- Session Status -->
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-10 w-auto" src="{{asset('assets/img/LOGOFM2.png')}}" alt="Furniture Max">
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-coklat-gelap">Masuk</h2>
        </div>
    
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <x-auth-session-status class="mb-4 text-center" :status="session('status')" />
        <form class="space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-center"/>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
            <div class="mt-2">
                <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 border-coklat-gelap focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
            </div>
    
            <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-semibold text-coklat-gelap">Lupa Password?</a>
                    </div>
                @endif
            </div>
            <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border border-coklat-gelap py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
            </div>
    
            <div>
            <button type="submit" class="flex w-full justify-center rounded-md btn-coklat-gelap px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:btn-outline-coklat-gelap border">Sign in</button>
            </div>
        </form>
    
        <p class="mt-10 text-center text-sm text-gray-500">
            Tidak Punya Akun?
            <a href="{{route('register')}}" class="font-semibold leading-6 text-coklat-gelap">Registrasi Sekarang!</a>
        </p>
        </div>
    </div>
</x-guest-layout>