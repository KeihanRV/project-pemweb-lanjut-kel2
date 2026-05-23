@props(['href' => '#', 'target' => null, 'text' => null])

@if($text)
    <a href="{{ $href }}" @if($target) target="{{ $target }}" @endif {{ $attributes->merge(['class' => 'text-slate-700 hover:underline']) }}>{{ $text }}</a>
@else
    <a href="{{ $href }}" @if($target) target="{{ $target }}" @endif {{ $attributes->merge(['class' => 'text-slate-700 hover:underline']) }}>{{ $slot }}</a>
@endif
