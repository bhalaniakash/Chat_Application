<!DOCTYPE html>
<html>
<head>
    <title>Chat Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-box {
            height: 400px;
            width: 100%;
            overflow-y: scroll;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .chat-message {
            margin-bottom: 10px;
            width: 100%;
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Chat with {{ $user->name }}</h4>
                    <span class="badge bg-light text-primary">You: {{ Auth::user()->name }}</span>
                </div>
                <div class="card-body p-0" style="background: #f4f6fb;">
                    <div class="chat-box px-3 pt-3" id="chatBox">
                        @foreach($messages as $message)
                            <div class="chat-message d-flex mb-3 {{ $message->user_id == Auth::id() }} w-100">
                                <div class="w-100">
                                    <div class="d-flex align-items-center mb-1 w-100">
                                        <span class="user me-2 {{ $message->user_id == Auth::id() ? 'text-primary' : 'text-success' }}">
                                            {{ $message->user_id == Auth::id() ? 'You' : $user->name }}
                                        </span>
                                        <span class="time ms-auto text-muted small">{{ $message->created_at->format('H:i') }}</span>
                                    </div>
                                    <div class="p-2 rounded {{ $message->user_id == Auth::id() ? 'bg-primary text-white' : 'bg-light' }} w-100">
                                        {{ $message->message }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <form id="chatForm" method="POST" action="{{ route('chat.send', ['id' => $user->id]) }}" class="d-flex align-items-center gap-2">
                        @csrf
                        <input type="hidden" name="recipient_id" value="{{ $user->id }}">
                        <input type="text" name="message" id="messageInput" class="form-control rounded-pill" placeholder="Type your message..." required autocomplete="off">
                        <button class="btn btn-primary rounded-pill px-4" type="submit">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
            setInterval(fetchMessages, 1000);
        });
    </script>
</div>
</body>
</html>