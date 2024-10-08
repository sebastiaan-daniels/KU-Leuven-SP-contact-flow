<div>
    {{-- show preloader while fetching data in the background --}}
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
         wire:loading>
        <x-icts.preloader class="bg-sky-400 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-icts.preloader>
    </div>

    {{--    Dit toont de hulpsectie. Als je op het icoon drukt, gaat het open en sluit het.--}}
    <div
        x-data="{open:false}"
        class="p-0 mb-4 flex flex-col gap-2">

        <div class="flex justify-start">
            <div class="px-4">
                <x-heroicon-o-information-circle
                    @click="open =!open"
                    class="w-5 text-gray-400 cursor-pointer outline-0"/>
            </div>
        </div>

        <div
            x-show="open"
            x-transition
            style="display: none"
            class="text-sky-900 bg-sky-50 border-t p-4">
            <x-icts.list type="ul" class="list-outside mx-4 text-sm">
                <li>
                    Deze pagina wordt gebruikt voor het beheren van de <b>vragen</b>.
                </li>
                <li>
                    Druk op
                    <b>NIEUWE OPTIE</b>
                    om een Optie & Vervolgvraag-of contact <b>toe te voegen</b>.
                </li>
                <li>
                    Druk op het
                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                    icoon om een optie te <b>bewerken</b>.
                </li>
                <li>
                    Druk op het
                    <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                    icoon om een optie te <b>verwijderen</b>.
                </li>
            </x-icts.list>
        </div>
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
            Nieuwe optie
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
                <span data-tippy-content="Sorteer op ID">Naam van de Optie</span>
                <x-heroicon-s-chevron-up
                    class="w-5 text-slate-400
                {{$orderAsc ?: 'rotate-180'}}
                {{$orderBy === 'id' ? 'inline-block' : 'hidden'}}
            "/>
            </th>
            <th>Vorige Optie</th>
            <th>Volgende Vraag</th>
            <th>Volgend Contact </th>
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
                    $contactName = null;
                } else {
                    $contactName = $contact->name;
                }

                $parent = $this->fetchQuestionFromId($question->parent_id);
                if (is_null($parent)) {
                    $parentName = 'Eerste vraag';
                } else {
                    $parentName = $parent->id . ': ' . $parent->name;
                }

                $questionType = $this->fetchTypeFromQuestionID($question->id);
            @endphp
            @if(is_null($question->child_question)  && is_null($contactName))
                <tr class="border-t border-gray-300 [&>td]:p-2 bg-red-300">
            @elseif($questionType->type === 'important')
                <tr class="border-t border-gray-300 [&>td]:p-2 bg-yellow-300">
            @else
                <tr class="border-t border-gray-300 [&>td]:p-2">
            @endif
                <td class="text-left">{{ $question->id }}</td>
                <x-icts.cutlongtext>
                    <x-slot name="data">{{$question->name}}</x-slot>
                </x-icts.cutlongtext>
                <x-icts.cutlongtext>
                    <x-slot name="data">{{$parentName}}</x-slot>
                </x-icts.cutlongtext>
                <x-icts.cutlongtext>
                    <x-slot name="data">{{$question->child_question ?? '/'}}</x-slot>
                </x-icts.cutlongtext>
                <x-icts.cutlongtext>
                    <x-slot name="data">{{$contactName ?? '/'}}</x-slot>
                </x-icts.cutlongtext>
                <td></td>
                <td>
                    <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-2 h-10">
                        <button
                            wire:click="editQuestion({{ $question->id }})"
                            class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300">
                            <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                        </button>
                        @if($question->id === 1)
                            <button disabled
                                class="text-gray-400 bg-red-400">
                                <span data-tippy-content="Je kan de eerste vraag niet verwijderen">
                                <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                            </span>

                            </button>
                        @else
                            <button
                                wire:click="confirmation({{ $question->id }})"
                                class="text-gray-400 hover:text-red-100 hover:bg-red-500 transition">
                                <x-phosphor-trash-duotone class="inline-block w-5 h-5"/>
                            </button>
                        @endif

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
                <h2>Vraag/Optie aanmaken</h2>
            @else
                <h2>Vraag/Optie aanpassen</h2>
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
                    @if(!is_null($form->parent_id) || is_null($form->id))
                        <x-label for="parent" value="Vorige vraag" class="mt-4"/>
                        <x-icts.form.select wire:model="form.parent_id" id="parent" class="block w-30">
                            <option value="">Selecteer vorige vraag (parent)</option>
                            @foreach($nonEndingQuestions as $parent)
                                <option value="{{ $parent->id }}">{{$parent->id}}: {{ $parent->name }}</option>
                            @endforeach
                        </x-icts.form.select>
                    @endif

                    <x-label for="name" value="Naam van de optie" class="mt-4"/>
                    <x-input id="name" type="text"
                             wire:model="form.name"
                             class="mt-1 block w-full"/>
                    @if(!is_null($form->parent_id) || is_null($form->id))
                        <x-label for="q_type" value="Vraag Type" class="mt-4"/>
                        <x-icts.form.select wire:model="form.type_id" id="q_type" class="block w-30">
                            <option value="">Selecteer het vraag type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id}}">{{$type->type}}</option>
                            @endforeach
                        </x-icts.form.select>
                    @endif
{{--                        Volgende vragen--}}
                    <hr class="border-2 my-8">
                    <x-label for="child_question" value="Volgende vraag" class="mt-4"/>
                    <x-input id="child_question" type="text"
                                          wire:model="form.child_question"
                                          class="mt-1 block w-full"/>

                    <h3>OF*</h3>
                    <x-label for="contact_id" value="Contactinfo na selectie" class="mt-4"/>
                    <x-icts.form.select wire:model="form.contact_id" id="contact_id" class="block w-30">
                        <option value="">Selecteer de contactinfo na deze optie</option>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                        @endforeach
                    </x-icts.form.select>
                    <p><span class="italic">*je kan enkel de volgende vraag ingeven of een contactpunt selecteren. Niet allebei.</span></p>

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
        <x-slot name="content">
            <p>
                Ben je zeker dat je  <b>{{ $form->name }}</b> wilt verwijderen?
            </p>
            @if($this->countChildren($form->id) >= 1)
                <p class="mt-1">
                    <b>OPGELET:</b> er zijn <b>{{$this->countChildren($form->id)}}</b> vragen direct verbonden aan deze
                    vraag. Zij <b>(en de vervolgvragen)</b> zullen
                    allemaal verwijderd worden!
                </p>
            @endif

        </x-slot>
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
