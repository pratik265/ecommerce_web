<div class="container my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <?php if(validation_errors()): ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors() ?>
                </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('message')): ?>
                <div class="alert alert-success" role="alert">
                    <?= $this->session->flashdata('message') ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profile</h4>
                </div>
                <div class="card-body p-4">
                    <?= form_open('customer/profile') ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name', $customer->name) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $customer->email ?>" disabled>
                            <small class="form-text text-muted">Email address cannot be changed.</small>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= set_value('phone', $customer->phone) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Shipping Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"><?= set_value('address', $customer->address) ?></textarea>
                        </div>
                        <button type="submit" name="update_profile" value="1" class="btn btn-primary w-100">Update Profile</button>
                    <?= form_close() ?>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-key me-2"></i>Change Password</h4>
                </div>
                <div class="card-body p-4">
                    <?= form_open('customer/profile') ?>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
                        </div>
                        <button type="submit" name="change_password" value="1" class="btn btn-secondary w-100">Change Password</button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div> 