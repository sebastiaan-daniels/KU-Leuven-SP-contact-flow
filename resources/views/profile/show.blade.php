<x-layout.servicepunt>
    <x-slot name="description">profile</x-slot>
    <x-slot name="title">Profile</x-slot>

    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
        @livewire('profile.update-profile-information-form')

        <x-section-border />
    @endif

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
        <div class="mt-10 sm:mt-0">
            @livewire('profile.update-password-form')
        </div>

        <x-section-border />
    @endif

    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
        <div class="mt-10 sm:mt-0">
            @livewire('profile.two-factor-authentication-form')
        </div>

        <x-section-border />
    @endif

    <div class="mt-10 sm:mt-0">
        @livewire('profile.logout-other-browser-sessions-form')
    </div>

{{--    USERS MOGEN HUN ACCOUNT NIET DELETEN--}}
{{--    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())--}}
{{--        <x-section-border />--}}

{{--        <div class="mt-10 sm:mt-0">--}}
{{--            @livewire('profile.delete-user-form')--}}
{{--        </div>--}}
{{--    @endif--}}
</x-layout.servicepunt>
