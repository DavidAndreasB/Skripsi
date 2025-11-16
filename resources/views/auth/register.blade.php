<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Username -->
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 p-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 p-2" />
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 p-2" />
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:underline">
                    Sudah punya akun? Login di sini
                </a>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-3">
                    {{ __('register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
