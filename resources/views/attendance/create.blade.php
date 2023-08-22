<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Create Attendance') }}
        </h2>
    </x-slot>

    <div class="sm:py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white dark:bg-gray-800 sm:shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('attendance.store') }}" class="">
                        @csrf
                        @method('post')
                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="text" class="block w-full mt-1"
                                required autofocus autocomplete="email" :value="old('email')" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="status" :value="__('Status')" />
                            <x-select name="status" class="block w-full mt-1" id="status">
                                <option value="absen" id="absen">Absen</option>
                                <option value="izin" id="izin">Izin</option>
                                <option value="sakit" id="sakit">Sakit</option>
                                <option value="hadir" id="hadir">Hadir</option>
                            </x-select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <x-cancel-button href="{{ route('attendance.index') }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
