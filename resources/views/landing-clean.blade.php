<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bakery Management System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap');

        :root {
            --bg: #f6f0e7;
            --surface: rgba(255, 252, 247, 0.92);
            --line: rgba(90, 60, 40, 0.12);
            --ink: #2f241e;
            --muted: #6f6259;
            --accent: #b76838;
            --accent-deep: #8d4b28;
            --accent-soft: #f1decf;
            --success: #566746;
            --shadow: 0 24px 60px rgba(72, 45, 24, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(208, 153, 104, 0.18), transparent 28%),
                radial-gradient(circle at bottom right, rgba(181, 126, 81, 0.12), transparent 26%),
                var(--bg);
            color: var(--ink);
            font-family: "Manrope", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.55;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .shell {
            width: min(1180px, calc(100vw - 40px));
            margin: 0 auto;
        }

        .site-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding: 28px 0 18px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #4e3a2d;
        }

        .brand-mark {
            width: 14px;
            height: 14px;
            border-radius: 999px;
            background: linear-gradient(135deg, #cf8b54, #9b562e);
            box-shadow: 0 0 0 8px rgba(183, 104, 56, 0.12);
        }

        .nav-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 20px;
            border-radius: 999px;
            border: 1px solid transparent;
            font-weight: 600;
            transition: 180ms ease;
        }

        .button-primary {
            background: var(--accent);
            color: #fff9f5;
            box-shadow: 0 14px 30px rgba(183, 104, 56, 0.24);
        }

        .button-primary:hover {
            background: var(--accent-deep);
        }

        .button-secondary {
            background: rgba(255, 251, 246, 0.78);
            border-color: var(--line);
            color: var(--ink);
        }

        .button-secondary:hover {
            background: #fffaf4;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(320px, 0.95fr);
            gap: 36px;
            align-items: center;
            padding: 38px 0 28px;
        }

        .eyebrow {
            display: inline-block;
            margin-bottom: 16px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 248, 240, 0.86);
            border: 1px solid rgba(106, 71, 47, 0.12);
            color: #81583e;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.11em;
            text-transform: uppercase;
        }

        .hero h1,
        .section-copy h2,
        .cta h2 {
            margin: 0;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
            line-height: 1.02;
            letter-spacing: -0.045em;
        }

        .hero h1 {
            max-width: 10ch;
            font-size: clamp(3rem, 5vw, 5rem);
            font-weight: 800;
        }

        .hero p {
            max-width: 57ch;
            margin: 18px 0 0;
            font-size: 1.08rem;
            color: var(--muted);
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-top: 28px;
        }

        .hero-notes {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 34px;
        }

        .note {
            padding: 18px 18px 16px;
            border-radius: 20px;
            background: rgba(255, 251, 245, 0.74);
            border: 1px solid var(--line);
        }

        .note strong {
            display: block;
            margin-bottom: 6px;
            font-size: 0.95rem;
        }

        .note span {
            display: block;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .hero-panel {
            padding: 24px;
            border-radius: 30px;
            background: linear-gradient(180deg, rgba(255, 251, 247, 0.92), rgba(248, 239, 229, 0.92));
            border: 1px solid rgba(108, 72, 47, 0.12);
            box-shadow: var(--shadow);
        }

        .panel-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .panel-title {
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: #7e5a44;
        }

        .panel-badge {
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(86, 103, 70, 0.12);
            color: var(--success);
            font-size: 0.78rem;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .panel-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .metric {
            padding: 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(108, 72, 47, 0.1);
        }

        .metric small {
            display: block;
            margin-bottom: 10px;
            color: #8b7363;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .metric strong {
            display: block;
            font-size: 1.5rem;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 800;
        }

        .metric span {
            display: block;
            margin-top: 6px;
            font-size: 0.92rem;
            color: var(--muted);
        }

        .panel-list {
            margin: 16px 0 0;
            padding: 18px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.62);
            border: 1px solid rgba(108, 72, 47, 0.1);
        }

        .panel-list h3 {
            margin: 0 0 12px;
            font-size: 1rem;
        }

        .panel-list ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 10px;
        }

        .panel-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: var(--muted);
        }

        .panel-list li::before {
            content: "";
            width: 9px;
            height: 9px;
            margin-top: 8px;
            flex: 0 0 9px;
            border-radius: 999px;
            background: var(--accent);
        }

        .section {
            padding: 32px 0;
        }

        .section-copy {
            max-width: 720px;
            margin-bottom: 24px;
        }

        .section-copy h2 {
            font-size: clamp(2rem, 3vw, 3rem);
        }

        .section-copy p {
            margin: 12px 0 0;
            color: var(--muted);
            font-size: 1rem;
        }

        .feature-grid,
        .audience-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .audience-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .card {
            padding: 26px;
            border-radius: 26px;
            background: var(--surface);
            border: 1px solid var(--line);
            box-shadow: 0 20px 50px rgba(72, 45, 24, 0.08);
        }

        .card h3 {
            margin: 0 0 10px;
            font-size: 1.15rem;
        }

        .card p {
            margin: 0;
            color: var(--muted);
        }

        .feature-icon {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            border-radius: 14px;
            background: var(--accent-soft);
            color: var(--accent-deep);
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
        }

        .audience-card {
            display: grid;
            gap: 16px;
        }

        .audience-card ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 10px;
        }

        .audience-card li {
            color: var(--muted);
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(90, 60, 40, 0.08);
        }

        .audience-card li:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .cta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding: 28px 30px;
            margin: 24px 0 56px;
            border-radius: 28px;
            background: linear-gradient(135deg, #4e3427, #6d4831 60%, #8b5a3d);
            color: #fdf6ef;
            box-shadow: 0 28px 60px rgba(72, 45, 24, 0.18);
        }

        .cta h2 {
            font-size: clamp(1.8rem, 2.8vw, 2.6rem);
            max-width: 13ch;
        }

        .cta p {
            margin: 10px 0 0;
            max-width: 54ch;
            color: rgba(255, 246, 237, 0.78);
        }

        .cta .button-secondary {
            background: rgba(255, 250, 244, 0.12);
            color: #fffaf3;
            border-color: rgba(255, 245, 235, 0.22);
        }

        @media (max-width: 980px) {
            .hero,
            .feature-grid,
            .audience-grid,
            .hero-notes {
                grid-template-columns: 1fr;
            }

            .cta {
                flex-direction: column;
                align-items: flex-start;
            }

            .cta h2 {
                max-width: none;
            }
        }

        @media (max-width: 640px) {
            .shell {
                width: min(100vw - 24px, 1180px);
            }

            .site-header {
                padding-top: 18px;
            }

            .hero {
                padding-top: 18px;
            }

            .hero h1 {
                max-width: none;
                font-size: 2.6rem;
            }

            .panel-grid {
                grid-template-columns: 1fr;
            }

            .nav-actions,
            .hero-actions {
                width: 100%;
            }

            .button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        <header class="site-header">
            <a class="brand" href="{{ route('landing') }}">
                <span class="brand-mark"></span>
                <span>Bakery Management System</span>
            </a>

            <div class="nav-actions">
                <a class="button button-secondary" href="{{ route('login') }}">Login</a>
                <a class="button button-primary" href="{{ route('register') }}">Register</a>
            </div>
        </header>

        <main>
            <section class="hero">
                <div>
                    <span class="eyebrow">Laravel MVC Bakery Project</span>
                    <h1>Run your bakery from one calmer, cleaner workspace.</h1>
                    <p>
                        This system brings product setup, inventory tracking, counter sales, pre-orders, timed discounts,
                        custom cake requests, and reporting into one browser-based workflow that is easier to present and
                        easier to operate.
                    </p>

                    <div class="hero-actions">
                        <a class="button button-primary" href="{{ route('register') }}">Create owner account</a>
                        <a class="button button-secondary" href="{{ route('login') }}">Open login</a>
                    </div>

                    <div class="hero-notes">
                        <div class="note">
                            <strong>Daily operations</strong>
                            <span>Products, pricing, stock, and orders stay connected.</span>
                        </div>
                        <div class="note">
                            <strong>Customer flow</strong>
                            <span>Public menu ordering and custom cake requests are already included.</span>
                        </div>
                        <div class="note">
                            <strong>Project-ready</strong>
                            <span>Built with controllers, models, migrations, Blade views, and MySQL.</span>
                        </div>
                    </div>
                </div>

                <aside class="hero-panel">
                    <div class="panel-top">
                        <div class="panel-title">Bakery Overview</div>
                        <div class="panel-badge">Live workflow</div>
                    </div>

                    <div class="panel-grid">
                        <div class="metric">
                            <small>Orders</small>
                            <strong>Counter + Pickup</strong>
                            <span>Fast walk-in orders and scheduled pre-orders.</span>
                        </div>
                        <div class="metric">
                            <small>Inventory</small>
                            <strong>Real-time stock</strong>
                            <span>Deducted on order placement and restored on expiration.</span>
                        </div>
                        <div class="metric">
                            <small>Pricing</small>
                            <strong>Timed discounts</strong>
                            <span>Flash-sale rules flow into customer-facing totals.</span>
                        </div>
                        <div class="metric">
                            <small>Reporting</small>
                            <strong>Revenue clarity</strong>
                            <span>Analytics, fees, and production planning in one place.</span>
                        </div>
                    </div>

                    <div class="panel-list">
                        <h3>What this version already handles</h3>
                        <ul>
                            <li>Owner authentication and bakery profile management</li>
                            <li>Menu editing, stock control, and reorder-level tracking</li>
                            <li>Order lifecycle from pending to completed or expired</li>
                            <li>Public ordering link, customer records, and custom cake intake</li>
                        </ul>
                    </div>
                </aside>
            </section>

            <section class="section">
                <div class="section-copy">
                    <span class="eyebrow">Core strengths</span>
                    <h2>Designed to look like a product, not just a form collection.</h2>
                    <p>
                        The landing page is intentionally simpler than the app interior: more whitespace, fewer visual blocks,
                        and clearer grouping so it feels professional when you show it in a presentation.
                    </p>
                </div>

                <div class="feature-grid">
                    <article class="card">
                        <div class="feature-icon">01</div>
                        <h3>Operational clarity</h3>
                        <p>Owners can manage products, stock, discounts, and orders without jumping across disconnected pages or tools.</p>
                    </article>
                    <article class="card">
                        <div class="feature-icon">02</div>
                        <h3>Bakery-specific flow</h3>
                        <p>The system is shaped around bakery work: counter sales, pickup pre-orders, low stock, and cake requests.</p>
                    </article>
                    <article class="card">
                        <div class="feature-icon">03</div>
                        <h3>Presentation-ready structure</h3>
                        <p>It already reflects Laravel MVC architecture, database migrations, and features that map cleanly into backlog items.</p>
                    </article>
                </div>
            </section>

            <section class="section">
                <div class="section-copy">
                    <span class="eyebrow">Two-sided experience</span>
                    <h2>One app for the owner, one simple journey for the customer.</h2>
                    <p>
                        The owner side focuses on internal control. The customer side keeps ordering simple and direct.
                    </p>
                </div>

                <div class="audience-grid">
                    <article class="card audience-card">
                        <div>
                            <h3>Owner dashboard</h3>
                            <p>For bakery staff or owners who manage operations throughout the day.</p>
                        </div>
                        <ul>
                            <li>Register and log in as the bakery owner</li>
                            <li>Maintain products, pricing, and inventory levels</li>
                            <li>Create orders, update status, and monitor revenue</li>
                            <li>Review discounts, analytics, and production reports</li>
                        </ul>
                    </article>

                    <article class="card audience-card">
                        <div>
                            <h3>Customer ordering pages</h3>
                            <p>For customers who want a quick, clear ordering flow from a public link.</p>
                        </div>
                        <ul>
                            <li>Browse the active menu and visible stock</li>
                            <li>Place a pickup pre-order without seeing the admin area</li>
                            <li>See discount-adjusted totals during active time windows</li>
                            <li>Submit a custom cake request with event details</li>
                        </ul>
                    </article>
                </div>
            </section>

            <section class="cta">
                <div>
                    <span class="eyebrow" style="background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.18); color: #fff2e7;">Separate demo page</span>
                    <h2>Keep login as the root, and use this page as the front-facing preview.</h2>
                    <p>
                        This route does not change the current app entry. It only gives you a cleaner landing page to show when needed.
                    </p>
                </div>

                <div class="nav-actions">
                    <a class="button button-secondary" href="{{ route('login') }}">Go to login</a>
                    <a class="button button-primary" href="{{ route('register') }}">Go to register</a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
