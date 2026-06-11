@props(['title', 'value', 'subtitle', 'color', 'icon'])

@php
    $colorClasses = [
        'purple' => 'bg-purple-50 text-purple-600',
        'sky' => 'bg-sky-50 text-sky-500',
        'amber' => 'bg-amber-50 text-amber-500',
        'emerald' => 'bg-emerald-50 text-emerald-500',
    ];
    $iconClass = $colorClasses[$color] ?? $colorClasses['purple'];
@endphp

<div class="bg-white rounded-[24px] p-5 shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition-shadow">
    <div class="w-[52px] h-[52px] rounded-[18px] {{ $iconClass }} flex items-center justify-center shrink-0">
        {!! $icon !!}
    </div>
    <div>
        <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-0.5">{{ $title }}</p>
        <p class="text-2xl font-extrabold text-gray-900 leading-none">{{ $value }}</p>
        <p class="text-[10px] text-gray-400 mt-1 font-medium">{{ $subtitle }}</p>
    </div>
</div>
