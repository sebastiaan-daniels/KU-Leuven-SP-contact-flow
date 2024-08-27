<div>
    {{-- show preloader while fetching data in the background --}}
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

        .soft_bg {
            background-color: #d4e7f3;
        }

        .contact {
            background-color: #d4e7f3;
        }
        .soft_bg:hover {
            background-color: #147fa1;
            color: white;
        }
    </style>


    @if($children->isEmpty())
        @php
            $contact = $this->fetchContactById($question->contact_id)
        @endphp
        <h2>{{$contact->description}}</h2>
    <div class="contact">
        <div class="ml-3 py-3">
            <h3>{{$contact->name}}</h3>
            @if(!is_null($contact->email))
                <h4>Email:</h4>
                <a href="mailto:{{$contact->email}}" class="underline">{{$contact->email}}</a>
            @endif
            @if(!is_null($contact->phone))
                <h4>Telefoon</h4>
                <p>{{$contact->phone}}</p>
            @endif
            @if(!is_null($contact->website))
                <h4>Website</h4>
                <a href="{{$contact->website}}" class="underline break-words">{{$contact->website}}</a>
            @endif
        </div>

    </div>

    @else
        <h1 class="w-full">{{$question->child_question}}</h1>
        <x-icts.list type="ul" class="list-none text-sm">
            @foreach($children as $child)
                <li>
                    @csrf
                    <button
                        wire:click="updateCurrentQuestion({{ $child->id }})"
                        class="w-full sm:w-96 soft_bg text-black py-4 my-1 px-6 hover:bg-blue-600
                         transition duration-300 shadow-sm underline">
                        {{ $child->name }}
                    </button>
                </li>

            @endforeach
        </x-icts.list>
    @endif
</div>
