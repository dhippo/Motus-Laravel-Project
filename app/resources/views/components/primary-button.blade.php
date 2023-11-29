<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-motuscolors-green hover:bg-motuscolors-green2 inline-flex items-center px-4 py-2 border border-transparent rounded-md  text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
@vite(['resources/css/app.css', 'resources/js/app.js'])
