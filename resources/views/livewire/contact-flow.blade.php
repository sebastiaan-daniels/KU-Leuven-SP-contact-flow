<div>
    <style>
{{--        ICTS Style guide, not gonna bother tailwinding this--}}

        html {
            font-size: 1.15rem;
            background-color: white;
        }
        h1,h2,h4 {
            font-family: Source Serif Pro,serif;
            font-weight: 400;
            line-height: 1.15;
            color: #004070;
            margin-top: 1.625rem;
            margin-bottom: .8125rem;
            font-size: 1.6rem;
        }

        .iconcolor {
            color: #004070;
        }
        .soft_bg {
            background-color: #d4e7f3;
            word-break: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }

        .important_bg {
            background-color: #ed1c1c;
            word-break: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }

        .important_bg:hover {
            background-color: #ab0000;
        }

        .contact {
            background-color: #d4e7f3;
            word-break: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }
        .soft_bg:hover {
            background-color: #147fa1;
            color: white;
        }
    </style>


    @if($children->isEmpty())
        @php
            $contact = $this->fetchContactById($question->contact_id);

        // Dit betekend dat er geen child questions zijn, maar ook geen contact
        // Dit gebeurd wanneer men een vervolgvraag invult op een optie, maar geen verdere opties aanmaakt
        // Skill issue van de vragenbeheerder dus, maar we gaan hem toch opvangen
            if(is_null($contact)) {
                // We halen het eerste contact op, dit is Waarschijnlijk het servicepunt
                $contact = $this->fetchContactById(1);
            }
        @endphp

        <div class="container mx-auto py-4 text-sm sm:flex sm:justify-between sm:items-center">
            <h2>{{$contact->description}}</h2>
            <div >
                <button
                    wire:click="goBack(1)"
                    class="w-full sm:w-32 soft_bg text-black py-4 my-1 px-6 hover:bg-blue-600
                                 transition duration-300 shadow-sm underline flex items-center text-left">
                    <x-eva-home-outline class="h-6 w-6 mr-2 iconcolor"/>
                    Terug
                </button>
            </div>
        </div>


        <div class="contact">
            <div class="ml-3 py-3">
                <h3>{{$contact->name}}</h3>
                @if(!is_null($contact->email))
                    <h4>Email:</h4>

                    <div class="flex">
                        <x-eva-email-outline class="h-6 w-6 mr-2 iconcolor"/>
                        <a href="{{$contact->email}}" class="underline ">contact</a>
                    </div>

                @endif
                @if(!is_null($contact->phone))
                    <h4>Telefoon</h4>
                    <div class="flex">
                        <x-eva-phone-outline class="h-6 w-6 mr-2 iconcolor"/>
                        <p>{{$contact->phone}}</p>
                    </div>

                @endif
                @if(!is_null($contact->website))
                    <h4>Website</h4>
                    <div class="flex">
                        <x-eva-globe-outline class="h-6 w-6 mr-2 iconcolor"/>
                        <a href="{{$contact->website}}" class="underline break-words">{{$contact->website}}</a>
                    </div>

                @endif
                @if(!is_null($contact->extra))
                    <h4>Bijkomende informatie</h4>
                    <div class="flex">
                        <p>{{$contact->extra}}</p>
                    </div>

                @endif

            </div>
        </div>


    @else
        <h1 class="w-full">{{$question->child_question}}</h1>
        <x-icts.list type="ul" class="list-none text-sm">
{{--            Aan de toekomstige maintainer:
                2 keer loopen is uiteraard niet de beste manier om belangrijke vragen bovenaan te displayen.
                Dit zou eigenlijk in de controller moeten, niet in de view. Maar hier had ik geen tijd voor.--}}
            @foreach($children as $child)
                @php
                $type = $this->fetchTypeFromQuestionID($child->id);
                 @endphp
                @if($type->type === 'important')
                    <li>
                        @csrf
                        <button
                            wire:click="updateCurrentQuestion({{ $child->id }})"
                            class="w-full sm:w-96 important_bg text-white font-bold py-4 my-1 px-6 hover:bg-blue-600
                         transition duration-300 shadow-sm underline flex items-center text-left">
                            <x-ionicon-warning class="h-6 w-6 mr-2 text-white"/>
                            {{ $child->name }}
                            <x-ionicon-warning class="h-6 w-6 mx-2 text-white"/>
                        </button>
                    </li>
                @endif
            @endforeach
            @foreach($children as $child)
                @php
                    $type = $this->fetchTypeFromQuestionID($child->id);
                @endphp
                @if($type->type !== 'important')
                    <li>
                        @csrf
                        <button
                            wire:click="updateCurrentQuestion({{ $child->id }})"
                            class="w-full sm:w-96 soft_bg text-black py-4 my-1 px-6 hover:bg-blue-600
                         transition duration-300 shadow-sm underline flex items-center text-left">
                            {{ $child->name }}
                        </button>
                    </li>
                @endif
            @endforeach

            @if(!is_null($question->parent_id))
                    <li>
                        <button
                            wire:click="goBack({{ $question->id}})"
                            class="w-full sm:w-96 soft_bg text-black py-4 my-1 px-6 hover:bg-blue-600
                         transition duration-300 shadow-sm underline flex items-center text-left">
                            <x-letsicon-back class="h-6 w-6 mr-2 iconcolor"/>
                            Vorige vraag
                        </button>
                    </li>
            @endif


        </x-icts.list>
    @endif
</div>
