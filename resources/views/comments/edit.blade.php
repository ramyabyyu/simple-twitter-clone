<x-app-layout>
    <x-slot name='header'>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comment Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('comments.update', $comment) }}" method="post" class="p-5">
                        @csrf
                        @method('patch')

                        <textarea name="body" placeholder="Type your comment" id="body" class="block w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 rounded-md shadow-sm resize-none">{{ old('body', $comment->body) }}</textarea>

                        <x-input-error :messages="$errors->get('body')" class="mt-2"/>
                        <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
