<div>
    {{-- show preloader while fetching data in the background --}}
    <div class="fixed top-8 left-1/2 -translate-x-1/2 z-50 animate-pulse"
         wire:loading>
        <x-icts.preloader class="bg-sky-400 text-white border border-lime-700 shadow-2xl">
            {{ $loading }}
        </x-icts.preloader>
    </div>

    @if($children->isEmpty())
        @php
            $contact = $this->fetchContactById($question->contact_id)
        @endphp
        <h2>{{$contact->description}}</h2>
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
            <a href="{{$contact->website}}" class="underline">{{$contact->website}}</a>
        @endif
    @else
        <h1>{{$question->name}}</h1>
        <x-icts.list type="ul" class="list-outside mx-4 text-sm">
            @foreach($children as $child)
                <li>
                    <button
                        wire:click="updateCurrentQuestion({{ $child->id }})"
                        class="text-blue-500 hover:underline">
                        {{ $child->name }}
                    </button>
                </li>
            @endforeach
        </x-icts.list>
    @endif
</div>
