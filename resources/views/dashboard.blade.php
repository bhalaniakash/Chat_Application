<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6fb;
        }
        .table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid #007bff;
            color: #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }
        small{
            color: #6c757d;
            
        }
       
        </style>
</head>
<body>
    
    <head>
        
        </head>

        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </x-slot>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6 text-gray-900">
                            <table class="table table-hover table-bordered w-full align-middle">
                                <thead class="bg-primary text-primary-content">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <!-- <th scope="col">Email</th> -->
                                        <th scope="col">Created At</th>
                                        <th scope="col">Chat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr class="hover:bg-blue-50">
                                    <td class="py-2 px-3">{{ $user->id }} </td>
                                    <td class="py-2 px-3 font-semibold">{{ $user->name }} <br><i><small>{{ $user->email }}</small></i></td>
                                    <!-- <td class="py-2 px-3">{{ $user->email }}</td> -->
                                    <td class="py-2 px-3">{{ $user->created_at  }}</td>
                                    <td class="py-2 px-3 text-center">
                                        <a href="{{ url('chat/' . $user->id) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="fa fa-comments fa-lg"></i>
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

</body>
</html>