<h2 class="mb-4"><i class="fas fa-comments"></i> Chat Management</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (!empty($chat_rooms)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>User</th>
                            <th>Last Message</th>
                            <th>Unread</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($chat_rooms as $room): ?>
                            <tr>
                                <td><?= htmlspecialchars($room->user_name) ?></td>
                                <td><?= htmlspecialchars($room->last_message) ?></td>
                                <td>
                                    <?php if (!empty($room->unread_count) && $room->unread_count > 0): ?>
                                        <span class="badge bg-danger"><?= $room->unread_count ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">0</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/chat_room/' . $room->id) ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-comments"></i> Open Chat
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted text-center">No chat rooms found.</p>
        <?php endif; ?>
    </div>
</div> 