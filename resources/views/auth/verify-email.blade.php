<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-10 w-auto" src="{{asset('assets/img/LOGOFM2.png')}}" alt="Furniture Max">
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-coklat-gelap">Verifikasi Email</h2>
        </div>
        @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 text-center dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
        @endif
    
        <div class="mt-10 sm:mx-auto sm:w-full text-center sm:max-w-sm">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
    
                <div>
                    <button type="submit" class="btn btn-coklat-gelap p-2 rounded border">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </form>
    
            <form method="POST" class="mt-2" action="{{ route('logout') }}">
                @csrf
    
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Log Out') }}
                </button>
            </form>
    
        </div>
    </div>
</x-guest-layout>