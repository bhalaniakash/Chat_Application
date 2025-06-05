<!DOCTYPE html>
<html>
<head>
    <title>Chat Application</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            --light: #f8fafc;
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
            background-color: var(--dark);
            color: var(--light);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .chat-container {
            max-width: 1200px;
            height: 90vh;
            margin: 20px auto;
            position: relative;
        }
        
        .chat-card {
            border: none;
            border-radius: 24px;
            box-shadow: var(--shadow);
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: var(--dark-2);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass);
            position: relative;
            z-index: 1;
        }
        
        .chat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 70% 30%, rgba(99, 102, 241, 0.15) 0%, transparent 50%);
            z-index: -1;
            animation: float 12s ease-in-out infinite alternate;
        }
        
        @keyframes float {
            0% { transform: translate(0, 0); }
            50% { transform: translate(-5%, 5%); }
            100% { transform: translate(5%, -5%); }
        }
        
        .chat-header {
            background: var(--glass);
            color: var(--light);
            padding: 18px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--glass);
        }
        
        .chat-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .chat-header .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 12px;
            background: var(--glass);
            border: 1px solid var(--glass-2);
            backdrop-filter: blur(8px);
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.9rem;
        }
        
        .chat-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            scroll-behavior: smooth;
            display: flex;
            flex-direction: column;
            gap: 16px;
            background: 
                linear-gradient(180deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%),
                radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.1) 0%, transparent 40%);
        }
        
        .chat-message {
            display: flex;
            flex-direction: column;
            max-width: 80%;
            transition: var(--transition);
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .chat-message.sender {
            align-self: flex-end;
            align-items: flex-end;
        }
        
        .chat-message.receiver {
            align-self: flex-start;
            align-items: flex-start;
        }
        
        .message-user {
            font-weight: 500;
            font-size: 0.8rem;
            margin-bottom: 6px;
            padding: 0 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--light-3);
        }
        
        .sender .message-user {
            color: var(--primary-light);
        }
        
        .receiver .message-user {
            color: var(--secondary);
        }
        
        .message-content {
            padding: 14px 18px;
            border-radius: 18px;
            position: relative;
            word-break: break-word;
            line-height: 1.5;
            font-size: 0.95rem;
            box-shadow: var(--shadow-sm);
        }
        
        .sender .message-content {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--light);
            border-bottom-right-radius: 4px;
        }
        
        .receiver .message-content {
            background: var(--dark-3);
            color: var(--light-2);
            border-bottom-left-radius: 4px;
            border: 1px solid var(--glass);
        }
        
        .message-time {
            font-size: 0.7rem;
            color: var(--light-3);
            margin-top: 4px;
            padding: 0 12px;
            display: flex;
            align-items: center;
            gap: 4px;
            opacity: 0.8;
        }
        
        .chat-footer {
            padding: 16px 24px;
            background: var(--glass);
            backdrop-filter: blur(8px);
            border-top: 1px solid var(--glass);
            position: relative;
        }
        
        .message-form {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .message-input {
            flex: 1;
            border-radius: 16px;
            padding: 14px 20px;
            border: none;
            background: var(--dark-3);
            color: var(--light);
            font-size: 0.95rem;
            box-shadow: none;
            transition: var(--transition);
            border: 1px solid transparent;
        }
        
        .message-input::placeholder {
            /* color: var(--light-3); */
            opacity: 0.6;
        }
        
        .message-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
            background: var(--dark-2);
            color: var(--light); /* Ensure text is visible */
            caret-color: var(--primary-light); /* Makes caret more visible */
            transition: var(--transition);
        }

        
        .send-btn {
            border-radius: 16px;
            padding: 14px 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-weight: 500;
            gap: 8px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .send-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(79, 70, 229, 0.25);
        }
        
        .send-btn:active {
            transform: translateY(0);
        }
        
        .action-btn {
            background: var(--dark-3);
            border: none;
            border-radius: 12px;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            color: var(--light-2);
            cursor: pointer;
        }
        
        .action-btn:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
        }
        
        #attachmentInput {
            display: none;
        }
        
        .attachment-preview {
            margin-top: 12px;
            padding: 12px;
            border-radius: 12px;
            background: var(--dark-3);
            display: none;
            align-items: center;
            gap: 12px;
            border: 1px dashed var(--glass-2);
        }
        
        .attachment-preview.active {
            display: flex;
            animation: fadeIn 0.3s ease-out;
        }
        
        .attachment-preview .file-info {
            flex: 1;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--light-2);
        }
        
        .attachment-preview .file-icon {
            color: var(--primary-light);
        }
        
        .attachment-preview .remove-attachment {
            color: var(--light-3);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .attachment-preview .remove-attachment:hover {
            color: var(--danger);
            transform: rotate(90deg);
        }
        
        /* Custom scrollbar */
        .chat-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .chat-body::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .chat-body::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }
        
        .chat-body::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
        
        /* Typing indicator */
        .typing-indicator {
            display: flex;
            padding: 12px 18px;
            background: var(--dark-3);
            border-radius: 18px;
            width: fit-content;
            margin-bottom: 10px;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--glass);
        }
        
        .typing-text {
            font-size: 0.8rem;
            color: var(--light-3);
        }
        
        .typing-dots {
            display: flex;
            gap: 4px;
        }
        
        .typing-dot {
            width: 8px;
            height: 8px;
            background-color: var(--light-3);
            border-radius: 50%;
            animation: typingAnimation 1.4s infinite ease-in-out;
        }
        
        .typing-dot:nth-child(1) { animation-delay: 0s; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        
        @keyframes typingAnimation {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.6; }
            30% { transform: translateY(-4px); opacity: 1; }
        }
        
        /* Message attachment styles */
        .attachment {
            margin-top: 10px;
            padding: 10px;
            background: var(--glass);
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--glass-2);
            transition: var(--transition);
        }
        
        .attachment:hover {
            background: var(--glass-2);
        }
        
        .attachment a {
            color: inherit;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            width: 100%;
        }
        
        .attachment-icon {
            color: var(--primary-light);
            font-size: 1.1rem;
        }
        
        /* Floating date markers */
        .message-date {
            align-self: center;
            background: var(--glass);
            backdrop-filter: blur(8px);
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            margin: 8px 0;
            color: var(--light-2);
            border: 1px solid var(--glass-2);
        }
        
        /* Message status indicators */
        .message-status {
            margin-left: 6px;
            font-size: 0.7rem;
        }
        
        .status-sent { color: var(--light-3); }
        .status-delivered { color: var(--primary-light); }
        .status-read { color: var(--secondary); }
        
        /* Floating action button */
        .scroll-to-bottom {
            position: absolute;
            bottom: 90px;
            right: 30px;
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: var(--shadow);
            cursor: pointer;
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
            z-index: 10;
            border: none;
        }
        
        .scroll-to-bottom.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .scroll-to-bottom:hover {
            background: var(--primary-dark);
            transform: translateY(-2px) scale(1.05);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .chat-container {
                height: 100vh;
                margin: 0;
                border-radius: 0;
            }
            
            .chat-card {
                border-radius: 0;
            }
            
            .message-form {
                gap: 8px;
            }
            
            .action-btn {
                width: 42px;
                height: 42px;
            }
            
            .message-input {
                padding: 12px 16px;
            }
            
            .send-btn {
                padding: 12px 16px;
            }
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
    </style>
</head>
<body>
    <!-- Animated background elements -->
    <div class="bg-elements">
        <div class="bg-element bg-element-1"></div>
        <div class="bg-element bg-element-2"></div>
        <div class="bg-element bg-element-3"></div>
    </div>

    <x-app-layout>
        <div class="container chat-container">
            <div class="chat-card">
                <div class="chat-header">
                    <h4>
                        <i class="fas fa-comment-dots"></i>
                        Chat with {{ $user->name }}
                    </h4>
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <span class="user-badge">
                            <i class="fas fa-user"></i>
                            {{ Auth::user()->name }}
                        </span>
                    </div>
                </div>
                
                <div class="chat-body" id="chatBox">
                    <!-- Date marker example -->
                    <div class="message-date">
                        Today
                    </div>
                    
                    @foreach($messages as $message)
                    <div class="chat-message {{ $message->user_id == Auth::id() ? 'sender' : 'receiver' }}">
                        <div class="message-user">
                            <i class="fas fa-user-circle"></i>
                            {{ $message->user_id == Auth::id() ? 'You' : $user->name }}
                        </div>
                        <div class="message-content">
                            {{ $message->message }}
                            @if($message->attachment)
                                <div class="attachment">
                                    <a href="{{ Storage::url($message->attachment) }}" target="_blank">
                                        <i class="fas fa-paperclip attachment-icon"></i>
                                        <span>View Attachment</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="message-time">
                            <i class="far fa-clock"></i>
                            {{ $message->created_at->format('H:i') }}
                            @if($message->user_id == Auth::id())
                                <span class="message-status status-read">
                                    <i class="fas fa-check-double"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Typing indicator example (can be toggled with JS) -->
                    <div class="chat-message receiver" id="typingIndicator" style="display: none;">
                        <div class="message-user">
                            <i class="fas fa-user-circle"></i>
                            {{ $user->name }}
                        </div>
                        <div class="typing-indicator">
                            <div class="typing-dots">
                                <div class="typing-dot"></div>
                                <div class="typing-dot"></div>
                                <div class="typing-dot"></div>
                            </div>
                            <div class="typing-text">typing...</div>
                        </div>
                    </div>
                </div>
                
                <button class="scroll-to-bottom" id="scrollToBottom" title="Scroll to bottom">
                    <i class="fas fa-arrow-down"></i>
                </button>
                
                <div class="chat-footer">
                    <form id="chatForm" method="POST" action="{{ route('chat.send', ['id' => $user->id]) }}" class="message-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="recipient_id" value="{{ $user->id }}">
                        
                        <button type="button" class="action-btn" onclick="document.getElementById('attachmentInput').click()" title="Attach file">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <input type="file" name="attachment" id="attachmentInput" class="form-control">
                        
                        <input type="text" name="message" id="messageInput" class="form-control message-input" placeholder="Type your message..." autocomplete="off">
                        
                        <button class="send-btn" type="submit" id="sendButton">
                            Send <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                    
                    <div class="attachment-preview" id="attachmentPreview">
                        <div class="file-info">
                            <i class="fas fa-file file-icon"></i>
                            <span id="fileName"></span>
                        </div>
                        <i class="fas fa-times remove-attachment" onclick="removeAttachment()"></i>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const chatBox = $('#chatBox');
            const scrollToBottomBtn = $('#scrollToBottom');
            let isTyping = false;
            
            // Initial scroll to bottom
            scrollToBottom();
            
            // Attachment preview handler
            $('#attachmentInput').on('change', function() {
                const file = this.files[0];
                if (file) {
                    $('#fileName').text(file.name.length > 20 ? 
                        file.name.substring(0, 17) + '...' + file.name.split('.').pop() : 
                        file.name);
                    $('#attachmentPreview').addClass('active');
                }
            });
            
            // Chat form submission
            $('#chatForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const messageInput = $('#messageInput');
                const message = messageInput.val().trim();
                const attachmentInput = $('#attachmentInput')[0];

                if (!message && (!attachmentInput.files || attachmentInput.files.length === 0)) {
                    return;
                }

                const formData = new FormData();
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('message', message);
                formData.append('recipient_id', $('input[name="recipient_id"]').val());

                if (attachmentInput.files && attachmentInput.files.length > 0) {
                    formData.append('attachment', attachmentInput.files[0]);
                }

                // Show temporary "sending" state
                const tempId = 'temp-' + Date.now();
                if (message) {
                    addTempMessage(tempId, message, attachmentInput.files[0] ? true : false);
                }

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#sendButton').html('<i class="fas fa-spinner fa-spin"></i>');
                        messageInput.prop('disabled', true);
                        form.find('button').prop('disabled', true);
                    },
                    success: function(response) {
                        // Remove temp message and fetch actual messages
                        $(`#${tempId}`).remove();
                        fetchMessages();
                        messageInput.val('');
                        attachmentInput.value = '';
                        $('#attachmentPreview').removeClass('active');
                    },
                    error: function(xhr) {
                        console.error("Error:", xhr.responseText);
                        // Update temp message to show error
                        $(`#${tempId} .message-status`).html('<i class="fas fa-exclamation-circle status-error"></i>');
                    },
                    complete: function() {
                        $('#sendButton').html('Send <i class="fas fa-paper-plane"></i>');
                        messageInput.prop('disabled', false).focus();
                        form.find('button').prop('disabled', false);
                    }
                });
            });

            // Typing indicator simulation
            $('#messageInput').on('input', function() {
                if (!isTyping) {
                    isTyping = true;
                    // In a real app, you would send a "typing" event to the server here
                    $('#typingIndicator').fadeIn();
                    
                    // Simulate the other user stopping typing after 3 seconds
                    setTimeout(() => {
                        $('#typingIndicator').fadeOut();
                        isTyping = false;
                    }, 3000);
                }
            });

            // Check for new messages every 2 seconds
            setInterval(fetchMessages, 2000);

            // Auto-scroll handling
            chatBox.on('scroll', function() {
                const isNearBottom = chatBox[0].scrollHeight - chatBox.scrollTop() <= chatBox.outerHeight() + 100;
                
                // Show/hide scroll to bottom button
                if (isNearBottom) {
                    scrollToBottomBtn.removeClass('visible');
                } else {
                    scrollToBottomBtn.addClass('visible');
                }
                
                chatBox.data('auto-scroll', isNearBottom);
            });

            // Scroll to bottom button click handler
            scrollToBottomBtn.on('click', scrollToBottom);

            function fetchMessages() {
                $.get("{{ route('chat.view', ['id' => $user->id]) }}", function(data) {
                    const newContent = $(data).find('#chatBox').html();
                    const shouldScroll = chatBox.data('auto-scroll') !== false;
                    
                    if (newContent !== chatBox.html()) {
                        chatBox.html(newContent);
                        if (shouldScroll) scrollToBottom();
                    }
                });
            }

            function scrollToBottom() {
                chatBox.stop().animate({
                    scrollTop: chatBox[0].scrollHeight
                }, 300);
                scrollToBottomBtn.removeClass('visible');
            }

            function addTempMessage(id, message, hasAttachment) {
                const tempMsg = `
                    <div class="chat-message sender" id="${id}">
                        <div class="message-user">
                            <i class="fas fa-user-circle"></i>
                            You
                        </div>
                        <div class="message-content">
                            ${message}
                            ${hasAttachment ? '<div class="attachment"><i class="fas fa-spinner fa-spin"></i> Uploading...</div>' : ''}
                        </div>
                        <div class="message-time">
                            <i class="far fa-clock"></i>
                            Just now
                            <span class="message-status status-sent">
                                <i class="fas fa-check"></i>
                            </span>
                        </div>
                    </div>
                `;
                chatBox.append(tempMsg);
                scrollToBottom();
            }

            $('#messageInput').focus();
        });

        function removeAttachment() {
            $('#attachmentInput').val('');
            $('#attachmentPreview').removeClass('active');
        }
    </script>
</body>
</html>