<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $tweet->user->name }}'s Tweet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800">{{ $tweet->user->name }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $tweet->created_at->format('j M Y H:i a') }}</small>
                            @unless ($tweet->created_at->eq($tweet->updated_at))
                                <small class="text-sm text-gray-600">&middot; {{ __('edited') }}</small>
                            @endunless
                            <p class="mt-4 text-lg text-gray-900">{{ $tweet->content }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('comments.store') }}" method="post" class="p-5">
                        @csrf

                        <textarea name="body" placeholder="Type your reply ..." id="body" class="block w-full border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 rounded-md shadow-sm resize-none">{{ old('body') }}</textarea>
                        <input type="hidden" value="{{ $tweet->id }}" name="tweet_id" id="tweet_id">

                        <x-input-error :messages="$errors->get('body')" class="mt-2"/>
                        <x-primary-button class="mt-4">Send</x-primary-button>
                    </form>

                    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                        @foreach ($comments as $comment)
                            <div class="flex-1 mb-5 p-3">
                                <div class="flex justify-between items-center">
                                    <div>
                                        @if ($comment->user->name === auth()->user()->name)
                                            <span class="text-blue-500 font-semibold">You</span>
                                        @else
                                            <span class="text-gray-500 font-semibold">{{ $tweet->user->name }}</span>
                                        @endif
                                        <small class="ml-2 text-sm text-gray-600">{{ $comment->created_at->format('j M Y H:i a') }}</small>
                                        @unless ($comment->created_at->eq($comment->updated_at))
                                            <small class="text-sm text-gray-600">&middot; {{ __('edited') }}</small>
                                        @endunless
                                    </div>
                                    @if ($comment->user->is(auth()->user()))
                                        <x-dropdown>
                                            <x-slot name="trigger">
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('comments.edit', $comment)" class="text-dark bg-white transition-all ease-in-out duration-150 hover:bg-yellow-600 hover:text-white">
                                                    {{ __('Edit') }}
                                                </x-dropdown-link>
                                                <form action="{{ route('comments.destroy', $comment) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link :href="route('comments.destroy', $tweet)" onclick="event.preventDefault(); this.closest('form').submit();" class="text-dark bg-white transition-all ease-in-out duration-150 hover:bg-red-500 hover:text-white">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    @endif
                                </div>
                                <p class="mt-4 text-lg text-gray-900">{{ $comment->body }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
