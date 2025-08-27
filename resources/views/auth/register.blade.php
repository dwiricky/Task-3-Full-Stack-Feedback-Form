<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-10 w-auto" src="{{asset('assets/img/LOGOFM2.png')}}" alt="Furniture Max">
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-coklat-gelap">Daftar</h2>
        </div>
    
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-4" action="{{ route('register') }}" method="POST">
            @csrf
            <div>
                <label for="nama" class="block text-sm font-medium leading-6 text-gray-900">Nama</label>
                <x-input-error :messages="$errors->get('nama')" class="mt-2"/>
                <div class="mt-2">
                    <input id="nama" name="nama" type="text" autocomplete="nama" value="" required class="block w-full rounded-md border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 border-coklat-gelap focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                <div class="mt-2">
                    <input id="email" name="email" type="email" autocomplete="username" value="" required class="block w-full rounded-md border py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 border-coklat-gelap focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
    
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border border-coklat-gelap py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Konfirmasi Password</label>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>
                <div class="mt-2">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="block w-full rounded-md border border-coklat-gelap py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
    
            <div>
            <button type="submit" class="flex w-full justify-center rounded-md btn-coklat-gelap px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:btn-outline-coklat-gelap border">Daftar</button>
            </div>
        </form>
    
        <p class="mt-10 text-center text-sm text-gray-500">
            Punya Akun?
            <a href="{{route('login')}}" class="font-semibold leading-6 text-coklat-gelap">Login Sekarang!</a>
        </p>
        </div>
    </div>
</x-guest-layout>