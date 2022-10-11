<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tweets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('tweets.store') }}" method="post" class="p-5">
                        @csrf

                        <textarea name="content" placeholder="What's on your mind?" id="content" class="block w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 rounded-md shadow-sm resize-none">{{ old('content') }}</textarea>

                        <x-input-error :messages="$errors->get('content')" class="mt-2"/>
                        <x-primary-button class="mt-4">Tweet</x-primary-button>
                    </form>

                    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                        @foreach ($tweets as $tweet)
                            <div class="flex-1 mb-5 p-3">
                                <div class="flex justify-between items-center">
                                    <div>
                                        @if ($tweet->user->name === auth()->user()->name)
                                            <span class="text-blue-500 font-semibold">You</span>
                                        @else
                                            <span class="text-gray-500 font-semibold">{{ $tweet->user->name }}</span>
                                        @endif
                                        <small class="ml-2 text-sm text-gray-600">{{ $tweet->created_at->format('j M Y H:i:s a') }}</small>
                                        @unless ($tweet->created_at->eq($tweet->updated_at))
                                            <small class="text-sm text-gray-600">&middot; {{ __('edited') }}</small>
                                        @endunless
                                    </div>
                                    @if ($tweet->user->is(auth()->user()))
                                        <x-dropdown>
                                            <x-slot name="trigger">
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('tweets.edit', $tweet)" class="text-dark bg-white transition-all ease-in-out duration-150 hover:bg-yellow-600 hover:text-white">
                                                    {{ __('Edit') }}
                                                </x-dropdown-link>
                                                <form action="{{ route('tweets.destroy', $tweet) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link :href="route('tweets.destroy', $tweet)" onclick="event.preventDefault(); this.closest('form').submit();" class="text-dark bg-white transition-all ease-in-out duration-150 hover:bg-red-500 hover:text-white">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>

                                    @endif
                                </div>
                                <p class="mt-4 text-lg text-gray-900">{{ $tweet->content }}</p>
                                <a class="mt-3 flex items-center justify-start" href="{{ route('tweets.show', $tweet) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    @if ($tweet->comments->count() > 0)
                                        <small class="ml-2 mt-1">{{ $tweet->comments->count() }}</small>
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
