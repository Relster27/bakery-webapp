<?php $__env->startSection('content'); ?>
    <section class="card stack">
        <div>
            <h1>Add Customer</h1>
            <p class="muted">Use this if you want to register a regular customer before they place an order.</p>
        </div>

        <form action="<?php echo e(route('customers.store')); ?>" method="POST" class="stack">
            <?php echo csrf_field(); ?>

            <div class="form-grid">
                <div>
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" value="<?php echo e(old('name')); ?>" required>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>">
                </div>

                <div>
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" type="text" value="<?php echo e(old('phone')); ?>">
                </div>
            </div>

            <div class="actions">
                <button class="button-inline" type="submit">Save Customer</button>
                <a class="button-inline button-secondary" href="<?php echo e(route('customers.index')); ?>">Back</a>
            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/customers/create.blade.php ENDPATH**/ ?>