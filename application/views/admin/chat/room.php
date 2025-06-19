<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm" style="max-width: 900px; margin: 30px auto; border-radius: 18px; overflow: hidden;">
                <!-- Chat Header -->
                <div class="chat-header-admin d-flex align-items-center justify-content-between px-4 py-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="chat-avatar-admin">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white"><?= htmlspecialchars($user->name) ?></h5>
                            <small class="text-white-50"> <?= htmlspecialchars($user->email) ?> </small>
                        </div>
                    </div>
                    <a href="<?= base_url('admin/delete_chat_room/' . $room->id) ?>" class="btn btn-sm btn-outline-light" title="Delete Chat" onclick="return confirm('Are you sure you want to delete this chat?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                <!-- Chat Body -->
                <div class="chat-body-admin p-4" id="chatMessages">
                    <?php if (empty($messages)): ?>
                        <div class="text-center text-muted mt-4">
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
                                            <i class="fas fa-check-double <?= $message->is_read ? 'text-primary' : 'text-muted' ?>"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <!-- Chat Input -->
                <div class="chat-input-admin px-4 py-3">
                    <div class="input-group">
                        <input type="text" id="messageInput" class="form-control" placeholder="Type a message..." maxlength="500" autocomplete="off">
                        <button id="sendButton" class="btn btn-primary" onclick="sendMessage()">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chat-header-admin {
    background: linear-gradient(90deg, #1976d2 0%, #2196f3 100%);
    color: white;
    border-bottom: 1px solid #e3e3e3;
}
.chat-avatar-admin {
    width: 48px;
    height: 48px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 22px;
}
.chat-body-admin {
    background: #f4f7fa;
    min-height: 400px;
    max-height: 60vh;
    overflow-y: auto;
    padding-bottom: 30px;
}
.message-admin {
    display: flex;
    margin-bottom: 18px;
}
.message-admin.sent {
    justify-content: flex-end;
}
.message-admin.received {
    justify-content: flex-start;
}
.message-content-admin {
    max-width: 60%;
    padding: 14px 18px;
    border-radius: 18px;
    font-size: 15px;
    position: relative;
    background: #fff;
    color: #222;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.message-admin.sent .message-content-admin {
    background: linear-gradient(90deg, #1976d2 0%, #2196f3 100%);
    color: #fff;
    border-bottom-right-radius: 6px;
    border-bottom-left-radius: 18px;
}
.message-admin.received .message-content-admin {
    background: #fff;
    color: #222;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 18px;
}
.message-time-admin {
    font-size: 11px;
    color: #b0b0b0;
    margin-top: 8px;
    text-align: right;
}
.chat-input-admin {
    background: #f9f9f9;
    border-top: 1px solid #e3e3e3;
}
.chat-input-admin .form-control {
    border-radius: 25px 0 0 25px;
    border: 1px solid #d0d0d0;
    font-size: 15px;
    padding: 12px 18px;
    background: #fff;
}
.chat-input-admin .btn {
    border-radius: 0 25px 25px 0;
    font-size: 18px;
    padding: 0 22px;
    background: linear-gradient(90deg, #1976d2 0%, #2196f3 100%);
    border: none;
}
.chat-input-admin .btn:hover {
    background: linear-gradient(90deg, #1565c0 0%, #1976d2 100%);
}
@media (max-width: 900px) {
    .card.shadow-sm {
        max-width: 100%;
        margin: 0;
        border-radius: 0;
    }
    .chat-body-admin {
        min-height: 300px;
        max-height: 50vh;
    }
    .message-content-admin {
        max-width: 80%;
    }
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let lastMessageId = <?= !empty($messages) ? end($messages)->id : 0 ?>;
const roomId = <?= $room->id ?>;

function scrollToBottom() {
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function sendMessage() {
    const input = document.getElementById('messageInput');
    const button = document.getElementById('sendButton');
    const message = input.value.trim();
    if (!message) return;
    input.disabled = true;
    button.disabled = true;
    $.ajax({
        url: '<?= base_url("admin/send_admin_message") ?>',
        type: 'POST',
        data: { room_id: roomId, message: message },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                addMessage(message, 'sent', response.timestamp);
                input.value = '';
                lastMessageId = response.message_id;
            } else {
                alert('Failed to send message: ' + response.message);
            }
        },
        error: function() {
            alert('Failed to send message. Please try again.');
        },
        complete: function() {
            input.disabled = false;
            button.disabled = false;
            input.focus();
        }
    });
}

function addMessage(message, type, timestamp) {
    const chatMessages = document.getElementById('chatMessages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message-admin ${type}`;
    const checkIcon = type === 'sent' ? '<i class="fas fa-check-double text-white ms-1"></i>' : '';
    messageDiv.innerHTML = `
        <div class="message-content-admin">
            ${message}
            <div class="message-time-admin">
                ${timestamp} ${checkIcon}
            </div>
        </div>
    `;
    chatMessages.appendChild(messageDiv);
    scrollToBottom();
}

function checkNewMessages() {
    $.ajax({
        url: '<?= base_url("admin/check_admin_new_messages/") ?>' + roomId,
        type: 'POST',
        data: { last_message_id: lastMessageId },
        dataType: 'json',
        success: function(response) {
            if (response.success && response.new_messages.length > 0) {
                response.new_messages.forEach(function(msg) {
                    addMessage(msg.message, 'received', msg.timestamp);
                    lastMessageId = msg.id;
                });
            }
        }
    });
}

document.getElementById('messageInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
});

scrollToBottom();
setInterval(checkNewMessages, 3000);
document.getElementById('messageInput').focus();
</script> 