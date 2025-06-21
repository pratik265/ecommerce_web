<div class="container-fluid py-4">
    <div class="chat-container-admin">
        <!-- Chat Header -->
        <div class="chat-header-admin">
            <div class="d-flex align-items-center gap-3">
                <div class="chat-avatar-admin">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h5 class="mb-0 text-white fw-bold"><?= htmlspecialchars($user->name) ?></h5>
                    <small class="text-white-50"> <?= htmlspecialchars($user->email) ?> </small>
                </div>
            </div>
            <a href="<?= base_url('admin/chat') ?>" class="btn btn-sm btn-outline-light" title="Back to Chats">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <!-- Chat Body -->
        <div class="chat-body-admin" id="chatMessages">
            <?php if (empty($messages)): ?>
                <div class="text-center text-muted p-5">
                    <i class="fas fa-comments fa-3x mb-3"></i>
                    <p>No messages yet. Start the conversation!</p>
                </div>
            <?php else: ?>
                <?php foreach ($messages as $message): ?>
                    <div class="message-admin <?= $message->sender_type == 'admin' ? 'sent' : 'received' ?>">
                        <div class="message-content-admin">
                            <?= htmlspecialchars($message->message) ?>
                            <div class="message-time-admin">
                                <?= date('H:i', strtotime($message->created_at)) ?>
                                <?php if ($message->sender_type == 'admin'): ?>
                                    <i class="fas fa-check-double ms-1 <?= $message->is_read ? 'text-info' : '' ?>"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!-- Chat Input -->
        <div class="chat-input-admin">
            <input type="text" id="messageInput" class="form-control" placeholder="Type your message..." autocomplete="off">
            <button id="sendButton">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap');
    .chat-container-admin { 
        max-width: 800px; 
        margin: auto; 
        background: #fff; 
        border-radius: 1rem; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.1); 
        overflow: hidden; 
        display: flex; 
        flex-direction: column; 
        height: 80vh;
        font-family: 'Manrope', sans-serif;
    }
    .chat-header-admin { 
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: #fff; 
        padding: 1.25rem 1.5rem; 
        display: flex; 
        align-items: center; 
        justify-content: space-between;
        gap: 1rem;
        border-bottom: 1px solid transparent;
        z-index: 10;
    }
    .chat-avatar-admin { 
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
    .chat-body-admin { 
        flex: 1; 
        overflow-y: auto; 
        padding: 1.5rem; 
        background-color: #f0f2f5;
    }
    .message-admin { 
        display: flex; 
        margin-bottom: 1.5rem;
        animation: fadeIn 0.4s ease-in-out; 
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .message-admin.sent { 
        justify-content: flex-end; 
    }
    .message-admin.received { 
        justify-content: flex-start; 
    }
    .message-content-admin { 
        max-width: 75%; 
        padding: 0.8rem 1.2rem; 
        border-radius: 1.2rem; 
        position: relative; 
        word-break: break-word; 
        font-size: 0.98rem;
        line-height: 1.45;
    }
    .message-admin.sent .message-content-admin { 
        background: #0d6efd;
        color: #fff; 
        border-bottom-right-radius: 0.4rem; 
    }
    .message-admin.received .message-content-admin { 
        background: #fff; 
        color: #333; 
        border-bottom-left-radius: 0.4rem; 
        box-shadow: 0 1px 1px rgba(0,0,0,0.05); 
    }
    .message-time-admin { 
        font-size: 0.75rem; 
        color: rgba(255,255,255,0.75); 
        margin-top: 0.4rem; 
        text-align: right; 
    }
    .message-admin.received .message-time-admin {
        color: #999;
    }
    .chat-input-admin { 
        background: #fff; 
        border-top: 1px solid #e5e7eb; 
        padding: 1rem; 
        display: flex; 
        gap: 0.75rem; 
        align-items: center; 
    }
    .chat-input-admin .form-control { 
        flex: 1; 
        border: 1px solid #e5e7eb;
        background: #f8f9fa;
        border-radius: 2rem; 
        padding: 0.8rem 1.2rem; 
        font-size: 1rem; 
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .chat-input-admin .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }
    .chat-input-admin button { 
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
    .chat-input-admin button:hover {
        background: #0a58ca;
        transform: translateY(-2px);
    }
    .chat-input-admin button:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let lastMessageId = <?= !empty($messages) ? end($messages)->id : 0 ?>;
    const roomId = <?= $room->id ?>;

    function scrollToBottom() {
        $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
    }

    function addMessage(message, type, timestamp, isRead = false) {
        const chatMessages = $('#chatMessages');
        const formattedTime = new Date(timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const checkIcon = type === 'sent' ? `<i class="fas fa-check-double ms-1 ${isRead ? 'text-info' : ''}"></i>` : '';
        const messageHtml = `
            <div class="message-admin ${type}">
                <div class="message-content-admin">
                    ${$('<div>').text(message).html()}
                    <div class="message-time-admin">${formattedTime} ${checkIcon}</div>
                </div>
            </div>`;
        chatMessages.append(messageHtml);
        scrollToBottom();
    }
    
    function sendMessage() {
        const input = $('#messageInput');
        const message = input.val().trim();
        if (!message) return;

        const sendButton = $('#sendButton');
        sendButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        input.prop('disabled', true);

        $.post('<?= base_url("admin/send_admin_message") ?>', {
            room_id: roomId,
            message: message
        }, function(response) {
            if (response.success) {
                addMessage(response.message.message, 'sent', response.message.created_at, response.message.is_read);
                input.val('');
                lastMessageId = response.message.id;
            } else {
                alert('Failed to send message: ' + (response.message || 'Unknown error'));
            }
        }, 'json').fail(function() {
            alert('Failed to send message. Please try again.');
        }).always(function() {
            sendButton.prop('disabled', false).html('<i class="fas fa-paper-plane"></i>');
            input.prop('disabled', false).focus();
        });
    }

    function checkNewMessages() {
        $.post('<?= base_url("admin/check_admin_new_messages/") ?>' + roomId, { 
            last_message_id: lastMessageId 
        }, function(response) {
            if (response.success && response.new_messages.length > 0) {
                response.new_messages.forEach(function(msg) {
                    addMessage(msg.message, 'received', msg.created_at);
                    lastMessageId = msg.id;
                });
            }
        }, 'json');
    }

    scrollToBottom();
    setInterval(checkNewMessages, 3000);

    $('#sendButton').on('click', sendMessage);
    $('#messageInput').on('keypress', function(e) {
        if(e.which == 13 && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
    $('#messageInput').focus();
});
</script> 