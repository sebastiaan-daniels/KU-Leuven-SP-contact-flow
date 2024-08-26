<div>
    {{-- show preloader while fetching data in the background --}}
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
         wire:loading>
        <x-icts.preloader class="bg-sky-400 text-white border border-lime-700 shadow-2xl">
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
                            color-off="bg-red-500 before:line-through text-white"
                            text-on="Actief"
                            color-on="text-white bg-sky-500"
                            class="w-20 h-auto" />
        <x-button class="primary" wire:click="newQuestion()">
            Nieuwe vraag
        </x-button>
    </div>

    <div class="my-4">{{ $questions->links() }}</div>
    <table class="mt-3 text-center w-full">
        <colgroup>
            <col class="w-12">
            <col class="w-72">
            <col class="w-72">
            <col class="w-72">
            <col class="w-72">
            <col class="w-auto">
            <col class="w-36">
        </colgroup>
        <thead>
        <tr class="mt-3 text-left w-full">
            <th><span data-tippy-content="Interne ID in de database">ID</span></th>
            <th wire:click="resort('id')">
                <span data-tippy-content="Sorteer op ID">Name</span>
                <x-heroicon-s-chevron-up
                    class="w-5 text-slate-400
                {{$orderAsc ?: 'rotate-180'}}
                {{$orderBy === 'name' ? 'inline-block' : 'hidden'}}
            "/>
            </th>
            <th>Question</th>
            <th>Parent_id</th>
            <th>Contact_id </th>
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
        @forelse($questions as $question)
            @php
                $contact = $this->fetchContactFromId($question->contact_id);
                if (is_null($contact)) {
                    $contactName = '/';
                } else {
                    $contactName = $contact->name;
                }
            @endphp
            <tr class="border-t border-gray-300 [&>td]:p-2">
                <td class="text-left">{{ $question->id }}</td>
                <td class="text-left">{{ $question->name }}</td>
                <td class="text-left">{{ $question->child_question ?? '/'}}</td>
                <td class="text-left">{{ $question->parent_id ?? 'Eerste vraag'}}</td>
                <td class="text-left">{{$contactName}}</td>
                <td></td>
                <td>
                    <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                        <button
                            wire:click="editQuestion({{ $question->id }})"
                            class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300">
                            <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                        </button>
                        <button
                            wire:click="confirmation({{ $question->id }})"
                            class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                            <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                    <div class="font-bold italic text-sky-800">Geen contacten gevonden</div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="my-4">{{ $questions->links() }}</div>

    {{-- Modal for add and update record --}}
    <x-dialog-modal id="contactModal"
                    wire:model.live="showModal">
        @php
            $nonEndingQuestions = $this->fetchNonEndingQuestions()
        @endphp
        <x-slot name="title">
            @if(is_null($form->id))
                <h2>Vraag aanmaken</h2>
            @else
                <h2>Vraag aanpassen</h2>
            @endif
        </x-slot>
        <x-slot name="content">
            {{--             error messages --}}
            @if ($errors->any())
                <x-icts.alert type="danger">
                    <x-icts.list>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </x-icts.list>
                </x-icts.alert>
            @endif

            <div class="flex flex-row gap-4 mt-4">
                <div class="flex-1 flex-col gap-2">
                    <x-label for="name" value="Naam" class="mt-4"/>
                    <x-input id="name" type="text"
                             wire:model="form.name"
                             class="mt-1 block w-full"/>
                    <x-label for="parent" value="Vorige vraag" class="mt-4"/>
                    <x-icts.form.select wire:model="form.parent_id" id="parent" class="block w-30">
                        <option value="null">Selecteer "Parent"</option>
                        @foreach($nonEndingQuestions as $parent)
                            <option value="{{ $parent->id }}">{{$parent->id}}: {{ $parent->name }}</option>
                        @endforeach
                    </x-icts.form.select>
                    <x-label for="child_question" value="Volgende vraag" class="mt-4"/>
                    <x-input id="child_question" type="text"
                                          wire:model="form.child_question"
                                          class="mt-1 block w-full"/>


                    <x-label for="contact_id" value="Contactinfo na selectie" class="mt-4"/>
                    <x-icts.form.select wire:model="form.contact_id" id="contact_id" class="block w-30">
                        <option value="null">Selecteer de contactinfo na deze optie</option>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                        @endforeach
                    </x-icts.form.select>

{{--                    <x-input id="contact" type="text"--}}
{{--                             wire:model="form.contact_id"--}}
{{--                             class="mt-1 block w-full"/>--}}
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button @click="$wire.showModal = false">Annuleren</x-secondary-button>
            @if(is_null($form->id))
                <x-icts.form.button color="info"
                                    wire:click="createQuestion({{ $form->id }})"
                                    class="ml-2">Aanmaken
                </x-icts.form.button>
            @else
                <x-icts.form.button color="info"
                                    wire:click="updateQuestion({{ $form->id }})"
                                    class="ml-2">Opslaan
                </x-icts.form.button>
            @endif
        </x-slot>
    </x-dialog-modal>

    <x-confirmation-modal id="deleteConfirmation"
                          wire:model.live="showConfirmation">
        <x-slot name="title">Verwijder record</x-slot>
        <x-slot name="content">Ben je zeker dat je  <b>{{ $form->name }}</b> wilt verwijderen?</x-slot>
        <x-slot name="footer">
            <x-button @click="$wire.showConfirmation = false" class="mr-1 bg-white hover:bg-white focus:bg-white active:bg-white">
                <p class="text-black">Annuleren</p>
            </x-button>
            <x-danger-button
                wire:click="deleteRecord({{ $form->id }})"
                class="mr-1 ml-2">
                Verwijder Vraag
            </x-danger-button>
        </x-slot>

    </x-confirmation-modal>
</div>
