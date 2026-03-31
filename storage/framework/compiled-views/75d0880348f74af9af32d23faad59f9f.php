<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'Bakery Web App'); ?></title>
    <style>
        :root {
            --paper: #f7f0e6;
            --paper-deep: #e7d7bf;
            --panel: rgba(255, 252, 247, 0.88);
            --panel-solid: #fffaf3;
            --line: rgba(134, 102, 76, 0.18);
            --line-strong: rgba(112, 82, 58, 0.28);
            --text: #2e221b;
            --muted: #786657;
            --accent: #b7673a;
            --accent-deep: #8f472c;
            --accent-soft: rgba(214, 170, 134, 0.2);
            --accent-cream: #fff3e7;
            --forest: #64715b;
            --forest-soft: rgba(100, 113, 91, 0.12);
            --success: #e2f0dd;
            --danger: #f8dedd;
            --shadow: 0 22px 54px rgba(59, 34, 18, 0.12);
            --radius: 24px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", "Trebuchet MS", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(214, 151, 95, 0.24), transparent 26%),
                radial-gradient(circle at 84% 9%, rgba(100, 113, 91, 0.18), transparent 20%),
                radial-gradient(circle at 50% 100%, rgba(196, 127, 85, 0.12), transparent 25%),
                linear-gradient(180deg, #fbf6ef 0%, #f2e5d1 48%, #ebdeca 100%);
            color: var(--text);
            line-height: 1.5;
        }

        a {
            color: var(--accent);
            text-decoration: none;
            transition: color 0.2s ease, opacity 0.2s ease;
        }

        a:hover {
            color: var(--accent-deep);
        }

        .shell {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .shell::before,
        .shell::after {
            content: "";
            position: fixed;
            z-index: 0;
            pointer-events: none;
            border-radius: 999px;
            filter: blur(8px);
        }

        .shell::before {
            width: 18rem;
            height: 18rem;
            top: 6rem;
            left: -4rem;
            background: rgba(221, 175, 134, 0.24);
        }

        .shell::after {
            width: 20rem;
            height: 20rem;
            right: -5rem;
            bottom: 8rem;
            background: rgba(123, 143, 117, 0.12);
        }

        .topbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem 1.5rem;
            width: min(1180px, calc(100% - 1.25rem));
            margin: 1rem auto 0;
            padding: 0.95rem 1.1rem;
            border: 1px solid rgba(255, 246, 236, 0.08);
            border-radius: 30px;
            background:
                linear-gradient(135deg, rgba(40, 28, 22, 0.9), rgba(83, 54, 42, 0.84));
            position: sticky;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(16px);
            box-shadow: 0 18px 44px rgba(28, 18, 14, 0.22);
        }

        .brand {
            display: grid;
            gap: 0.18rem;
            color: #fff8f1;
        }

        .brand strong {
            font-family: "Palatino Linotype", "Book Antiqua", Georgia, serif;
            font-size: 1.55rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .brand span {
            color: rgba(255, 239, 224, 0.72);
            font-size: 0.78rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
        }

        .nav {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .nav a,
        .nav button {
            width: auto;
            border: 1px solid rgba(255, 250, 245, 0.14);
            background: rgba(255, 249, 242, 0.08);
            color: #fff9f3;
            padding: 0.6rem 0.9rem;
            border-radius: 999px;
            cursor: pointer;
            font: inherit;
            transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }

        .nav a:hover,
        .nav button:hover {
            transform: translateY(-1px);
            background: rgba(255, 249, 242, 0.15);
            border-color: rgba(255, 250, 245, 0.24);
        }

        .nav .primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-deep));
            color: white;
            border-color: transparent;
            box-shadow: 0 12px 26px rgba(143, 71, 44, 0.28);
        }

        .container {
            position: relative;
            z-index: 1;
            width: min(1180px, calc(100% - 1.25rem));
            margin: 1.35rem auto 3.5rem;
        }

        .hero,
        .card {
            border-radius: var(--radius);
            padding: 1.35rem;
            animation: rise 0.45s ease both;
        }

        .hero {
            position: relative;
            overflow: hidden;
            margin-bottom: 1.1rem;
            background:
                radial-gradient(circle at 100% 0%, rgba(255, 255, 255, 0.18), transparent 28%),
                linear-gradient(135deg, rgba(43, 30, 24, 0.96), rgba(119, 73, 49, 0.9));
            border: 1px solid rgba(255, 248, 240, 0.08);
            color: #fff7ef;
            box-shadow: 0 26px 56px rgba(52, 31, 22, 0.16);
        }

        .hero::after {
            content: "";
            position: absolute;
            right: -2.4rem;
            bottom: -3.6rem;
            width: 12rem;
            height: 12rem;
            background: radial-gradient(circle, rgba(255, 227, 196, 0.26) 0%, transparent 70%);
            border-radius: 999px;
        }

        .hero .muted {
            color: rgba(255, 241, 228, 0.72);
        }

        .hero a {
            color: #fffef9;
            text-decoration: underline;
            text-decoration-color: rgba(255, 254, 249, 0.36);
            text-underline-offset: 0.18em;
        }

        .card {
            background: var(--panel);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            backdrop-filter: blur(12px);
        }

        .grid {
            display: grid;
            gap: 1rem;
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
        }

        .grid-4 {
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        }

        .stat {
            padding: 1.15rem 1.05rem;
            border-radius: 20px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(250, 244, 236, 0.92));
            border: 1px solid var(--line);
            box-shadow: 0 14px 28px rgba(83, 55, 35, 0.06);
        }

        .stat small,
        .muted {
            color: var(--muted);
        }

        h1,
        h2,
        h3 {
            margin-top: 0;
            margin-bottom: 0.35rem;
            font-family: "Palatino Linotype", "Book Antiqua", Georgia, serif;
            line-height: 1.08;
        }

        h1 {
            font-size: clamp(2rem, 4vw, 3.15rem);
        }

        h2 {
            font-size: 1.45rem;
        }

        h3 {
            font-size: 1.15rem;
        }

        p {
            margin: 0 0 0.75rem;
        }

        ul {
            margin: 0.6rem 0 0;
            padding-left: 1.2rem;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            margin-bottom: 0.85rem;
            color: rgba(255, 238, 223, 0.88);
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.24em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            content: "";
            width: 0.8rem;
            height: 0.8rem;
            border-radius: 999px;
            background: linear-gradient(135deg, #f3c18f, #c67743);
            box-shadow: 0 0 0 5px rgba(243, 193, 143, 0.12);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.6fr) minmax(260px, 0.9fr);
            gap: 1rem;
            align-items: start;
            position: relative;
            z-index: 1;
        }

        .hero-aside {
            padding: 1rem;
            border-radius: 20px;
            background: rgba(255, 251, 245, 0.1);
            border: 1px solid rgba(255, 248, 240, 0.14);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        .hero-aside .eyebrow {
            margin-bottom: 0.55rem;
        }

        .hero-aside p:last-child {
            margin-bottom: 0;
        }

        table {
            width: 100%;
            display: block;
            overflow-x: auto;
            border-collapse: collapse;
            white-space: nowrap;
            border-radius: 18px;
        }

        th,
        td {
            text-align: left;
            padding: 0.92rem 0.8rem;
            border-bottom: 1px solid rgba(179, 151, 126, 0.18);
            vertical-align: top;
        }

        thead th {
            color: #776455;
            font-size: 0.76rem;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        tbody tr {
            transition: background 0.18s ease;
        }

        tbody tr:hover {
            background: rgba(243, 231, 216, 0.42);
        }

        form {
            margin: 0;
        }

        label {
            display: block;
            margin-bottom: 0.45rem;
            font-size: 0.84rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            color: #4f3d30;
        }

        input,
        select,
        textarea,
        button {
            width: 100%;
            font: inherit;
        }

        input,
        select,
        textarea {
            padding: 0.82rem 0.9rem;
            border-radius: 16px;
            border: 1px solid rgba(186, 157, 129, 0.44);
            background: rgba(255, 255, 255, 0.96);
            color: var(--text);
            box-shadow: inset 0 1px 2px rgba(69, 44, 29, 0.04);
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: rgba(183, 103, 58, 0.66);
            box-shadow: 0 0 0 4px rgba(183, 103, 58, 0.12);
            transform: translateY(-1px);
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .form-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .stack {
            display: grid;
            gap: 1rem;
        }

        .stack-tight {
            display: grid;
            gap: 0.55rem;
        }

        .button,
        .button-inline {
            background: linear-gradient(135deg, var(--accent), var(--accent-deep));
            color: white;
            border: none;
            border-radius: 999px;
            padding: 0.85rem 1.05rem;
            cursor: pointer;
            box-shadow: 0 14px 28px rgba(143, 71, 44, 0.22);
            transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
        }

        .button:hover,
        .button-inline:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 30px rgba(143, 71, 44, 0.24);
            filter: saturate(1.03);
        }

        .button-inline {
            width: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.7rem 0.95rem;
        }

        .button-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: var(--text);
            border: 1px solid var(--line-strong);
            box-shadow: none;
        }

        .badge {
            display: inline-block;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            background: var(--forest-soft);
            border: 1px solid rgba(100, 113, 91, 0.2);
            color: #56634f;
        }

        .flash {
            padding: 0.95rem 1.05rem;
            border-radius: 18px;
            margin-bottom: 1rem;
            box-shadow: var(--shadow);
        }

        .flash-success {
            background: var(--success);
            border: 1px solid rgba(112, 145, 98, 0.22);
        }

        .flash-error {
            background: var(--danger);
            border: 1px solid rgba(178, 95, 95, 0.2);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
        }

        .auth-shell {
            min-height: calc(100vh - 9rem);
            display: grid;
            place-items: center;
            padding: 2rem 0;
        }

        .auth-card {
            width: min(560px, 100%);
        }

        .auth-card .card {
            background:
                linear-gradient(180deg, rgba(255, 253, 249, 0.96), rgba(249, 240, 229, 0.94));
        }

        .surface-note {
            padding: 0.95rem 1rem;
            border-radius: 18px;
            background: rgba(183, 103, 58, 0.08);
            border: 1px solid rgba(183, 103, 58, 0.12);
            color: #5e4739;
        }

        .subcard {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.92), rgba(248, 241, 233, 0.88));
            border: 1px solid rgba(180, 149, 121, 0.16);
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 700px) {
            .topbar {
                width: min(100% - 0.8rem, 1180px);
                padding: 0.9rem;
                border-radius: 24px;
            }

            .container {
                width: min(100% - 0.8rem, 1180px);
                margin-top: 1rem;
            }

            .hero-grid {
                grid-template-columns: 1fr;
            }

            .hero,
            .card {
                padding: 1.1rem;
            }
        }
    </style>
</head>
<body>
<div class="shell">
    <header class="topbar">
        <div class="brand">
            <strong>Morning Batch</strong>
            <span>Bakery Inventory & Ordering Management</span>
        </div>
        <nav class="nav">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('products.index')); ?>">Products</a>
                <a href="<?php echo e(route('inventories.index')); ?>">Inventory</a>
                <a href="<?php echo e(route('customers.index')); ?>">Customers</a>
                <a href="<?php echo e(route('orders.index')); ?>">Orders</a>
                <a href="<?php echo e(route('bakery.edit')); ?>">Bakery</a>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit">Logout</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>">Login</a>
                <a class="primary" href="<?php echo e(route('register')); ?>">Register</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="container">
        <?php if(session('success')): ?>
            <div class="flash flash-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="flash flash-error">
                <strong>Please fix these fields:</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
</body>
</html>
<?php /**PATH D:\SE\bakery-webapp\resources\views/layouts/app.blade.php ENDPATH**/ ?>