<?php $__env->startSection('content'); ?>
    <section class="grid grid-2">
        <div class="card stack">
            <div>
                <span class="eyebrow" style="color: var(--text);">Flash Sale Rules</span>
                <h1>Automate Time-Based Discounts</h1>
                <p class="muted">Create discount windows for all products or a specific category. The lowest live price is applied automatically during order placement.</p>
            </div>

            <form action="<?php echo e(route('discounts.store')); ?>" method="POST" class="stack">
                <?php echo csrf_field(); ?>

                <div class="form-grid">
                    <div>
                        <label for="name">Rule Name</label>
                        <input id="name" name="name" type="text" value="<?php echo e(old('name')); ?>" required>
                    </div>

                    <div>
                        <label for="scope">Scope</label>
                        <select id="scope" name="scope" required>
                            <option value="all" <?php if(old('scope', 'all') === 'all'): echo 'selected'; endif; ?>>All products</option>
                            <option value="category" <?php if(old('scope') === 'category'): echo 'selected'; endif; ?>>Specific category</option>
                        </select>
                    </div>

                    <div>
                        <label for="category">Category</label>
                        <select id="category" name="category">
                            <option value="">Only needed for category scope</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category); ?>" <?php if(old('category') === $category): echo 'selected'; endif; ?>><?php echo e($category); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="start_time">Starts At</label>
                        <input id="start_time" name="start_time" type="time" value="<?php echo e(old('start_time', '18:00')); ?>" required>
                    </div>

                    <div>
                        <label for="end_time">Ends At</label>
                        <input id="end_time" name="end_time" type="time" value="<?php echo e(old('end_time', '21:00')); ?>" required>
                    </div>

                    <div>
                        <label for="discount_percent">Discount Percent</label>
                        <input id="discount_percent" name="discount_percent" type="number" min="1" max="90" step="0.5" value="<?php echo e(old('discount_percent', 20)); ?>" required>
                    </div>
                </div>

                <button class="button" type="submit">Create Discount Rule</button>
            </form>
        </div>

        <div class="card stack">
            <div>
                <h2>Current Rules</h2>
                <p class="muted">Activate the rules you want live. Create a new rule if you need a new schedule or discount shape.</p>
            </div>

            <?php if($rules->isEmpty()): ?>
                <p class="muted">No discount rules yet. Create your first flash sale window from the form on the left.</p>
            <?php else: ?>
                <div class="report-list">
                    <?php $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="report-row-wide">
                            <div class="product-main">
                                <strong><?php echo e($rule->name); ?></strong>
                                <p class="product-copy"><?php echo e($rule->scope === 'all' ? 'All products' : 'Category: '.$rule->category); ?></p>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Window</span>
                                <span class="product-value"><?php echo e(substr($rule->start_time, 0, 5)); ?> - <?php echo e(substr($rule->end_time, 0, 5)); ?></span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Discount</span>
                                <span class="product-value"><?php echo e(rtrim(rtrim(number_format((float) $rule->discount_percent, 2, '.', ''), '0'), '.')); ?>%</span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Status</span>
                                <span class="badge <?php echo e($rule->is_active ? '' : 'badge-muted'); ?>"><?php echo e($rule->is_active ? 'ACTIVE' : 'PAUSED'); ?></span>
                            </div>

                            <div class="row-actions">
                                <form action="<?php echo e(route('discounts.update', $rule)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <input type="hidden" name="is_active" value="<?php echo e($rule->is_active ? 0 : 1); ?>">
                                    <button class="button-inline <?php echo e($rule->is_active ? 'button-secondary' : ''); ?>" type="submit">
                                        <?php echo e($rule->is_active ? 'Pause Rule' : 'Activate Rule'); ?>

                                    </button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/discounts/index.blade.php ENDPATH**/ ?>