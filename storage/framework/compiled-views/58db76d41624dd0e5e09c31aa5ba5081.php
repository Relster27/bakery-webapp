<?php $__env->startSection('content'); ?>
    <section class="card stack">
        <div>
            <h1>Bakery Profile</h1>
            <p class="muted">This page stores the bakery identity used by the owner dashboard and public menu.</p>
        </div>

        <form action="<?php echo e(route('bakery.update')); ?>" method="POST" class="stack">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">
                <div>
                    <label for="shop_name">Bakery Name</label>
                    <input id="shop_name" name="shop_name" type="text" value="<?php echo e(old('shop_name', $bakery->shop_name)); ?>" required>
                </div>

                <div>
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" type="text" value="<?php echo e(old('phone', $bakery->phone)); ?>">
                </div>

                <div>
                    <label for="email">Public Email</label>
                    <input id="email" name="email" type="email" value="<?php echo e(old('email', $bakery->email)); ?>">
                </div>
            </div>

            <div>
                <label for="address">Address</label>
                <textarea id="address" name="address"><?php echo e(old('address', $bakery->address)); ?></textarea>
            </div>

            <div>
                <h3 style="margin-bottom: 0.75rem; font-size: 1rem;">Bank Transfer Details</h3>
                <p class="muted" style="margin-bottom: 1rem; font-size: 0.88rem;">These details will be shown to customers on the payment page when they choose Bank Transfer.</p>
                <div class="form-grid">
                    <div>
                        <label for="bank_name">Bank Name</label>
                        <input id="bank_name" name="bank_name" type="text" placeholder="e.g. BCA, Mandiri, BNI" value="<?php echo e(old('bank_name', $bakery->bank_name)); ?>">
                    </div>
                    <div>
                        <label for="bank_account_number">Account Number</label>
                        <input id="bank_account_number" name="bank_account_number" type="text" placeholder="e.g. 1234567890" value="<?php echo e(old('bank_account_number', $bakery->bank_account_number)); ?>">
                    </div>
                    <div>
                        <label for="bank_account_name">Account Holder Name</label>
                        <input id="bank_account_name" name="bank_account_name" type="text" placeholder="e.g. Morning Crumbs Bakery" value="<?php echo e(old('bank_account_name', $bakery->bank_account_name)); ?>">
                    </div>
                </div>
            </div>

            <div class="card" style="background: #fff;">
                <strong>Public Ordering Link</strong>
                <p><a href="<?php echo e(route('menu.show', $bakery->public_slug)); ?>" target="_blank"><?php echo e(route('menu.show', $bakery->public_slug)); ?></a></p>
            </div>

            <button class="button" type="submit">Save Bakery Profile</button>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\final\bakery-webapp\resources\views/bakery/edit.blade.php ENDPATH**/ ?>