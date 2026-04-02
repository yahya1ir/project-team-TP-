{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'TrainOS')) — Dashboard</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=IBM+Plex+Mono:wght@400;500&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    
    <style>
        /* ========================================
           GLOBAL RESET & VARIABLES
        ======================================== */
        *, *::before, *::after { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }

        :root {
            --bg:          #0d0d0d;
            --bg2:         #131313;
            --bg3:         #1a1a1a;
            --border:      #242424;
            --border2:     #2e2e2e;
            --purple:      #8b5cf6;
            --purple-dim:  #6d28d9;
            --purple-pale: rgba(139,92,246,.10);
            --text:        #f8f8ff;
            --text2:       #9a94aa;
            --text3:       #5a5565;
            --green:       #3ecf6e;
            --green-bg:    rgba(62,207,110,.10);
            --red:         #f05252;
            --red-bg:      rgba(240,82,82,.10);
            --amber:       #f0a432;
            --amber-bg:    rgba(240,164,50,.10);
            --cyan:        #38bdf8;
            --cyan-bg:     rgba(56,189,248,.10);
            --sidebar-w:   240px;
            --sidebar-c:   64px;
            --topbar-h:    60px;
            --r:           8px;
            --r2:          14px;
            --tr:          .2s ease;
            --fab-size:    56px;
            --fab-shadow:  0 12px 28px rgba(0,0,0,0.5), 0 0 0 1px rgba(139,92,246,.2);
        }

        html, body { 
            height:100%; 
            font-family:'Outfit',sans-serif; 
            font-size:14px; 
            color:var(--text); 
            background:var(--bg); 
            overflow-x:hidden; 
        }
        
        ::-webkit-scrollbar { width:4px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:var(--border2); border-radius:99px; }

        /* ========================================
           SIDEBAR STYLES
        ======================================== */
        .sidebar { 
            position:fixed; 
            top:0; 
            left:0; 
            width:var(--sidebar-w); 
            height:100vh; 
            background:var(--bg2); 
            border-right:1px solid var(--border); 
            display:flex; 
            flex-direction:column; 
            z-index:100; 
            transition:width var(--tr); 
            overflow:hidden; 
        }
        
        .sidebar.collapsed { width:var(--sidebar-c); }

        .sb-brand { 
            display:flex; 
            align-items:center; 
            gap:.75rem; 
            padding:0 1rem; 
            height:var(--topbar-h); 
            border-bottom:1px solid var(--border); 
            flex-shrink:0; 
        }
        
        .sb-logo { 
            width:34px; 
            height:34px; 
            flex-shrink:0; 
            background:var(--purple); 
            border-radius:6px; 
            display:flex; 
            align-items:center; 
            justify-content:center; 
            box-shadow: 0 0 14px rgba(139,92,246,.4); 
        }
        
        .sb-logo svg { width:16px; height:16px; color:#fff; }
        
        .sb-name { 
            font-family:'Playfair Display',serif; 
            font-size:1.15rem; 
            font-weight:700; 
            color:var(--text); 
            white-space:nowrap; 
            transition:opacity var(--tr); 
        }
        
        .sidebar.collapsed .sb-name { opacity:0; }

        .sb-nav { 
            flex:1; 
            padding:1rem 0; 
            overflow-y:auto; 
            overflow-x:hidden; 
            scrollbar-width:none; 
        }
        
        .sb-nav::-webkit-scrollbar { display:none; }

        .sb-section { 
            font-family:'IBM Plex Mono',monospace; 
            font-size:.62rem; 
            letter-spacing:.12em; 
            text-transform:uppercase; 
            color:var(--text3); 
            padding:.8rem 1rem .3rem; 
            white-space:nowrap; 
            transition:opacity var(--tr); 
        }
        
        .sidebar.collapsed .sb-section { opacity:0; }

        .sb-link { 
            display:flex; 
            align-items:center; 
            gap:.7rem; 
            padding:.55rem .9rem; 
            margin:1px .5rem; 
            border-radius:var(--r); 
            cursor:pointer; 
            text-decoration:none; 
            color:var(--text2); 
            position:relative; 
            transition:background var(--tr),color var(--tr); 
            white-space:nowrap; 
        }
        
        .sb-link:hover { background:var(--bg3); color:var(--text); }
        
        .sb-link.active { 
            background:var(--purple-pale); 
            color:var(--purple); 
            border:1px solid rgba(139,92,246,.18); 
        }
        
        .sb-link.active::before { 
            content:''; 
            position:absolute; 
            left:-6px; 
            top:50%; 
            transform:translateY(-50%); 
            width:3px; 
            height:16px; 
            background:var(--purple); 
            border-radius:0 3px 3px 0; 
        }

        .sb-icon { 
            width:34px; 
            height:34px; 
            flex-shrink:0; 
            display:flex; 
            align-items:center; 
            justify-content:center; 
        }
        
        .sb-icon svg { width:16px; height:16px; }
        
        .sb-lbl { 
            font-size:.84rem; 
            font-weight:500; 
            transition:opacity var(--tr); 
        }
        
        .sidebar.collapsed .sb-lbl { opacity:0; }
        
        .sb-badge { 
            margin-left:auto; 
            font-family:'IBM Plex Mono',monospace; 
            font-size:.6rem; 
            padding:2px 7px; 
            border-radius:99px; 
            background:var(--purple-pale); 
            color:var(--purple); 
            border:1px solid rgba(139,92,246,.22); 
            transition:opacity var(--tr); 
        }
        
        .sidebar.collapsed .sb-badge { opacity:0; }
        
        .sidebar.collapsed .sb-link:hover::after { 
            content:attr(data-label); 
            position:absolute; 
            left:calc(100% + 10px); 
            top:50%; 
            transform:translateY(-50%); 
            background:var(--bg3); 
            color:var(--text); 
            font-size:.78rem; 
            padding:.3rem .65rem; 
            border-radius:var(--r); 
            white-space:nowrap; 
            border:1px solid var(--border2); 
            z-index:200; 
        }

        .sb-foot { 
            padding:.75rem .5rem 1rem; 
            border-top:1px solid var(--border); 
            flex-shrink:0; 
        }

        /* ========================================
           TOPBAR STYLES
        ======================================== */
        .topbar { 
            position:fixed; 
            top:0; 
            left:var(--sidebar-w); 
            right:0; 
            height:var(--topbar-h); 
            background:rgba(13,13,13,.85); 
            backdrop-filter:blur(20px); 
            border-bottom:1px solid var(--border); 
            display:flex; 
            align-items:center; 
            gap:1rem; 
            padding:0 1.5rem; 
            z-index:90; 
            transition:left var(--tr); 
        }
        
        .sidebar.collapsed ~ .topbar { left:var(--sidebar-c); }

        .tb-toggle { 
            width:34px; 
            height:34px; 
            background:var(--bg3); 
            border:1px solid var(--border2); 
            border-radius:var(--r); 
            cursor:pointer; 
            display:flex; 
            align-items:center; 
            justify-content:center; 
            flex-shrink:0; 
            color:var(--text2); 
            transition:border-color var(--tr),color var(--tr); 
        }
        
        .tb-toggle:hover { border-color:var(--purple); color:var(--purple); }
        .tb-toggle svg { width:15px; height:15px; }

        .tb-search { 
            flex:1; 
            max-width:340px; 
            position:relative; 
        }
        
        .tb-search svg { 
            position:absolute; 
            left:.7rem; 
            top:50%; 
            transform:translateY(-50%); 
            width:14px; 
            height:14px; 
            color:var(--text3); 
        }
        
        .tb-search input { 
            width:100%; 
            height:36px; 
            padding:0 1rem 0 2.2rem; 
            background:var(--bg3); 
            border:1px solid var(--border2); 
            border-radius:var(--r); 
            font-family:'Outfit',sans-serif; 
            font-size:.83rem; 
            color:var(--text); 
            outline:none; 
            transition:border-color var(--tr); 
        }
        
        .tb-search input::placeholder { color:var(--text3); }
        .tb-search input:focus { 
            border-color:var(--purple); 
            box-shadow: 0 0 0 3px rgba(139,92,246,.08); 
        }

        .tb-right { 
            display:flex; 
            align-items:center; 
            gap:.65rem; 
            margin-left:auto; 
        }
        
        .tb-icon { 
            width:34px; 
            height:34px; 
            background:var(--bg3); 
            border:1px solid var(--border2); 
            border-radius:var(--r); 
            display:flex; 
            align-items:center; 
            justify-content:center; 
            cursor:pointer; 
            position:relative; 
            color:var(--text2); 
            transition:border-color var(--tr),color var(--tr); 
        }
        
        .tb-icon:hover { border-color:var(--purple); color:var(--purple); }
        .tb-icon svg { width:15px; height:15px; }
        
        .notif-pip { 
            position:absolute; 
            top:5px; 
            right:5px; 
            width:6px; 
            height:6px; 
            background:var(--red); 
            border-radius:50%; 
            border:1.5px solid var(--bg); 
        }

        .tb-profile-wrap { position:relative; }
        
        .tb-profile { 
            display:flex; 
            align-items:center; 
            gap:.55rem; 
            padding:.3rem .55rem .3rem .3rem; 
            background:var(--bg3); 
            border:1px solid var(--border2); 
            border-radius:var(--r); 
            cursor:pointer; 
            transition:border-color var(--tr); 
        }
        
        .tb-profile:hover { border-color:var(--purple); }
        
        .tb-av { 
            width:28px; 
            height:28px; 
            border-radius:50%; 
            background:linear-gradient(135deg, var(--purple), #c4b5fd); 
            color:#fff; 
            font-family:'IBM Plex Mono',monospace; 
            font-size:.65rem; 
            font-weight:500; 
            display:flex; 
            align-items:center; 
            justify-content:center; 
            flex-shrink:0; 
        }
        
        .tb-pname { font-size:.8rem; font-weight:600; color:var(--text); }
        .tb-prole { font-size:.68rem; color:var(--text3); font-family:'IBM Plex Mono',monospace; }
        .tb-chev { color:var(--text3); width:13px; height:13px; }

        .tb-dropdown { 
            position:absolute; 
            top:calc(100% + 8px); 
            right:0; 
            width:185px; 
            background:var(--bg3); 
            border:1px solid var(--border2); 
            border-radius:var(--r2); 
            padding:.35rem; 
            box-shadow:0 16px 40px rgba(0,0,0,.5); 
            opacity:0; 
            transform:translateY(-6px) scale(.97); 
            pointer-events:none; 
            transition:opacity var(--tr),transform var(--tr); 
            z-index:200; 
        }
        
        .tb-profile-wrap.open .tb-dropdown { 
            opacity:1; 
            transform:none; 
            pointer-events:all; 
        }
        
        .dd-item { 
            display:flex; 
            align-items:center; 
            gap:.55rem; 
            padding:.45rem .65rem; 
            border-radius:var(--r); 
            font-size:.81rem; 
            color:var(--text2); 
            cursor:pointer; 
            text-decoration:none; 
            transition:background var(--tr),color var(--tr); 
        }
        
        .dd-item:hover { background:var(--bg); color:var(--text); }
        .dd-item.red { color:var(--red); }
        .dd-item.red:hover { background:var(--red-bg); }
        .dd-item svg { width:13px; height:13px; }
        .dd-sep { height:1px; background:var(--border); margin:.3rem 0; }

        /* ========================================
           MAIN CONTENT AREA
        ======================================== */
        .main { 
            margin-left:var(--sidebar-w); 
            padding-top:var(--topbar-h); 
            min-height:100vh; 
            transition:margin-left var(--tr); 
        }
        
        .sidebar.collapsed ~ .topbar ~ .main { 
            margin-left:var(--sidebar-c); 
        }
        
        .content { 
            padding:2rem; 
            animation: fadeInUp 0.4s ease both; 
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: none; }
        }

        /* ========================================
           PAGE HEADER COMPONENT
        ======================================== */
        .page-header { 
            display:flex; 
            align-items:flex-end; 
            justify-content:space-between; 
            margin-bottom:2rem; 
            flex-wrap:wrap; 
            gap:1rem; 
        }
        
        .page-header .eyebrow { 
            font-family:'IBM Plex Mono',monospace; 
            font-size:.65rem; 
            letter-spacing:.14em; 
            text-transform:uppercase; 
            color:var(--purple); 
            margin-bottom:.3rem; 
            display:flex; 
            align-items:center; 
            gap:.5rem; 
        }
        
        .page-header .eyebrow::before { 
            content:''; 
            display:block; 
            width:20px; 
            height:1px; 
            background:var(--purple); 
        }
        
        .page-header h1 { 
            font-family:'Playfair Display',serif; 
            font-size:2rem; 
            font-weight:900; 
            color:var(--text); 
            letter-spacing:-.03em; 
            line-height:1; 
        }
        
        .page-header .subtitle { 
            font-size:.82rem; 
            color:var(--text2); 
            margin-top:.4rem; 
        }
        
        .page-header .date-info { 
            font-family:'IBM Plex Mono',monospace; 
            font-size:.72rem; 
            color:var(--text3); 
            text-align:right; 
        }
        
        .page-header .date-info strong { 
            display:block; 
            color:var(--text2); 
            font-size:.8rem; 
            margin-top:.1rem; 
        }

        /* ========================================
           CARD COMPONENT
        ======================================== */
        .card { 
            background:var(--bg2); 
            border:1px solid var(--border); 
            border-radius:var(--r2); 
            overflow:hidden; 
            transition:border-color var(--tr),transform var(--tr); 
            margin-bottom:1.5rem;
        }
        
        .card:hover { transform:translateY(-2px); }
        
        .card-header { 
            display:flex; 
            align-items:center; 
            justify-content:space-between; 
            padding:1rem 1.25rem; 
            border-bottom:1px solid var(--border); 
        }
        
        .card-title { 
            font-family:'Playfair Display',serif; 
            font-size:.92rem; 
            font-weight:700; 
            color:var(--text); 
        }
        
        .card-subtitle { 
            font-family:'IBM Plex Mono',monospace; 
            font-size:.62rem; 
            color:var(--text3); 
            margin-top:.15rem; 
        }
        
        .card-body { padding:1.25rem; }
        .card-footer { 
            padding:1rem 1.25rem; 
            border-top:1px solid var(--border); 
            background:var(--bg3);
        }

        /* ========================================
           STATS GRID
        ======================================== */
        .stats-grid { 
            display:grid; 
            grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); 
            gap:1rem; 
            margin-bottom:1.5rem; 
        }
        
        .stat { 
            background:var(--bg2); 
            border:1px solid var(--border); 
            border-radius:var(--r2); 
            padding:1.25rem; 
            position:relative; 
            overflow:hidden; 
            transition:border-color var(--tr),transform var(--tr); 
        }
        
        .stat:hover { transform:translateY(-2px); }
        
        .stat-top { 
            display:flex; 
            align-items:center; 
            justify-content:space-between; 
            margin-bottom:.85rem; 
        }
        
        .stat-ico { 
            width:36px; 
            height:36px; 
            border-radius:var(--r); 
            display:flex; 
            align-items:center; 
            justify-content:center; 
        }
        
        .stat-num { 
            font-family:'Playfair Display',serif; 
            font-size:2rem; 
            font-weight:900; 
            color:var(--text); 
            letter-spacing:-.04em; 
            line-height:1; 
        }
        
        .stat-lbl { 
            font-size:.78rem; 
            color:var(--text2); 
            margin-top:.25rem; 
            font-weight:500; 
        }
        
        .stat-desc { 
            font-family:'IBM Plex Mono',monospace; 
            font-size:.65rem; 
            color:var(--text3); 
            margin-top:.5rem; 
        }
        
        .chip-up { 
            background:var(--green-bg); 
            color:var(--green); 
            padding:2px 8px; 
            border-radius:99px; 
            font-size:.65rem; 
        }
        
        .chip-down { 
            background:var(--red-bg); 
            color:var(--red); 
            padding:2px 8px; 
            border-radius:99px; 
            font-size:.65rem; 
        }

        /* ========================================
           TABLE STYLES
        ======================================== */
        .data-table { width:100%; border-collapse:collapse; }
        
        .data-table th { 
            text-align:left; 
            padding:1rem 1rem; 
            font-family:'IBM Plex Mono',monospace; 
            font-size:.7rem; 
            font-weight:500; 
            color:var(--text3); 
            border-bottom:1px solid var(--border); 
            text-transform:uppercase; 
            letter-spacing:.05em; 
        }
        
        .data-table td { 
            padding:1rem; 
            color:var(--text2); 
            border-bottom:1px solid var(--border); 
        }
        
        .data-table tr:hover td { background:var(--bg3); }

        /* ========================================
           BUTTONS
        ======================================== */
        .btn { 
            padding:.6rem 1.2rem; 
            border-radius:var(--r); 
            font-size:.8rem; 
            font-weight:500; 
            cursor:pointer; 
            transition:all var(--tr); 
            border:1px solid var(--border2); 
            background:var(--bg3); 
            color:var(--text2); 
            text-decoration:none; 
            display:inline-flex; 
            align-items:center; 
            gap:.5rem; 
        }
        
        .btn:hover { 
            border-color:var(--purple); 
            color:var(--purple); 
            transform:translateY(-1px); 
        }
        
        .btn-primary { 
            background:var(--purple); 
            color:white; 
            border-color:var(--purple); 
        }
        
        .btn-primary:hover { 
            background:var(--purple-dim); 
            color:white; 
        }
        
        .btn-sm { padding:.4rem .8rem; font-size:.75rem; }
        .btn-danger { color:var(--red); border-color:var(--red); }
        .btn-danger:hover { background:var(--red-bg); color:var(--red); }

        /* ========================================
           FORM STYLES
        ======================================== */
        .form-group { margin-bottom:1.25rem; }
        
        .form-label { 
            display:block; 
            margin-bottom:.5rem; 
            font-size:.8rem; 
            font-weight:500; 
            color:var(--text2); 
        }
        
        .form-control { 
            width:100%; 
            padding:.65rem 1rem; 
            background:var(--bg3); 
            border:1px solid var(--border2); 
            border-radius:var(--r); 
            color:var(--text); 
            font-family:'Outfit',sans-serif; 
            font-size:.85rem; 
            transition:border-color var(--tr); 
        }
        
        .form-control:focus { 
            outline:none; 
            border-color:var(--purple); 
            box-shadow:0 0 0 3px rgba(139,92,246,.1); 
        }
        
        .form-control::placeholder { color:var(--text3); }

        /* ========================================
           FLOATING ACTION BUTTON
        ======================================== */
        .fab-container { 
            position: fixed; 
            bottom: 28px; 
            right: 28px; 
            z-index: 110; 
            display: flex; 
            flex-direction: column; 
            align-items: flex-end; 
            gap: 12px; 
        }
        
        .fab-actions { 
            display: flex; 
            flex-direction: column; 
            gap: 12px; 
            margin-bottom: 8px; 
            opacity: 0; 
            transform: translateY(20px) scale(0.9); 
            pointer-events: none; 
            transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1); 
        }
        
        .fab-container.open .fab-actions { 
            opacity: 1; 
            transform: translateY(0) scale(1); 
            pointer-events: auto; 
        }
        
        .fab-action { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            background: var(--bg2); 
            backdrop-filter: blur(8px); 
            border: 1px solid var(--border2); 
            border-radius: 40px; 
            padding: 8px 18px 8px 14px; 
            cursor: pointer; 
            transition: all 0.2s ease; 
            box-shadow: 0 6px 14px rgba(0,0,0,0.3); 
            text-decoration: none; 
            font-family: 'Outfit', sans-serif; 
            font-size: 0.85rem; 
            font-weight: 500; 
            color: var(--text2); 
        }
        
        .fab-action:hover { 
            border-color: var(--purple); 
            background: var(--bg3); 
            transform: translateX(-4px); 
            color: var(--text); 
        }
        
        .fab-action svg { 
            width: 18px; 
            height: 18px; 
            stroke-width: 1.8; 
            color: var(--purple); 
        }
        
        .fab-main { 
            width: var(--fab-size); 
            height: var(--fab-size); 
            background: linear-gradient(135deg, var(--purple), var(--purple-dim)); 
            border-radius: 28px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            cursor: pointer; 
            box-shadow: var(--fab-shadow); 
            transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1); 
            border: none; 
            outline: none; 
        }
        
        .fab-main:hover { 
            transform: scale(1.05); 
            box-shadow: 0 16px 32px rgba(139,92,246,0.35), 0 0 0 1px rgba(139,92,246,0.6); 
        }
        
        .fab-main svg { 
            width: 26px; 
            height: 26px; 
            stroke: white; 
            stroke-width: 2.2; 
            transition: transform 0.2s ease; 
        }
        
        .fab-container.open .fab-main svg { transform: rotate(45deg); }

        /* ========================================
           ALERTS
        ======================================== */
        .alert { 
            padding: 1rem; 
            border-radius: var(--r); 
            margin-bottom: 1.5rem; 
            border-left: 3px solid;
        }
        
        .alert-success { 
            background: var(--green-bg); 
            border-color: var(--green); 
            color: var(--green); 
        }
        
        .alert-danger { 
            background: var(--red-bg); 
            border-color: var(--red); 
            color: var(--red); 
        }
        
        .alert-warning { 
            background: var(--amber-bg); 
            border-color: var(--amber); 
            color: var(--amber); 
        }

        /* ========================================
           MOBILE OVERLAY & RESPONSIVE
        ======================================== */
        .sb-overlay { 
            display:none; 
            position:fixed; 
            inset:0; 
            background:rgba(0,0,0,.6); 
            z-index:99; 
        }
        
        @media(max-width:900px){
            .sidebar{transform:translateX(-100%);width:var(--sidebar-w)!important;transition:transform var(--tr);}
            .sidebar.mobile-open{transform:translateX(0);}
            .topbar{left:0!important;}
            .main{margin-left:0!important;}
            .sb-overlay{display:block;opacity:0;pointer-events:none;transition:opacity var(--tr);}
            .sb-overlay.show{opacity:1;pointer-events:all;}
            .tb-pname,.tb-prole,.tb-chev{display:none;}
            .fab-container { bottom: 20px; right: 20px; }
            .content { padding: 1rem; }
        }
        
        @media(max-width:700px){
            .page-header{flex-direction:column;align-items:flex-start;}
            .page-header .date-info{text-align:left;}
            .stats-grid { grid-template-columns: 1fr; }
        }
        
        /* ========================================
           UTILITY CLASSES
        ======================================== */
        .text-purple { color: var(--purple); }
        .text-muted { color: var(--text2); }
        .mt-2 { margin-top: 0.5rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mt-4 { margin-top: 1rem; }
        .mb-4 { margin-bottom: 1rem; }
        .gap-2 { gap: 0.5rem; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .w-full { width: 100%; }
    </style>
    
    @stack('styles')
</head>
<body>

<div class="sb-overlay" id="sbOverlay" onclick="closeMobile()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sb-brand">
        
       
    </div>

    <nav class="sb-nav">
        <div class="sb-section">Main</div>
          @can('view dashboard')
        <a class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
              href="{{ route('dashboard') }}" 
           data-label="Dashboard">
            <span class="sb-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                </svg>
            </span>
            <span class="sb-lbl">Dashboard</span>
        </a>
          @endcan

          @can('manage users')
        <a class="sb-link {{ request()->routeIs('users.*') ? 'active' : '' }}" 
              href="{{ route('users.index') }}" 
           data-label="Users">
            <span class="sb-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </span>
            <span class="sb-lbl">Users</span>
            @isset($usersCount)
                <span class="sb-badge">{{ $usersCount }}</span>
            @endisset
        </a>
        @endcan

        @role('Super Admin')
        <a class="sb-link {{ request()->routeIs('super-admin.*') ? 'active' : '' }}"
              href="{{ route('super-admin.index') }}"
           data-label="Super Admin">
            <span class="sb-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M12 3l2.8 5.67 6.26.91-4.53 4.42 1.07 6.25L12 17.27l-5.6 2.98 1.07-6.25L2.94 9.58l6.26-.91L12 3z"/>
                </svg>
            </span>
            <span class="sb-lbl">Super Admin</span>
        </a>
        @endrole

                    @canany(['manage formations', 'view formations'])
        <a class="sb-link {{ request()->routeIs('formations.*') ? 'active' : '' }}" 
              href="{{ route('formation') }}" 
           data-label="Formations">
            <span class="sb-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
            </span>
            <span class="sb-lbl">{{ __('messages.nav.formations') }}</span>
        </a>
                    @endcanany

       

     

        

        <div class="sb-section">{{ __('messages.nav.system') }}</div>
        <a class="sb-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" 
           href="settings" 
           data-label="{{ __('messages.nav.settings') }}">
            <span class="sb-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41M20 12h2M2 12h2M12 20v2M12 2v2"/>
                </svg>
            </span>
            <span class="sb-lbl">{{ __('messages.nav.settings') }}</span>
        </a>
    </nav>

    <div class="sb-foot">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <a class="sb-link" href="#" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               data-label="{{ __('messages.nav.logout') }}" 
               style="color:var(--red);">
                <span class="sb-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </span>
                <span class="sb-lbl">{{ __('messages.nav.logout') }}</span>
            </a>
        </form>
    </div>
</aside>

<!-- TOPBAR -->
<header class="topbar" id="topbar">
    <button class="tb-toggle" onclick="toggleSidebar()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>
    
    <div class="tb-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" placeholder="{{ __('messages.nav.searchAnything') }}" id="globalSearch"/>
    </div>
    
    <div class="tb-right">
        <!-- Language Switcher -->
        <div style="display:flex;gap:0.25rem;margin-right:1rem;">
            <a href="{{ route('language', 'en') }}" 
               class="tb-lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}"
               title="English"
               style="padding:0.5rem 0.75rem;border-radius:4px;font-size:0.75rem;font-weight:600;text-decoration:none;color:var(--text2);border:1px solid var(--border);transition:all var(--tr); {{ app()->getLocale() === 'en' ? 'background:var(--purple-pale);color:var(--purple);border-color:var(--purple);' : '' }}">
                EN
            </a>
            <a href="{{ route('language', 'fr') }}" 
               class="tb-lang-btn {{ app()->getLocale() === 'fr' ? 'active' : '' }}"
               title="Français"
               style="padding:0.5rem 0.75rem;border-radius:4px;font-size:0.75rem;font-weight:600;text-decoration:none;color:var(--text2);border:1px solid var(--border);transition:all var(--tr); {{ app()->getLocale() === 'fr' ? 'background:var(--purple-pale);color:var(--purple);border-color:var(--purple);' : '' }}">
                FR
            </a>
        </div>
        
        <div class="tb-icon" id="notificationBell">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                <span class="notif-pip"></span>
            @endif
        </div>
        
        <div class="tb-profile-wrap" id="profileWrap">
            <div class="tb-profile" onclick="toggleDd()">
                <div class="tb-av">{{ strtoupper(substr(Auth::user()->name ?? 'JD', 0, 2)) }}</div>
                <div>
                    <div class="tb-pname">{{ Auth::user()->name  }}</div>
                    <div class="tb-prole">{{ Auth::user()?->role  }}</div>
                </div>
                <svg class="tb-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </div>
            <div class="tb-dropdown" id="tbDd">
                <a class="dd-item" href="#">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    {{ __('messages.nav.myProfile') }}
                </a>
                <a class="dd-item" href="settings">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    {{ __('messages.nav.settings') }}
                </a>
                <div class="dd-sep"></div>
                <a class="dd-item red" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    {{ __('messages.nav.logout') }}
                </a>
            </div>
        </div>
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="main" id="main">
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif
        
        @yield('content')
    </div>
</main>

<!-- FLOATING ACTION BUTTON -->
<div class="fab-container" id="fabContainer">
    <div class="fab-actions" id="fabActions">
        @yield('fab-actions')
    </div>
    <button class="fab-main" id="fabMain">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
    </button>
</div>

<script>
    // Sidebar toggle functionality
    const sidebar = document.getElementById('sidebar');
    const topbar = document.getElementById('topbar');
    const mainEl = document.getElementById('main');
    const overlay = document.getElementById('sbOverlay');
    const isMob = () => window.innerWidth <= 900;

    function toggleSidebar() {
        if (isMob()) {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');
            const c = sidebar.classList.contains('collapsed');
            mainEl.style.marginLeft = c ? 'var(--sidebar-c)' : 'var(--sidebar-w)';
            topbar.style.left = c ? 'var(--sidebar-c)' : 'var(--sidebar-w)';
        }
    }

    function closeMobile() {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('show');
    }

    window.addEventListener('resize', () => {
        if (!isMob()) closeMobile();
    });

    // Profile dropdown
    function toggleDd() {
        document.getElementById('profileWrap').classList.toggle('open');
    }

    document.addEventListener('click', e => {
        const pw = document.getElementById('profileWrap');
        if (pw && !pw.contains(e.target)) pw.classList.remove('open');
    });

    // FAB functionality
    const fabContainer = document.getElementById('fabContainer');
    const fabMain = document.getElementById('fabMain');

    if (fabMain) {
        fabMain.addEventListener('click', (e) => {
            e.stopPropagation();
            fabContainer.classList.toggle('open');
        });

        document.addEventListener('click', (e) => {
            if (fabContainer && !fabContainer.contains(e.target)) {
                fabContainer.classList.remove('open');
            }
        });
    }

    // Search functionality
    const searchInput = document.getElementById('globalSearch');
    if (searchInput) {
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                window.location.href = '#?q=' + encodeURIComponent(searchInput.value);
            }
        });
    }

    // Notification bell
    const notificationBell = document.getElementById('notificationBell');
    if (notificationBell) {
        notificationBell.addEventListener('click', () => {
            // You can open a notification panel here
            alert('Notifications feature coming soon');
        });
    }
</script>

@stack('scripts')
</body>
</html>