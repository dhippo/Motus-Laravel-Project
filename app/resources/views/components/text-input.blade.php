@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-[3px] border-motuscolors-back400 bg-motuscolors-back50 focus:bg-white text-gray-900 rounded-md shadow-sm p-2 text-black']) !!}>
@vite(['resources/css/app.css', 'resources/js/app.js'])
