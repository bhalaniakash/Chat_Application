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
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #10b981;
            --dark: #0f172a;
            --dark-2: #1e293b;
            --dark-3: #334155;
            --light: #ffffff;
            --light-1: #f1f5f9;
            --light-2: #e2e8f0;
            --light-3: #cbd5e1;
            --danger: #ef4444;
            --warning: #f59e0b;
            --glass: rgba(255, 255, 255, 0.08);
            --glass-2: rgba(255, 255, 255, 0.15);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
            --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--dark);
            color: var(--light);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 30px;
            border-radius: 24px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: gradientShift 15s ease-in-out infinite alternate;
        }

        @keyframes gradientShift {
            0% { transform: scale(1); }
            100% { transform: scale(1.2); }
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .dashboard-header h2 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
        }

        .dashboard-header h2 i {
            font-size: 1.8rem;
        }

        .header-stats {
            display: flex;
            gap: 20px;
            margin-top: 15px;
        }

        .stat-item {
            background: var(--glass);
            padding: 12px 20px;
            border-radius: 16px;
            backdrop-filter: blur(8px);
            border: 1px solid var(--glass-2);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
        }

        .stat-label {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.8);
        }

        .users-table {
            background: var(--light);
            border-radius: 24px;
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid var(--light-2);
            backdrop-filter: blur(12px);
            position: relative;
        }

        .users-table::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .table {
            margin: 0;
            width: 100%;
        }

        .table thead th {
            background: var(--primary);
            color: var(--light);
            font-weight: 500;
            padding: 20px;
            border: none;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            transition: var(--transition);
            border-bottom: 1px solid var(--light-2);
        }

        .table tbody tr:hover {
            background: var(--light-1);
            transform: translateY(-2px);
        }

        .table td {
            padding: 20px;
            vertical-align: middle;
            color: var(--dark);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 1.2rem;
            box-shadow: var(--shadow-sm);
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 4px;
            font-size: 1.1rem;
        }

        .user-email {
            color: var(--dark-3);
            font-size: 0.9rem;
        }

        .user-id {
            background: var(--light-1);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--dark-3);
            font-family: monospace;
        }

        .user-date {
            color: var(--dark-3);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-date i {
            color: var(--primary-light);
        }

        .chat-btn {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            box-shadow: var(--shadow-sm);
        }

        .chat-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            color: white;
        }

        .chat-btn i {
            font-size: 1.1rem;
        }

        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 16px 20px;
            padding-left: 20px;
            background: var(--light-1);
            border: 1px solid var(--light-2);
            border-radius: 16px;
            color: var(--dark);
            font-size: 1rem;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .search-input::placeholder {
            color: var(--dark-3);
            opacity: 0.7;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            background: var(--light);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-light);
            font-size: 1.1rem;
            pointer-events: none;
        }

        /* Animated background elements */
        .bg-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-element {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
        }

        .bg-element-1 {
            width: 300px;
            height: 300px;
            background: var(--primary);
            top: 20%;
            left: 10%;
            animation: float 8s ease-in-out infinite;
        }

        .bg-element-2 {
            width: 400px;
            height: 400px;
            background: var(--secondary);
            bottom: 10%;
            right: 10%;
            animation: float 10s ease-in-out infinite reverse;
        }

        .bg-element-3 {
            width: 200px;
            height: 200px;
            background: var(--warning);
            top: 60%;
            left: 30%;
            animation: float 12s ease-in-out infinite alternate;
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            50% { transform: translate(-5%, 5%); }
            100% { transform: translate(5%, -5%); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 10px;
            }

            .dashboard-header {
                padding: 20px;
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .header-stats {
                flex-direction: column;
                width: 100%;
            }

            .stat-item {
                width: 100%;
            }

            .table td {
                padding: 15px;
            }

            .user-info {
                flex-direction: column;
                text-align: center;
            }

            .chat-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Add these new styles for dropdown */
        .dropdown-item {
            transition: var(--transition);
            padding: 0.75rem 1.5rem;
        }

        .dropdown-item:hover {
            background: var(--glass-2);
            color: var(--primary-light) !important;
            transform: translateX(5px);
        }

        .dropdown-item i {
            transition: var(--transition);
        }

        .dropdown-item:hover i {
            transform: scale(1.1);
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: var(--glass);
        }

        .dropdown-menu {
            padding: 0.5rem 0;
            min-width: 200px;
        }
    </style>
</head>
<body>
    <!-- Animated background elements -->
    <div class="bg-elements">
        <div class="bg-element bg-element-1"></div>
        <div class="bg-element bg-element-2"></div>
        <div class="bg-element bg-element-3"></div>
    </div>

    <!-- Custom Header -->
    <nav class="navbar navbar-expand-lg" style="background: var(--dark-2); padding: 1rem 2rem; border-bottom: 1px solid var(--glass);">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}" style="color: var(--light); font-size: 1.5rem; font-weight: 600;">
                <i class="fas fa-comments me-2"></i>Chat App
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--light); background: var(--glass); border: 1px solid var(--glass-2);">
                        <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="background: var(--dark-2); border: 1px solid var(--glass);">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item" style="color: var(--light);">
                                <i class="fas fa-user-cog me-2"></i>Profile Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider" style="border-color: var(--glass);"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" style="color: var(--light);">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="header-content">
                <h2>
                    <i class="fas fa-users"></i>
                    {{ __('Dashboard') }}
                </h2>
                <div class="header-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ count($users) }}</span>
                            <span class="stat-label">Total Users</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">{{ count($users) - 1 }}</span>
                            <span class="stat-label">Active Chats</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="search-box">
            
            <input type="text" class="search-input" placeholder="Search users..." id="searchInput">
        </div>

        <div class="users-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <span class="user-id">#{{ $user->id }}</span>
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="user-details">
                                    <span class="user-name">{{ $user->name }}</span>
                                    <span class="user-email">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Search functionality
            $('#searchInput').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.table tbody tr').each(function() {
                    const userName = $(this).find('.user-name').text().toLowerCase();
                    const userEmail = $(this).find('.user-email').text().toLowerCase();
                    const userId = $(this).find('.user-id').text().toLowerCase();
                    
                    if (userName.includes(searchTerm) || 
                        userEmail.includes(searchTerm) || 
                        userId.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Add hover effect to table rows
            $('.table tbody tr').hover(
                function() {
                    $(this).find('.chat-btn').css('transform', 'translateY(-2px)');
                },
                function() {
                    $(this).find('.chat-btn').css('transform', 'translateY(0)');
                }
            );

            // Add animation to stat items
            $('.stat-item').each(function(index) {
                $(this).css({
                    'animation-delay': `${index * 0.2}s`,
                    'opacity': '0',
                    'transform': 'translateY(20px)'
                }).animate({
                    'opacity': '1',
                    'transform': 'translateY(0)'
                }, 500);
            });
        });
    </script>
</body>
</html>