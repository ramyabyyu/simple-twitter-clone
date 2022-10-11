<x-app-layout>
    <x-slot name='header'>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tweets Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('tweets.update', $tweet) }}" method="post" class="p-5">
                        @csrf
                        @method('patch')

                        <textarea name="content" placeholder="What's on your mind?" id="content" class="block w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 rounded-md shadow-sm resize-none">{{ old('content', $tweet->content) }}</textarea>

                        <x-input-error :messages="$errors->get('content')" class="mt-2"/>
                        <button class="px-4 py-2 rounded-md text-xs text-white border focus:outline-none transition ease-in-out duration-150 tracking-widest font-semibold uppercase bg-blue-500 focus:ring focus:ring-blue-300 hover:bg-transparent hover:text-blue-500 disabled:opacity-25 mt-4 hover:border hover:border-blue-500" type="submit">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
