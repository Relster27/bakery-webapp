<?php $__env->startSection('content'); ?>
    <div class="auth-shell">
        <div class="card auth-card stack">
            <div class="stack-tight">
                <span class="eyebrow" style="color: var(--text);">Owner Access</span>
                <h1>Sign in to your bakery workspace</h1>
                <p class="muted">Track inventory, manage products, process counter sales, and handle customer pre-orders from one clean dashboard.</p>
            </div>

            <div class="surface-note">
                Use the owner account for internal management only. The customer-facing order page is a separate public link.
            </div>

            <form action="<?php echo e(route('login.store')); ?>" method="POST" class="stack">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required>
                </div>

                <button class="button" type="submit">Login to Dashboard</button>
            </form>

            <p class="muted">No owner account yet? <a href="<?php echo e(route('register')); ?>">Create one here.</a></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/auth/login.blade.php ENDPATH**/ ?>