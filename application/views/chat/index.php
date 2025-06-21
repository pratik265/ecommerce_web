<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .chat-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            height: calc(100vh - 40px);
            display: flex;
            flex-direction: column;
        }
        
        .chat-header {
            background: #25D366;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .chat-header .avatar {
            width: 40px;
            height: 40px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #25D366;
            font-size: 18px;
        }
        
        .chat-header .user-info h5 {
            margin: 0;
            font-weight: 600;
        }
        
        .chat-header .user-info small {
            opacity: 0.8;
        }
        
        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f0f0f0;
        }
        
        .message {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-end;
            gap: 8px;
        }
        
        .message.sent {
            justify-content: flex-end;
        }
        
        .message.received {
            justify-content: flex-start;
        }
        
        .message-content {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
        }
        
        .message.sent .message-content {
            background: #DCF8C6;
            color: #000;
            border-bottom-right-radius: 5px;
        }
        
        .message.received .message-content {
            background: white;
            color: #000;
            border-bottom-left-radius: 5px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        .message-time {
            font-size: 11px;
            color: #999;
            margin-top: 5px;
            text-align: right;
        }
        
        .message.received .message-time {
            text-align: left;
        }
        
        .chat-input {
            padding: 15px 20px;
            background: white;
            border-top: 1px solid #e0e0e0;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .chat-input input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px 15px;
            border-radius: 25px;
            background: #f0f0f0;
            font-size: 14px;
        }
        
        .chat-input button {
            background: #25D366;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .chat-input button:hover {
            background: #128C7E;
            transform: scale(1.05);
        }
        
        .chat-input button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        
        .typing-indicator {
            padding: 10px 20px;
            color: #666;
            font-style: italic;
            display: none;
        }
        
        .unread-badge {
            background: #ff4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            position: absolute;
            top: -5px;
            right: -5px;
        }
        
        .back-btn {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin-right: 10px;
        }
        
        .back-btn:hover {
            color: #f0f0f0;
        }
        
        @media (max-width: 768px) {
            .chat-container {
                margin: 0;
                height: 100vh;
                border-radius: 0;
            }
            
            .message-content {
                max-width: 85%;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <!-- Chat Header -->
        <div class="chat-header">
            <a href="<?= base_url() ?>" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="avatar">
                <i class="fas fa-headset"></i>
            </div>
            <div class="user-info">
                <h5>Admin Support</h5>
                <small>Online</small>
            </div>
            <?php if ($unread_count > 0): ?>
                <div class="unread-badge"><?= $unread_count ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Chat Messages -->
        <div class="chat-messages" id="chatMessages">
            <?php if (empty($messages)): ?>
                <div class="text-center text-muted mt-4">
                    <i class="fas fa-comments fa-3x mb-3"></i>
                    <p>Start a conversation with our support team!</p>
                </div>
            <?php else: ?>
                <?php foreach ($messages as $message): ?>
                    <div class="message <?= $message->sender_type == 'user' ? 'sent' : 'received' ?>">
                        <div class="message-content">
                            <?= htmlspecialchars($message->message) ?>
                            <div class="message-time">
                                <?= date('H:i', strtotime($message->created_at)) ?>
                                <?php if ($message->sender_type == 'user'): ?>
                                    <i class="fas fa-check-double <?= $message->is_read ? 'text-primary' : 'text-muted' ?>"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Typing Indicator -->
        <div class="typing-indicator" id="typingIndicator">
            Admin is typing...
        </div>
        
        <!-- Chat Input -->
        <div class="chat-input" id="chatInputForm">
            <input type="text" id="messageInput" class="form-control" placeholder="Type a message..." autocomplete="off">
            <button id="sendButton" class="btn btn-primary rounded-pill">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let lastMessageId = <?= !empty($messages) ? end($messages)->id : 0 ?>;
        let isTyping = false;
        
        // Auto-scroll to bottom
        function scrollToBottom() {
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Send message
        function sendMessage() {
            const message = messageInput.val().trim();
            if (!message) return;

            sendButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.post('<?= base_url("chat/send_message") ?>', {
                message: message,
                room_id: roomId
            }, function(response) {
                if(response.status === 'success') {
                    renderMessage(response.message, 'user');
                    lastMessageId = response.message.id;
                    scrollToBottom();
                    messageInput.val('');
                } else {
                    alert(response.message || 'Error sending message.');
                }
                sendButton.prop('disabled', false).html('<i class="fas fa-paper-plane"></i>');
            }, 'json');
        }
        
        // Add message to chat
        function addMessage(message, type, timestamp) {
            const chatMessages = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${type}`;
            
            const checkIcon = type === 'sent' ? '<i class="fas fa-check-double text-muted"></i>' : '';
            
            messageDiv.innerHTML = `
                <div class="message-content">
                    ${message}
                    <div class="message-time">
                        ${timestamp} ${checkIcon}
                    </div>
                </div>
            `;
            
            chatMessages.appendChild(messageDiv);
            scrollToBottom();
        }
        
        // Check for new messages
        function checkNewMessages() {
            $.ajax({
                url: '<?= base_url("chat/check_new_messages") ?>',
                type: 'POST',
                data: { last_message_id: lastMessageId },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.new_messages.length > 0) {
                        response.new_messages.forEach(function(msg) {
                            addMessage(msg.message, 'received', msg.timestamp);
                            lastMessageId = msg.id;
                        });
                        
                        // Update unread count
                        if (response.unread_count > 0) {
                            updateUnreadBadge(response.unread_count);
                        }
                    }
                }
            });
        }
        
        // Update unread badge
        function updateUnreadBadge(count) {
            let badge = document.querySelector('.unread-badge');
            if (count > 0) {
                if (!badge) {
                    badge = document.createElement('div');
                    badge.className = 'unread-badge';
                    document.querySelector('.chat-header').appendChild(badge);
                }
                badge.textContent = count;
            } else if (badge) {
                badge.remove();
            }
        }
        
        // Handle Enter key
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
        
        // Initial scroll to bottom
        scrollToBottom();
        
        // Check for new messages every 3 seconds
        setInterval(checkNewMessages, 3000);
        
        // Focus on input
        document.getElementById('messageInput').focus();
    </script>
</body>
</html> 