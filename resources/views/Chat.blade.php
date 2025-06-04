<!DOCTYPE html>
<html>
<head>
    <title>Chat Application</title>
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
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .chat-container {
            max-width: 800px;
            height: 90vh;
            margin: 20px auto;
        }
        
        .chat-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow);
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .chat-header {
            background-color: var(--primary-color);
            color: var(--white-color);
            padding: 15px 20px;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .chat-header h4 {
            margin: 0;
            font-weight: 600;
        }
        
        .user-badge {
            background-color: rgba(255,255,255,0.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .chat-body {
            flex: 1;
            padding: 20px;
            background-color: var(--white-color);
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        
        .chat-message {
            margin-bottom: 16px;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        
        .chat-message.sender {
            align-items: flex-end;
        }
        
        .chat-message.receiver {
            align-items: flex-start;
        }
        
        .message-user {
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 4px;
            padding: 0 12px;
        }
        
        .sender .message-user {
            color: var(--primary-color);
        }
        
        .receiver .message-user {
            color: var(--success-color);
        }
        
        .message-content {
            max-width: 75%;
            padding: 12px 16px;
            border-radius: 18px;
            position: relative;
            word-break: break-word;
            line-height: 1.4;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .sender .message-content {
            background-color: var(--primary-color);
            color: var(--white-color);
            border-bottom-right-radius: 4px;
        }
        
        .receiver .message-content {
            background-color: var(--light-gray);
            color: var(--dark-color);
            border-bottom-left-radius: 4px;
        }
        
        .message-time {
            font-size: 0.7rem;
            color: var(--gray-color);
            margin-top: 4px;
            padding: 0 12px;
        }
        
        .chat-footer {
            padding: 15px 20px;
            background-color: var(--white-color);
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        
        .message-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .message-input {
            flex: 1;
            border-radius: 50px;
            padding: 12px 20px;
            border: 1px solid var(--light-gray);
            transition: all 0.3s ease;
            box-shadow: none;
        }
        
        .message-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
        
        .send-btn {
            border-radius: 50px;
            padding: 12px 20px;
            background-color: var(--primary-color);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .send-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-1px);
        }
        
        .send-btn i {
            margin-left: 5px;
        }
        
        /* Custom scrollbar */
        .chat-body::-webkit-scrollbar {
            width: 8px;
        }
        
        .chat-body::-webkit-scrollbar-track {
            background: var(--light-gray);
            border-radius: 4px;
        }
        
        .chat-body::-webkit-scrollbar-thumb {
            background: var(--gray-color);
            border-radius: 4px;
        }
        
        .chat-body::-webkit-scrollbar-thumb:hover {
            background: #888;
        }
        
        /* Typing indicator */
        .typing-indicator {
            display: flex;
            padding: 10px 15px;
            background: var(--light-gray);
            border-radius: 20px;
            width: fit-content;
            margin-bottom: 10px;
            align-items: center;
        }
        
        .typing-dot {
            width: 8px;
            height: 8px;
            background-color: var(--gray-color);
            border-radius: 50%;
            margin: 0 2px;
            animation: typingAnimation 1.4s infinite ease-in-out;
        }
        
        .typing-dot:nth-child(1) {
            animation-delay: 0s;
        }
        
        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes typingAnimation {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-5px); }
        }
    </style>
</head>
<body>
    <x-app-layout>
        <div class="container chat-container">
            <div class="chat-card">
                <div class="chat-header">
                    <h4>Chat with {{ $user->name }}</h4>
                    <span class="user-badge">You: {{ Auth::user()->name }}</span>
                </div>
                
                <div class="chat-body" id="chatBox">
                    @foreach($messages as $message)
                    <div class="chat-message {{ $message->user_id == Auth::id() ? 'sender' : 'receiver' }}">
                        <div class="message-user">
                            {{ $message->user_id == Auth::id() ? 'You' : $user->name }}
                        </div>
                        <div class="message-content">
                            {{ $message->message }}
                        </div>
                        <div class="message-time">
                            {{ $message->created_at->format('h:i A') }}
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="chat-footer">
                    <form id="chatForm" method="POST" action="{{ route('chat.send', ['id' => $user->id]) }}" class="message-form">
                        @csrf
                        <input type="hidden" name="recipient_id" value="{{ $user->id }}">
                        <input type="text" name="message" id="messageInput" class="form-control message-input" placeholder="Type your message..." required autocomplete="off">
                        <button class="btn btn-primary send-btn" type="submit">
                            Send <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const chatBox = $('#chatBox');
            scrollToBottom(); // Initial scroll to bottom
            
            // Handle form submission
            $('#chatForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const messageInput = $('#messageInput');
                const message = messageInput.val().trim();
                
                if (message === '') return;
                
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        // Disable input and button while sending
                        messageInput.prop('disabled', true);
                        form.find('button').prop('disabled', true);
                    },
                    success: function() {
                        messageInput.val(''); // Clear input
                        fetchMessages(); // Fetch updated messages
                    },
                    // error: function(err) {
                    //     console.error('Message sending failed:', err);
                    //     alert('Failed to send message. Please try again.');
                    // },
                    complete: function() {
                        // Re-enable input and button
                        messageInput.prop('disabled', false).focus();
                        form.find('button').prop('disabled', false);
                    }
                });
            });
            
            // Fetch messages every 2 seconds
            setInterval(fetchMessages, 2000);
            
            // Auto-scroll when user is near bottom
            chatBox.on('scroll', function() {
                const isNearBottom = chatBox[0].scrollHeight - chatBox.scrollTop() <= chatBox.outerHeight() + 100;
                chatBox.data('auto-scroll', isNearBottom);
            });
            
            function fetchMessages() {
                $.get("{{ route('chat.view', ['id' => $user->id]) }}", function(data) {
                    const newContent = $(data).find('#chatBox').html();
                    const shouldScroll = chatBox.data('auto-scroll') !== false;
                    
                    // Only update if content has changed
                    if (newContent !== chatBox.html()) {
                        chatBox.html(newContent);
                        
                        if (shouldScroll) {
                            scrollToBottom();
                        }
                    }
                }).fail(function(err) {
                    console.error('Error fetching messages:', err);
                });
            }
            
            function scrollToBottom() {
                chatBox.stop().animate({
                    scrollTop: chatBox[0].scrollHeight
                }, 300);
            }
            
            // Focus input on page load
            $('#messageInput').focus();
        });

        $(".send-btn").on("click", function() {
            $(this).addClass("loading");
            setTimeout(() => {
                $(this).removeClass("loading");
            }, 2000);
        });
    </script>
</body>
</html>