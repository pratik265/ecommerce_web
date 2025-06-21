<h2 class="mb-4">Customers of <?= htmlspecialchars($user->name) ?> (User ID: <?= $user->id ?>)</h2>
<a href="<?= base_url('admin/users') ?>" class="btn btn-secondary mb-3">&larr; Back to User List</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Status</th>
            <th>Joined</th>
            <th>Order Count</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($customers)): ?>
            <?php foreach ($customers as $i => $customer): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($customer->name) ?></td>
                    <td><?= htmlspecialchars($customer->email) ?></td>
                    <td><?= htmlspecialchars($customer->phone) ?></td>
                    <td><?= htmlspecialchars($customer->address) ?></td>
                    <td>
                        <?php if ($customer->status == 'active'): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Blocked</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('M d, Y', strtotime($customer->created_at)) ?></td>
                    <td><span class="badge bg-primary"><?= $customer->order_count ?></span></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8" class="text-center">No customers found for this user.</td></tr>
        <?php endif; ?>
    </tbody>
</table> 