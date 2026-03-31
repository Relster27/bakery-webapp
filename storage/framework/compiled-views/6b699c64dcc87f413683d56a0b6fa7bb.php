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
                <label for="bank_details">Bank Details</label>
                <textarea id="bank_details" name="bank_details"><?php echo e(old('bank_details', $bakery->bank_details)); ?></textarea>
            </div>

            <div class="card" style="background: #fff;">
                <strong>QR Target Link</strong>
                <p><a href="<?php echo e(route('menu.show', $bakery->qr_token)); ?>" target="_blank"><?php echo e(route('menu.show', $bakery->qr_token)); ?></a></p>
            </div>

            <button class="button" type="submit">Save Bakery Profile</button>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/bakery/edit.blade.php ENDPATH**/ ?>