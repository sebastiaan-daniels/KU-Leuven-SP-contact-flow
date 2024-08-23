<div>
    {{-- show preloader while fetching data in the background --}}
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
         wire:loading>
        <x-icts.preloader class="primary text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-icts.preloader>
    </div>

    {{-- Filter --}}
    <div class="mb-4 flex md:flex-row flex-col gap-2">
        <div class="flex-1">
            <div class="relative">
                <x-input id="search" type="text" placeholder="Filter naam"
                         wire:model.live.debounce.500ms="search"
                         class="w-full shadow-md placeholder-gray-300"/>
                <button
                    @click="$wire.set('search', '')"
                    class="w-5 absolute right-4 top-3">
                    <x-phosphor-x/>
                </button>
            </div>
        </div>
        <x-icts.form.switch id="active"
                           wire:model.live="active"
                           text-off="inactief"
                           color-off="bg-gray-100 before:line-through"
                           text-on="Actief"
                           color-on="text-white primary"
                           class="w-20 h-auto" />
        <x-button class="primary" wire:click="newContact()">
            Nieuw Contact
        </x-button>
    </div>

    <div class="my-4">{{ $contacts->links() }}</div>
    <table class="mt-3 text-center w-full">
        <colgroup>
            <col class="w-72">
            <col class="w-72">
            <col class="w-72">
            <col class="w-72">
            <col class="w-auto">
            <col class="w-36">
        </colgroup>
        <thead>
        <tr class="mt-3 text-left w-full">
            <th wire:click="resort('name')"><span data-tippy-content="Sorteer op naam">Naam</span></th>
            <th>email</th>
            <th>website</th>
            <th>phone </th>
            <th></th>
            <th class="text-black">
                <x-icts.form.select id="perPage"
                                   wire:model.live="perPage"
                                   class="block my-1 w-full">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </x-icts.form.select>
            </th>
        </tr>
        </thead>

        <tbody class="border-t-4 border-black">
        @foreach($contacts as $contact)
            <tr class="border-t border-gray-300 [&>td]:p-2">
                <td class="text-left">{{ $contact->name }}</td>
                <td class="text-left">{{ $contact->email }}</td>
                <td class="text-left">{{ $contact->website }}</td>
                <td class="text-left">{{ $contact->phone}}</td>
                <td></td>
                <td>
                    <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                        <button
                            wire:click="editLocation({{ $contact->id }})"
                            class="text-gray-400 hover:text-sky-100 primaryHover transition border-r border-gray-300">
                            <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                        </button>
                        <button
                            wire:click="confirmation({{ $contact->id }})"
                            class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                            <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="my-4">{{ $contacts->links() }}</div>

    {{-- Modal for add and update record --}}
{{--    <x-dialog-modal id="locationModal"--}}
{{--                    wire:model.live="showModal">--}}
{{--        <x-slot name="title">--}}
{{--            @if(is_null($form->id))--}}
{{--                <h2>Locatie aanmaken</h2>--}}
{{--            @else--}}
{{--                <h2>Locatie aanpassen</h2>--}}
{{--            @endif--}}
{{--        </x-slot>--}}
{{--        <x-slot name="content">--}}
{{--            --}}{{-- error messages --}}
{{--            @if ($errors->any())--}}
{{--                <x-icts.alert type="danger">--}}
{{--                    <x-icts.list>--}}
{{--                        @foreach ($errors->all() as $error)--}}
{{--                            <li>{{ $error }}</li>--}}
{{--                        @endforeach--}}
{{--                    </x-icts.list>--}}
{{--                </x-icts.alert>--}}
{{--            @endif--}}

{{--            <div class="flex flex-row gap-4 mt-4">--}}
{{--                <div class="flex-1 flex-col gap-2">--}}
{{--                    <x-label for="Naam" value="Naam" class="mt-4"/>--}}
{{--                    <x-input id="Naam" type="text"--}}
{{--                             wire:model="form.name"--}}
{{--                             class="mt-1 block w-full"/>--}}
{{--                    <x-label for="Stad" value="Stad" class="mt-4"/>--}}
{{--                    <x-icts.form.select wire:model="form.city_id" id="city_id" class="block mt-1 w-full">--}}
{{--                        <option value="">Stad</option>--}}
{{--                        @foreach($allCities as $cities)--}}
{{--                            <option value="{{ $cities->id }}">{{ $cities->name }}</option>--}}
{{--                        @endforeach--}}
{{--                    </x-icts.form.select>--}}
{{--                    <x-label for="street_name" value="Straat Naam" class="mt-4"/>--}}
{{--                    <x-input id="street_name" type="text"--}}
{{--                             wire:model="form.street_name"--}}
{{--                             class="mt-1 block w-full"/>--}}
{{--                    <x-label for="house_number" value="Huis Nummer" class="mt-4"/>--}}
{{--                    <x-input id="house_number" type="number"--}}
{{--                             wire:model="form.house_number"--}}
{{--                             class="mt-1 block w-full"/>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </x-slot>--}}
{{--        <x-slot name="footer">--}}
{{--            <x-secondary-button @click="$wire.showModal = false">Annuleren</x-secondary-button>--}}
{{--            @if(is_null($form->id))--}}
{{--                <x-icts.form.button color="info"--}}
{{--                                   wire:click="createLocation({{ $form->id }})"--}}
{{--                                   class="ml-2">Aanmaken--}}
{{--                </x-icts.form.button>--}}
{{--            @else--}}
{{--                <x-icts.form.button color="info"--}}
{{--                                   wire:click="updateLocation({{ $form->id }})"--}}
{{--                                   class="ml-2">Opslaan--}}
{{--                </x-icts.form.button>--}}
{{--            @endif--}}
{{--        </x-slot>--}}
{{--    </x-dialog-modal>--}}

{{--    <x-confirmation-modal id="deleteConfirmation"--}}
{{--                          wire:model.live="showConfirmation">--}}
{{--        <x-slot name="title">Delete record</x-slot>--}}
{{--        <x-slot name="content">Are you sure you want to delete <b>{{ $form->name }}, {{ $form->street_name }} {{ $form->house_number }}</b></x-slot>--}}
{{--        <x-slot name="footer">--}}
{{--            <x-button @click="$wire.showConfirmation = false" class="mr-1 bg-white hover:bg-white focus:bg-white active:bg-white">--}}
{{--                <p class="text-black">Annuleren</p>--}}
{{--            </x-button>--}}
{{--            <x-danger-button--}}
{{--                wire:click="deleteRecord({{ $form->id }})"--}}
{{--                class="mr-1 ml-2">--}}
{{--                Verwijder Locatie--}}
{{--            </x-danger-button>--}}
{{--        </x-slot>--}}

{{--    </x-confirmation-modal>--}}
</div>
