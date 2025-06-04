<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table table-hover table-bordered w-full align-middle">
                        <thead class="bg-primary text-primary-content">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Chat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-blue-50">
                                    <td class="py-2 px-3">{{ $user->id }}</td>
                                    <td class="py-2 px-3 font-semibold">{{ $user->name }}</td>
                                    <td class="py-2 px-3">{{ $user->email }}</td>
                                    <td class="py-2 px-3">{{ $user->created_at }}</td>
                                    <td class="py-2 px-3 text-center">
                                        <a href="{{ url('chat/' . $user->id) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="fa fa-comments fa-lg"></i> Chat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
