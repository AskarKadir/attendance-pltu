<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    {{ __('Welcome to CPS Cirebon Internship Attendance System') }}
                </div>
            </div>
        </div>
        @can('admin')
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        {{ __('Summary Attendance Status For') }}
                        <?php
                        $currentDateTime = date('l, d F Y');
                        echo $currentDateTime;
                        ?>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-4 gap-5 my-5">
                    <div
                        class="p-6 text-gray-900 dark:text-gray-100  bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg h-fit text-center">
                        <p class="text-8xl">{{ $hadirCount }}</p>
                        <p>Hadir</p>
                    </div>
                    <div
                        class="p-6 text-gray-900 dark:text-gray-100  bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg h-fit text-center">
                        <p class="text-8xl">{{ $absenCount }}</p>
                        <p>Absen</p>
                    </div>
                    <div
                        class="p-6 text-gray-900 dark:text-gray-100  bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg h-fit text-center">
                        <p class="text-8xl">{{ $izinCount }}</p>
                        <p>Izin</p>
                    </div>
                    <div
                        class="p-6 text-gray-900 dark:text-gray-100  bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg h-fit text-center">
                        <p class="text-8xl">{{ $sakitCount }}</p>
                        <p>Sakit</p>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</x-app-layout>
