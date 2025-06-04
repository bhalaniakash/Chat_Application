<!DOCTYPE html>
<html>
<head>
    <title>Chat Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .chat-box {
            height: 400px;
            width: 100%;
            overflow-y: auto;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 15px;
        }
        .chat-message {
            margin-bottom: 15px;
        }
        .chat-message .message-content {
            max-width: 85%;
            padding: 10px 15px;
            border-radius: 18px;
            position: relative;
            word-break: break-word;
        }
        .chat-message.sender .message-content {
            background-color: #0d6efd;
            color: #fff;
            margin-left: auto;
        }
        .chat-message.receiver .message-content {
            background-color: #e9ecef;
            color: #212529;
            margin-right: auto;
        }
        .chat-message .user {
            font-weight: bold;
            font-size: 0.85rem;
            color: #495057;
            margin-bottom: 2px;
        }
        .chat-message.sender .user {
            color: #0a58ca;
        }
        .chat-message.receiver .user {
            color: #198754;
        }
        .chat-message .time {
            font-size: 0.75rem;
            color: #adb5bd;
            margin-top: 3px;
        }
        .card-header {
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .card-footer {
            padding: 1rem;
            background: #fff;
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        .form-control {
            border-radius: 50px;
            padding: 10px 20px;
        }
        .btn-primary {
            border-radius: 50px;
            padding: 10px 20px;
        }
        .badge {
            font-size: 0.85rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <x-app-layout>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">Chat with {{ $user->name }}</h4>
                            <span class="badge bg-light text-primary">You: {{ Auth::user()->name }}</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="chat-box" id="chatBox">
                                @foreach($messages as $message)
                                <div class="chat-message {{ $message->user_id == Auth::id() ? 'sender' : 'receiver' }}">
                                    <div class="user">
                                        {{ $message->user_id == Auth::id() ? 'You' : $user->name }}
                                    </div>
                                    <div class="message-content">
                                        {{ $message->message }}
                                    </div>
                                    <div class="time">
                                        {{ $message->created_at->format('H:i') }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <form id="chatForm" method="POST" action="{{ route('chat.send', ['id' => $user->id]) }}" class="d-flex align-items-center gap-2">
                                @csrf
                                <input type="hidden" name="recipient_id" value="{{ $user->id }}">
                                <input type="text" name="message" id="messageInput" class="form-control" placeholder="Type your message..." required autocomplete="off">
                                <button class="btn btn-primary" type="submit">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchMessages() {
            $.get("{{ route('chat.view', ['id' => $user->id]) }}", function(data) {
                const html = $(data).find('#chatBox').html();
                $('#chatBox').html(html);
                // Scroll to bottom of chat
                $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
            });
        }
        $(document).ready(function() {
            $('#chatForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function() {
                        $('#messageInput').val('');
                        fetchMessages();
                    }
                });
            });
            setInterval(fetchMessages, 100);
        });
    </script>
</body>
</html>
