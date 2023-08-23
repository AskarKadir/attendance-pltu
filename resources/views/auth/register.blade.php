<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', '@cpservices.com')"
                required autocomplete="username" readonly />
            @if (session('email_exists'))
                <p class="text-red-500 text-sm mt-2">{{ session('email_exists') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            @if (session('password'))
                <p class="text-red-500 text-sm mt-2">{{ session('password') }}</p>
            @endif
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            @if (session('password'))
                <p class="text-red-500 text-sm mt-2">{{ session('password') }}</p>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');

        nameInput.addEventListener('input', function() {
            const name = nameInput.value;
            const formattedEmail = name.toLowerCase().replace(/\s+/g, '') + '@cpservices.com';
            emailInput.value = formattedEmail;
        });
    });
</script>
