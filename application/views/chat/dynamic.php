<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;600&display=swap');
        body { 
            background-color: #f0f2f5;
            font-family: 'Manrope', sans-serif;
        }
        .chat-container { 
            max-width: 750px; 
            margin: 30px auto; 
            background: #fff; 
            border-radius: 1rem; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.1); 
            overflow: hidden; 
            display: flex; 
            flex-direction: column; 
            height: 85vh; 
        }
        .chat-header { 
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: #fff; 
            padding: 1.25rem 1.5rem; 
            display: flex; 
            align-items: center; 
            gap: 1rem;
            border-bottom: 1px solid transparent;
            z-index: 10;
        }
        .chat-header .avatar { 
            width: 48px; 
            height: 48px; 
            background: rgba(255,255,255,0.2); 
            color: #fff; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 1.5rem; 
        }
        .chat-header .info { 
            flex: 1; 
        }
        .chat-header .info h5 {
            font-weight: 600;
            margin-bottom: 0.1rem;
        }
        .chat-messages { 
            flex: 1; 
            overflow-y: auto; 
            padding: 1.5rem; 
            background-color: #f0f2f5;
        }
        .message { 
            display: flex; 
            margin-bottom: 1.5rem;
            animation: fadeIn 0.4s ease-in-out; 
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .message.sent { 
            justify-content: flex-end; 
        }
        .message.received { 
            justify-content: flex-start; 
        }
        .message-content { 
            max-width: 75%; 
            padding: 0.8rem 1.2rem; 
            border-radius: 1.2rem; 
            position: relative; 
            word-break: break-word; 
            font-size: 0.98rem;
            line-height: 1.45;
        }
        .message.sent .message-content { 
            background: #0d6efd;
            color: #fff; 
            border-bottom-right-radius: 0.4rem; 
        }
        .message.received .message-content { 
            background: #fff; 
            color: #333; 
            border-bottom-left-radius: 0.4rem; 
            box-shadow: 0 1px 1px rgba(0,0,0,0.05); 
        }
        .message-time { 
            font-size: 0.75rem; 
            color: rgba(255,255,255,0.75); 
            margin-top: 0.4rem; 
            text-align: right; 
        }
        .message.received .message-time {
            color: #999;
        }
        .chat-input { 
            background: #fff; 
            border-top: 1px solid #e5e7eb; 
            padding: 1rem; 
            display: flex; 
            gap: 0.75rem; 
            align-items: center; 
        }
        .chat-input input { 
            flex: 1; 
            border: 1px solid #e5e7eb;
            background: #f8f9fa;
            border-radius: 2rem; 
            padding: 0.8rem 1.2rem; 
            font-size: 1rem; 
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .chat-input input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
        .chat-input button { 
            border-radius: 50%; 
            font-size: 1rem;
            background: #0d6efd;
            color: #fff;
            border: none;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background-color 0.2s, transform 0.2s;
        }
        .chat-input button:hover {
            background: #0a58ca;
            transform: translateY(-2px);
        }
        .chat-input button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        @media (max-width: 768px) { 
            .chat-container { max-width: 100%; height: 100vh; border-radius: 0; margin: 0; } 
            .chat-messages { padding: 1rem; } 
            .chat-input { padding: 0.75rem; }
        }
    </style>
</head>
<body>
<div class="chat-container">
    <div class="chat-header">
        <div class="avatar"><i class="fas fa-comments"></i></div>
        <div class="info">
            <h5 class="mb-0">Chat Support</h5>
            <small class="text-light">Role: <b><?= ucfirst($role) ?></b></small>
        </div>
    </div>
    <div class="chat-messages" id="chatMessages">
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message <?= $msg->sender_type == $role ? 'sent' : 'received' ?>">
                    <div class="message-content">
                        <?= htmlspecialchars($msg->message) ?>
                        <div class="message-time">
                            <?= date('H:i', strtotime($msg->created_at)) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-muted">No messages yet. Start the conversation!</div>
        <?php endif; ?>
    </div>
    <div class="chat-input">
        <input type="text" id="messageInput" class="form-control" placeholder="Type a message..." autocomplete="off">
        <button id="sendButton">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const chatMessages = $('#chatMessages');
    const messageInput = $('#messageInput');
    const sendButton = $('#sendButton');
    const roomId = '<?= $room->id ?>';
    let lastMessageId = '<?= end($messages)->id ?? 0 ?>';

    function scrollToBottom() {
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }

    function renderMessage(message, sender_type) {
        const alignment = sender_type === 'user' ? 'sent' : 'received';
        const messageHtml = `
            <div class="message ${alignment}">
                <div class="message-content">
                    ${message.message}
                    <div class="message-time">
                        ${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                    </div>
                </div>
            </div>`;
        chatMessages.append(messageHtml);
    }

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

    sendButton.on('click', sendMessage);
    messageInput.on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    scrollToBottom();
});
</script>
</body>
</html> 