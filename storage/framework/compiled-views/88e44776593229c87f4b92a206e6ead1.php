<?php $__env->startSection('content'); ?>
    <div class="auth-shell">
        <div class="card auth-card stack">
            <div class="stack-tight">
                <span class="eyebrow" style="color: var(--text);">Owner Setup</span>
                <h1>Create the first bakery account</h1>
                <p class="muted">This creates one owner login and one bakery profile so you can start managing products, customers, and orders immediately.</p>
            </div>

            <div class="surface-note">
                Keep the bakery name clear and short. It will also be used for the public customer ordering link.
            </div>

            <form action="<?php echo e(route('register.store')); ?>" method="POST" class="stack">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="owner_name">Owner Name</label>
                    <input id="owner_name" name="owner_name" type="text" value="<?php echo e(old('owner_name')); ?>" required>
                </div>

                <div>
                    <label for="shop_name">Bakery Name</label>
                    <input id="shop_name" name="shop_name" type="text" value="<?php echo e(old('shop_name')); ?>" required>
                </div>

                <div>
                    <label for="email">Login Email</label>
                    <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required>
                </div>

                <div>
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required>
                </div>

                <button class="button" type="submit">Create Owner Account</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/auth/register.blade.php ENDPATH**/ ?>