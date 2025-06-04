<!DOCTYPE html>
<html>
<head>
    <title>Chat Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-box {
            height: 400px;
            overflow-y: scroll;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-message .user {
            font-weight: bold;
        }
        .chat-message .time {
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3>This chat is between You ({{ Auth::user()->name }}) and {{ $user->name }}</h3>
    <div class="chat-box" id="chatBox">
        @foreach($messages as $message)
            <div class="chat-message">
                <span class="user">
                    {{ $message->user_id == Auth::id() ? 'You' : $user->name }}
                </span>:
                <span class="text">{{ $message->message }}</span>
                <span class="time float-end">{{ $message->created_at->format('H:i') }}</span>
            </div>
        @endforeach
    </div>
    <form id="chatForm" method="POST" action="{{ route('chat.send', ['id' => $user->id]) }}">
        @csrf
        <input type="hidden" name="recipient_id" value="{{ $user->id }}">
        <div class="input-group">
            <input type="text" name="message" id="messageInput" class="form-control" placeholder="Type your message..." required>
            <button class="btn btn-primary" type="submit">Send</button>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchMessages() {
            $.get("{{ route('chat.view', ['id' => $user->id]) }}", function(data) {
                const html = $(data).find('#chatBox').html();
                $('#chatBox').html(html);
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
            setInterval(fetchMessages, 1000); // Poll every 3 seconds
        });
    </script>
</div>
</body>
</html>