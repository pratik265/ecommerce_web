<h2 class="mb-4">User Management</h2>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= htmlspecialchars($user->name) ?></td>
                    <td><?= htmlspecialchars($user->email) ?></td>
                    <td><?= ucfirst($user->role) ?></td>
                    <td>
                        <?php if ($user->status == 'active'): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Blocked</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($user->status == 'active'): ?>
                            <a href="<?= base_url('admin/block_user/' . $user->id) ?>" class="btn btn-warning btn-sm">Block</a>
                        <?php else: ?>
                            <a href="<?= base_url('admin/unblock_user/' . $user->id) ?>" class="btn btn-success btn-sm">Unblock</a>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/delete_user/' . $user->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        <a href="<?= base_url('admin/user_customers/' . $user->id) ?>" class="btn btn-info btn-sm">View Customers</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No users found.</td></tr>
        <?php endif; ?>
    </tbody>
</table> 