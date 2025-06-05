<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --gray-color: #adb5bd;
            --light-gray: #e9ecef;
            --white-color: #ffffff;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6fb;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white-color);
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%),
                        linear-gradient(-45deg, rgba(255,255,255,0.1) 25%, transparent 25%),
                        linear-gradient(45deg, transparent 75%, rgba(255,255,255,0.1) 75%),
                        linear-gradient(-45deg, transparent 75%, rgba(255,255,255,0.1) 75%);
            background-size: 20px 20px;
            opacity: 0.1;
        }

        .dashboard-header h2 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dashboard-header h2 i {
            font-size: 1.5rem;
        }

        .users-table {
            background: var(--white-color);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table {
            margin: 0;
            width: 100%;
            text-align: center;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white-color);
            font-weight: 500;
            padding: 16px 20px;
            border: none;
            font-size: 0.95rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
            transform: translateY(-1px);
        }

        .table td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid var(--light-gray);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 4px;
        }

        .user-email {
            color: var(--gray-color);
            font-size: 0.85rem;
            font-style: italic;
        }

        .user-date {
            color: var(--gray-color);
            font-size: 0.9rem;
        }

        .chat-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white-color);
            border: none;
            border-radius: 50px;
            padding: 8px 16px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .chat-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
            color: var(--white-color);
        }

        .chat-btn i {
            font-size: 1rem;
        }

        .user-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            background: var(--light-gray);
            color: var(--dark-color);
        }

        .user-status.online {
            background: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
        }

        .user-status i {
            font-size: 0.75rem;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 10px;
            }

            .table td {
                padding: 12px 15px;
            }

            .chat-btn {
                padding: 6px 12px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <x-app-layout>
        <div class="dashboard-container">
            <div class="dashboard-header">
                <h2>
                    <i class="fas fa-users"></i>
                    {{ __('Dashboard') }}
                </h2>
            </div>

            <div class="users-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>User</th>
                            <!-- <th>Status</th> -->
                            <th>Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <span>{{ $user->id }}</span>
                            </td>
                            <td>
                                <div class="user-info">
                                    <span class="user-name">{{ $user->name }}</span>
                                    <span class="user-email">{{ $user->email }}</span>
                                </div>
                            </td>
                            <!-- <td>
                                <span class="user-status {{ $user->id == Auth::id() ? 'online' : '' }}">
                                    <i class="fas fa-circle"></i>
                                    {{ $user->id == Auth::id() ? 'Online' : 'Offline' }}
                                </span>
                            </td> -->
                            <td>
                                <span class="user-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $user->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ url('chat/' . $user->id) }}" class="chat-btn">
                                    <i class="fas fa-comments"></i>
                                    Chat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-app-layout>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add hover effect to table rows
            $('.table tbody tr').hover(
                function() {
                    $(this).find('.chat-btn').css('transform', 'translateY(-2px)');
                },
                function() {
                    $(this).find('.chat-btn').css('transform', 'translateY(0)');
                }
            );
        });
    </script>
</body>
</html>