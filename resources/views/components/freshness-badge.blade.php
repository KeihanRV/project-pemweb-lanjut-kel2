@php
    $normalized = strtolower($status ?? '');
    $map = [
        'segar'           => ['label' => 'Segar',   'class' => 'bg-[#22C55E]/20 text-[#22C55E]'],
        'busuk'           => ['label' => 'Busuk',   'class' => 'bg-[#EC221F] text-white'],
        // 'tidak segar'     => ['label' => 'Busuk',   'class' => 'bg-[#EC221F] text-white'],
        // 'tidak diketahui' => ['label' => 'Unknown', 'class' => 'bg-gray-200 text-gray-600'],
        'unknown'         => ['label' => 'Unknown', 'class' => 'bg-gray-200 text-gray-600'],
    ];
    $badge = $map[$normalized] ?? ['label' => 'Unknown', 'class' => 'bg-gray-200 text-gray-600'];
@endphp

<span class="{{ $badge['class'] }} px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide">
    {{ $badge['label'] }}
</span>
