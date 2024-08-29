@php
    $maxLength = 51;
    $partOne = substr($data, 0, $maxLength);
    $partTwo = substr($data, $maxLength);

    $tooLong = strlen($partTwo) > 0;

    if (strlen($partTwo > 0)) {
        $partOne = $partOne . ' [..]';
        $partTwo = '[...] ' . $partTwo;
    }
@endphp

@if(!$tooLong)
    <td class="text-left">{{ $data }}</td>
@else
    <td class="text-left"><span data-tippy-content="{{$partTwo}}">{{$partOne}}</span></td>
@endif

