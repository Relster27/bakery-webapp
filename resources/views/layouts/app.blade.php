<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Return-Oriented Pastries' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap');

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
            font-family: "Manrope", "Segoe UI", "Trebuchet MS", sans-serif;
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
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-size: 1.55rem;
            font-weight: 700;
            letter-spacing: -0.02em;
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

        .hero > * {
            position: relative;
            z-index: 1;
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
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
            letter-spacing: -0.03em;
            line-height: 1.04;
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

        .badge-muted {
            background: rgba(112, 100, 91, 0.08);
            border: 1px solid rgba(112, 100, 91, 0.18);
            color: #6a5b50;
        }

        .badge-hero {
            background: rgba(255, 247, 238, 0.18);
            border: 1px solid rgba(255, 240, 224, 0.24);
            color: #fff8f1;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(6px);
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

        .product-list {
            display: grid;
            gap: 0.9rem;
        }

        .product-row {
            display: grid;
            grid-template-columns: minmax(0, 1.8fr) repeat(3, minmax(110px, 0.55fr)) auto;
            gap: 1rem;
            align-items: center;
            padding: 1rem 1.05rem;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(249, 243, 236, 0.92));
            border: 1px solid rgba(176, 146, 121, 0.16);
        }

        .product-main {
            min-width: 0;
            display: grid;
            gap: 0.28rem;
        }

        .product-main strong {
            font-size: 1.04rem;
        }

        .product-copy {
            margin: 0;
            color: var(--muted);
            white-space: normal;
        }

        .product-meta {
            min-width: 0;
            display: grid;
            gap: 0.15rem;
        }

        .product-label {
            color: #897667;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .product-value {
            font-size: 0.98rem;
            font-weight: 700;
            color: var(--text);
        }

        .product-actions {
            display: flex;
            justify-content: flex-end;
        }

        .required-star {
            color: #c4442f;
            margin-left: 0.18rem;
            font-weight: 800;
        }

        .helper-text {
            margin: 0.28rem 0 0;
            color: var(--muted);
            font-size: 0.84rem;
            line-height: 1.45;
        }

        .hidden {
            display: none !important;
        }

        .selector-list {
            display: grid;
            gap: 0.9rem;
            margin-top: 1rem;
        }

        .selector-row {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(110px, 0.55fr) minmax(90px, 0.45fr) minmax(150px, 0.7fr);
            gap: 1rem;
            align-items: center;
            padding: 1rem 1.05rem;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(249, 243, 236, 0.92));
            border: 1px solid rgba(176, 146, 121, 0.16);
        }

        .selector-quantity {
            min-width: 0;
        }

        .selector-quantity input {
            min-width: 0;
        }

        .field-invalid {
            border-color: rgba(196, 68, 47, 0.9) !important;
            background: rgba(255, 244, 243, 0.98) !important;
            box-shadow: 0 0 0 4px rgba(196, 68, 47, 0.12) !important;
        }

        .subcard-invalid {
            border-color: rgba(196, 68, 47, 0.38) !important;
            box-shadow:
                0 18px 34px rgba(59, 34, 18, 0.08),
                0 0 0 4px rgba(196, 68, 47, 0.08) !important;
        }

        .error-text {
            color: #b23d2b;
            font-weight: 600;
        }

        .inventory-list {
            display: grid;
            gap: 0.95rem;
        }

        .inventory-row {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(110px, 0.45fr) minmax(120px, 0.5fr) minmax(320px, 1fr);
            gap: 1rem;
            align-items: center;
            padding: 1rem 1.05rem;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(249, 243, 236, 0.92));
            border: 1px solid rgba(176, 146, 121, 0.16);
        }

        .inventory-form {
            display: grid;
            grid-template-columns: repeat(2, minmax(110px, 1fr)) auto;
            gap: 0.8rem;
            align-items: end;
        }

        .inventory-form label {
            margin-bottom: 0.35rem;
        }

        .inventory-button {
            align-self: end;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(280px, 0.82fr);
            gap: 1rem;
            align-items: start;
        }

        .summary-list {
            display: grid;
            gap: 0.85rem;
        }

        .summary-row {
            display: grid;
            grid-template-columns: minmax(110px, 0.7fr) minmax(0, 1.4fr);
            gap: 0.9rem;
            align-items: start;
            padding: 0.95rem 1rem;
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 240, 231, 0.9));
            border: 1px solid rgba(180, 149, 121, 0.14);
        }

        .summary-key {
            color: #7b6859;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .summary-value {
            font-weight: 600;
            color: var(--text);
            min-width: 0;
            white-space: normal;
        }

        .status-panel {
            display: grid;
            gap: 1rem;
        }

        .status-current {
            padding: 1rem;
            border-radius: 20px;
            background: linear-gradient(180deg, rgba(255, 248, 240, 0.96), rgba(244, 233, 221, 0.9));
            border: 1px solid rgba(182, 150, 123, 0.18);
        }

        .status-current h3 {
            margin-bottom: 0.6rem;
        }

        .action-grid {
            display: grid;
            gap: 0.7rem;
        }

        .action-grid form {
            display: block;
        }

        .action-grid .button-inline {
            width: 100%;
            justify-content: center;
        }

        .item-list {
            display: grid;
            gap: 0.9rem;
        }

        .item-row {
            display: grid;
            grid-template-columns: minmax(0, 1.8fr) repeat(3, minmax(100px, 0.55fr));
            gap: 1rem;
            align-items: center;
            padding: 1rem 1.05rem;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(249, 243, 236, 0.92));
            border: 1px solid rgba(176, 146, 121, 0.16);
        }

        .item-highlight {
            padding: 1rem 1.05rem;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(255, 244, 232, 0.94), rgba(238, 222, 204, 0.92));
            color: #4b382d;
            border: 1px solid rgba(175, 133, 103, 0.22);
            box-shadow: 0 14px 24px rgba(52, 31, 22, 0.08);
        }

        .item-highlight .product-label,
        .item-highlight .muted {
            color: #8a6f5d;
        }

        .item-highlight .product-value {
            color: #8f472c;
        }

        .customer-list,
        .order-list {
            display: grid;
            gap: 0.9rem;
        }

        .dashboard-panels {
            margin-top: 1rem;
            align-items: stretch;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .dashboard-stat {
            min-height: 124px;
            display: grid;
            gap: 0.8rem;
            align-content: space-between;
            padding: 1.15rem 1.15rem 1.05rem;
        }

        .dashboard-stat small {
            display: block;
            max-width: 18ch;
            font-size: 0.76rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .dashboard-stat-value {
            display: block;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-size: clamp(1.6rem, 2vw, 2rem);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -0.03em;
            color: var(--text);
            word-break: break-word;
        }

        .dashboard-stat-value-money {
            font-size: clamp(1.35rem, 1.75vw, 1.72rem);
        }

        .dashboard-panel {
            display: grid;
            gap: 1rem;
            min-height: 100%;
        }

        .dashboard-panel-head {
            display: grid;
            gap: 0.25rem;
        }

        .dashboard-panel-head h2 {
            margin-bottom: 0.2rem;
        }

        .dashboard-panel-head p {
            margin: 0;
        }

        .dashboard-list {
            display: grid;
            gap: 0.85rem;
        }

        .dashboard-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: center;
            padding: 1rem;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(249, 243, 236, 0.92));
            border: 1px solid rgba(176, 146, 121, 0.16);
        }

        .dashboard-main {
            min-width: 0;
            display: grid;
            gap: 0.35rem;
        }

        .dashboard-main strong {
            font-size: 1.05rem;
        }

        .dashboard-details {
            display: flex;
            flex-wrap: wrap;
            gap: 0.85rem 1.15rem;
            margin-top: 0.15rem;
        }

        .dashboard-detail {
            display: grid;
            gap: 0.12rem;
            min-width: 96px;
        }

        .dashboard-detail .product-label {
            font-size: 0.68rem;
        }

        .dashboard-detail .badge {
            justify-self: start;
        }

        .dashboard-action {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .dashboard-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.7rem 0.95rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(112, 82, 58, 0.16);
            color: var(--accent-deep);
            font-weight: 700;
            white-space: nowrap;
        }

        .dashboard-link:hover {
            background: rgba(255, 250, 244, 0.98);
        }

        .landing-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(280px, 0.85fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .landing-hero-copy,
        .landing-hero-panel,
        .landing-card,
        .landing-flow {
            border-radius: 24px;
        }

        .landing-hero-copy {
            padding: 1.5rem;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.18), transparent 28%),
                linear-gradient(135deg, rgba(43, 30, 24, 0.96), rgba(119, 73, 49, 0.9));
            color: #fff7ef;
            box-shadow: 0 26px 56px rgba(52, 31, 22, 0.16);
        }

        .landing-hero-copy .muted {
            color: rgba(255, 241, 228, 0.76);
        }

        .landing-hero-panel {
            padding: 1.35rem;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(249, 243, 236, 0.92));
            border: 1px solid rgba(176, 146, 121, 0.16);
            box-shadow: var(--shadow);
        }

        .landing-kicker {
            margin-bottom: 0.8rem;
            color: #846f60;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .landing-checklist {
            display: grid;
            gap: 0.85rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .landing-checklist li {
            padding-left: 1.5rem;
            position: relative;
            color: var(--text);
            font-weight: 600;
        }

        .landing-checklist li::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0.42rem;
            width: 0.72rem;
            height: 0.72rem;
            border-radius: 999px;
            background: linear-gradient(135deg, #f3c18f, #c67743);
            box-shadow: 0 0 0 4px rgba(243, 193, 143, 0.12);
        }

        .landing-proof {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
            margin-top: 1.2rem;
        }

        .landing-proof-item {
            padding: 0.95rem 1rem;
            border-radius: 18px;
            background: rgba(255, 251, 245, 0.1);
            border: 1px solid rgba(255, 248, 240, 0.14);
        }

        .landing-proof-item strong,
        .landing-feature strong,
        .landing-step strong {
            display: block;
            margin-bottom: 0.28rem;
        }

        .landing-proof-item span {
            color: rgba(255, 241, 228, 0.76);
            font-size: 0.92rem;
        }

        .landing-section,
        .landing-metrics {
            margin-bottom: 1rem;
        }

        .landing-card-head {
            margin-bottom: 1rem;
        }

        .landing-eyebrow {
            color: #6a574a;
        }

        .landing-feature-list {
            display: grid;
            gap: 0.9rem;
        }

        .landing-feature {
            padding: 1rem;
            border-radius: 20px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 240, 231, 0.9));
            border: 1px solid rgba(180, 149, 121, 0.14);
        }

        .landing-feature p,
        .landing-step p,
        .landing-stat p {
            margin-bottom: 0;
        }

        .landing-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 0.95rem;
        }

        .landing-step {
            padding: 1rem;
            border-radius: 20px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(249, 243, 236, 0.92));
            border: 1px solid rgba(176, 146, 121, 0.16);
        }

        .landing-step span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.2rem;
            height: 2.2rem;
            margin-bottom: 0.75rem;
            border-radius: 999px;
            background: rgba(183, 103, 58, 0.12);
            color: var(--accent-deep);
            font-weight: 800;
            letter-spacing: 0.08em;
        }

        .landing-cta {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1.35rem 1.45rem;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(43, 30, 24, 0.96), rgba(119, 73, 49, 0.9));
            color: #fff7ef;
            box-shadow: 0 26px 56px rgba(52, 31, 22, 0.16);
        }

        .landing-cta h2 {
            max-width: 760px;
            margin-bottom: 0;
        }

        .price-stack {
            display: grid;
            gap: 0.18rem;
        }

        .price-old {
            color: #9c8b7e;
            font-size: 0.82rem;
            text-decoration: line-through;
        }

        .price-current {
            font-size: 1rem;
            font-weight: 700;
            color: var(--accent-deep);
        }

        .discount-note {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.6rem;
            border-radius: 999px;
            background: rgba(183, 103, 58, 0.12);
            color: var(--accent-deep);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .metric-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }

        .metric-card {
            padding: 1rem;
            border-radius: 20px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(248, 241, 233, 0.9));
            border: 1px solid rgba(180, 149, 121, 0.16);
        }

        .metric-card h3 {
            margin-bottom: 0.25rem;
            font-size: 0.96rem;
            font-family: "Manrope", "Segoe UI", "Trebuchet MS", sans-serif;
        }

        .metric-card strong {
            display: block;
            font-size: 1.4rem;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 800;
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: end;
        }

        .filter-bar > div {
            min-width: 160px;
            flex: 1 1 180px;
        }

        .report-list {
            display: grid;
            gap: 0.85rem;
        }

        .report-row {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) repeat(2, minmax(110px, 0.55fr));
            gap: 0.9rem;
            align-items: center;
            padding: 1rem;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(249, 243, 236, 0.92));
            border: 1px solid rgba(176, 146, 121, 0.16);
        }

        .report-row-wide {
            grid-template-columns: minmax(0, 1.35fr) repeat(3, minmax(110px, 0.5fr));
        }

        .step-card {
            padding: 1rem;
            border-radius: 20px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 240, 231, 0.9));
            border: 1px solid rgba(180, 149, 121, 0.14);
        }

        .step-card h3 {
            margin-bottom: 0.3rem;
        }

        .inline-note {
            margin: 0;
            color: var(--muted);
            font-size: 0.88rem;
        }

        .customer-row {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(180px, 0.95fr) minmax(150px, 0.8fr) auto;
            gap: 1rem;
            align-items: center;
            padding: 1rem 1.05rem;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(249, 243, 236, 0.92));
            border: 1px solid rgba(176, 146, 121, 0.16);
        }

        .order-row {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(110px, 0.5fr) minmax(130px, 0.6fr) minmax(130px, 0.6fr) auto;
            gap: 1rem;
            align-items: center;
            padding: 1rem 1.05rem;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(249, 243, 236, 0.92));
            border: 1px solid rgba(176, 146, 121, 0.16);
        }

        .row-actions {
            display: flex;
            justify-content: flex-end;
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

            .landing-hero {
                grid-template-columns: 1fr;
            }

            .product-row {
                grid-template-columns: 1fr 1fr;
            }

            .selector-row {
                grid-template-columns: 1fr 1fr;
            }

            .inventory-row {
                grid-template-columns: 1fr 1fr;
            }

            .dashboard-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .dashboard-row {
                grid-template-columns: 1fr;
            }

            .report-row,
            .report-row-wide {
                grid-template-columns: 1fr;
            }

            .inventory-form {
                grid-template-columns: 1fr;
            }

            .detail-grid,
            .item-row,
            .summary-row,
            .customer-row,
            .order-row {
                grid-template-columns: 1fr;
            }

            .product-actions {
                justify-content: flex-start;
            }

            .row-actions {
                justify-content: flex-start;
            }

            .hero,
            .card {
                padding: 1.1rem;
            }
        }

        @media (max-width: 640px) {
            .dashboard-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="shell">
    <header class="topbar">
        <div class="brand">
            <strong>Return-Oriented Pastries</strong>
            <span>Bakery Inventory & Ordering Management</span>
        </div>
        <nav class="nav">
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('products.index') }}">Products</a>
                <a href="{{ route('inventories.index') }}">Inventory</a>
                <a href="{{ route('customers.index') }}">Customers</a>
                <a href="{{ route('orders.index') }}">Orders</a>
                <a href="{{ route('discounts.index') }}">Discounts</a>
                <a href="{{ route('analytics.index') }}">Analytics</a>
                <a href="{{ route('production-reports.index') }}">Reports</a>
                <a href="{{ route('bakery.edit') }}">Bakery</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a class="primary" href="{{ route('register') }}">Register</a>
            @endauth
        </nav>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="flash flash-error">
                <strong>Please fix these fields:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>
