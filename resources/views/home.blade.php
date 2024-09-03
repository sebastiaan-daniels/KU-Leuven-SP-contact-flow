<x-layout.servicepunt>
    <x-slot name="title">Servicepunt Contactflow Homepagina</x-slot>
    <x-slot name="description">Welkom bij de homepagina van het ICTS servicepunt contact flow</x-slot>
<p>Welkom bij de homepagina van de contact flow van het servicepunt. Log in om vragen te beheren of statistieken te exporteren. Of ga naar
    <a href="{{ route('contactflow') }}" class="underline">
        de ContactFlow
    </a>
om de CF te volgen.</p>
    @if(App::environment('local'))
        <div class="mt-2">
            <p>Demo accounts:</p>
            <p>Email: user@user.dev | ww: User1234</p>
            <p>Email: admin@admin.dev | ww: Admin1234</p>
        </div>
    @endif

</x-layout.servicepunt>

