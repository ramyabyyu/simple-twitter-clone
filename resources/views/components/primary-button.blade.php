<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 rounded-md text-xs text-white border focus:outline-none transition ease-in-out duration-150 tracking-widest font-semibold uppercase bg-blue-500 focus:ring focus:ring-blue-300 hover:bg-transparent hover:text-blue-500 disabled:opacity-25 hover:border hover:border-blue-500']) }}>
    {{ $slot }}
</button>
