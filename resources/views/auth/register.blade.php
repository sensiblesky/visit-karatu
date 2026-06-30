<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Create your account</h1>
        <p class="text-sm text-gray-500 mt-1">Join VisitKaratu to save favourites or list your business.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ role: '{{ old('role', 'visitor') }}' }">
        @csrf

        {{-- Account type selector --}}
        <div class="mb-5">
            <x-input-label :value="__('I want to')" />
            <div class="grid grid-cols-2 gap-3 mt-2">
                <label :class="role === 'visitor' ? 'border-forest-600 bg-forest-50 ring-1 ring-forest-600' : 'border-gray-200 hover:border-gray-300'"
                       class="cursor-pointer border rounded-2xl p-4 transition">
                    <input type="radio" name="role" value="visitor" x-model="role" class="sr-only">
                    <svg class="w-6 h-6 mb-2" :class="role === 'visitor' ? 'text-forest-700' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-semibold text-gray-900">Explore Karatu</p>
                    <p class="text-xs text-gray-400 mt-0.5">Browse & save favourites</p>
                </label>
                <label :class="role === 'stakeholder' ? 'border-forest-600 bg-forest-50 ring-1 ring-forest-600' : 'border-gray-200 hover:border-gray-300'"
                       class="cursor-pointer border rounded-2xl p-4 transition">
                    <input type="radio" name="role" value="stakeholder" x-model="role" class="sr-only">
                    <svg class="w-6 h-6 mb-2" :class="role === 'stakeholder' ? 'text-forest-700' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <p class="text-sm font-semibold text-gray-900">List my business</p>
                    <p class="text-xs text-gray-400 mt-0.5">Lodges, tours & more</p>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full mt-6 py-3">
            {{ __('Create Account') }}
        </x-primary-button>

        <p class="text-center text-sm text-gray-500 mt-5">
            {{ __('Already have an account?') }}
            <a class="font-semibold text-forest-700 hover:text-forest-900" href="{{ route('login') }}">
                {{ __('Sign in') }}
            </a>
        </p>
    </form>
</x-guest-layout>
