@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border-gray-200 focus:border-forest-500 focus:ring-forest-500 rounded-xl shadow-sm px-4 py-2.5 text-sm']) }}>
