<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('messages.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            New Message
                        </a>
                    </div>

                    @if($messages->isEmpty())
                        <p class="text-gray-500">No messages yet.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($messages as $message)
                                <div class="border p-4 rounded-lg {{ $message->user_id === auth()->id() ? 'bg-blue-50' : 'bg-gray-50' }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold">
                                                {{ $message->user_id === auth()->id() ? 'To: ' . $message->recipient->name : 'From: ' . $message->sender->name }}
                                            </p>
                                            <p class="mt-2">{{ $message->message }}</p>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $message->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 