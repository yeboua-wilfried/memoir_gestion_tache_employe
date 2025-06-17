<x-app-layout>

    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Profile') }}
        {{$employe=''}}
        @if ($employe)
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ $employe->name }}
            </span>
        @endif
    </h2>
    <div class="py-12 w-full">
        <div class="w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!--<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    //@include('profile.partials.delete-user-form')
                </div>
            </div>-->
        </div>
    </div>
</x-app-layout>
