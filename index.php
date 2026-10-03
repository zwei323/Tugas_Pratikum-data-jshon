<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Praktikum API — Gabungan</title>
<style>
  :root{
    --bg: #fdf6ec;
    --panel: #ffffff;
    --line: #eee2cf;
    --text: #3a3226;
    --muted: #9a8f7a;
    --coral: #ff6f59;
    --mint: #2ec4b6;
    --lavender: #8674c9;
    --sun: #ffb703;
    --idle: #8674c9;
    --loading: #ffb703;
    --success: #2ec4b6;
    --error: #ff6f59;
    --accent: #8674c9;
  }

  *{box-sizing:border-box;}

  body{
    margin:0;
    min-height:100vh;
    background:
      radial-gradient(700px 400px at 90% -5%, rgba(255,183,3,0.15), transparent 60%),
      radial-gradient(700px 400px at 0% 100%, rgba(46,196,182,0.14), transparent 60%),
      var(--bg);
    color: var(--text);
    font-family: 'Segoe UI', 'Inter', system-ui, sans-serif;
  }

  /* ===== NAVBAR ===== */
  .navbar{
    position: sticky;
    top: 0;
    z-index: 100;
    background: rgba(253,246,236,0.9);
    backdrop-filter: blur(8px);
    border-bottom: 1px solid var(--line);
    padding: 14px 24px;
  }
  .nav-inner{
    max-width: 1080px;
    margin: 0 auto;
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap: wrap;
    gap: 14px;
  }
  .nav-brand{
    display:flex;
    align-items:center;
    gap:10px;
    font-family:'Courier New', monospace;
    font-size: 12px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--mint);
    font-weight: 700;
  }
  .nav-brand::before{
    content:"";
    width:9px; height:9px;
    border-radius: 3px;
    background: var(--sun);
    transform: rotate(45deg);
  }
  .nav-tabs{
    display:flex;
    gap: 8px;
    background: #fff3de;
    border: 1px solid var(--line);
    padding: 5px;
    border-radius: 999px;
  }
  .nav-tab{
    appearance:none;
    border:none;
    cursor:pointer;
    background: transparent;
    color: var(--muted);
    font-size: 13px;
    font-weight: 700;
    padding: 9px 18px;
    border-radius: 999px;
    transition: all .18s ease;
    white-space: nowrap;
  }
  .nav-tab:hover{ color: var(--text); }
  .nav-tab.active{
    color: #fff;
    background: linear-gradient(135deg, var(--coral), #ff9a3d);
    box-shadow: 0 8px 18px -8px rgba(255,111,89,0.6);
  }

  /* ===== PAGE WRAP ===== */
  .page{
    display:none;
    padding: 48px 24px 80px;
    animation: fadeIn .3s ease;
  }
  .page.active{ display:block; }
  @keyframes fadeIn{ from{ opacity:0; transform: translateY(6px);} to{ opacity:1; transform:none; } }

  .wrap{ max-width: 1080px; margin: 0 auto; }
  .wrap-narrow{ width:100%; max-width: 560px; margin: 0 auto; }
  .wrap-wide{ width:100%; max-width: 900px; margin: 0 auto; }

  .eyebrow{
    display:flex;
    align-items:center;
    gap:10px;
    font-family:'Courier New', monospace;
    font-size: 12px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--mint);
    margin-bottom: 14px;
  }
  .eyebrow::before{
    content:"";
    width:9px; height:9px;
    border-radius: 3px;
    background: var(--sun);
    transform: rotate(45deg);
  }

  h1{
    font-size: clamp(28px, 4vw, 42px);
    margin: 0 0 10px;
    letter-spacing: -0.5px;
  }
  h1 span{ color: var(--coral); }

  .sub{
    color: var(--muted);
    font-size: 15px;
    max-width: 560px;
    margin-bottom: 32px;
  }
  .sub code{
    background: #fff3de;
    border:1px solid var(--line);
    padding:1px 6px;
    border-radius:6px;
    font-size:13px;
    color: var(--coral);
  }

  /* ===== PRAKTIKUM 3 ===== */
  .toolbar{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
    margin-bottom: 22px;
  }

  #p3-loadBtn{
    appearance:none;
    border:none;
    cursor:pointer;
    padding: 13px 26px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    letter-spacing:0.2px;
    color: #fff;
    background: linear-gradient(135deg, var(--coral), #ff9a3d);
    box-shadow: 0 10px 24px -10px rgba(255,111,89,0.6);
    transition: transform .15s ease, box-shadow .15s ease;
  }
  #p3-loadBtn:hover{ transform: translateY(-2px); }
  #p3-loadBtn:active{ transform: translateY(0); }
  #p3-loadBtn:disabled{ opacity:0.6; cursor:default; transform:none; }

  #p3-search{
    flex:1;
    min-width: 180px;
    background: var(--panel);
    border: 2px solid var(--line);
    color: var(--text);
    padding: 12px 16px;
    border-radius: 999px;
    font-size: 14px;
    outline:none;
    transition: border-color .15s ease;
    display:none;
  }
  #p3-search:focus{ border-color: var(--mint); }
  #p3-search::placeholder{ color: var(--muted); }

  .status{
    display:flex;
    align-items:center;
    gap:10px;
    color: var(--muted);
    font-size: 13px;
    font-family:'Courier New', monospace;
    min-height: 20px;
    margin-bottom: 14px;
  }
  .spinner{
    width:14px; height:14px;
    border-radius:50%;
    border: 2px solid var(--line);
    border-top-color: var(--coral);
    animation: spin .7s linear infinite;
    display:none;
  }
  @keyframes spin{ to{ transform: rotate(360deg);} }

  .table-shell{
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 50px -35px rgba(58,50,38,0.4);
    display:none;
  }

  table{ width:100%; border-collapse: collapse; font-size: 14px; }

  thead th{
    text-align:left;
    padding: 14px 18px;
    background: #fff8ec;
    color: var(--muted);
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    border-bottom: 2px solid var(--line);
  }

  tbody tr{
    border-bottom: 1px solid var(--line);
    transition: background .15s ease;
  }
  tbody tr:last-child{ border-bottom:none; }
  tbody tr:hover{ background: #fff8ec; }

  td{ padding: 14px 18px; vertical-align: middle; }

  .idx{
    color: var(--muted);
    font-family:'Courier New', monospace;
    font-size: 12px;
    width: 40px;
  }

  .user-cell{ display:flex; align-items:center; gap:12px; }
  .avatar{
    width:36px; height:36px;
    border-radius: 12px;
    display:flex; align-items:center; justify-content:center;
    font-size:13px;
    font-weight:800;
    color:#fff;
    flex-shrink:0;
  }
  .name{ font-weight:700; color: var(--text); }
  .username{
    display:block;
    color: var(--muted);
    font-size: 12px;
    font-family:'Courier New', monospace;
  }

  .email a{ color: var(--lavender); text-decoration:none; font-size: 13px; font-weight:600; }
  .email a:hover{ text-decoration:underline; }

  .city-pill{
    display:inline-block;
    padding: 4px 12px;
    border-radius: 999px;
    background: rgba(46,196,182,0.12);
    border: 1px solid rgba(46,196,182,0.35);
    color: #1b8f85;
    font-size: 12px;
    font-weight:600;
  }

  .company{ color: var(--muted); font-size: 13px; font-style: italic; }

  .empty-row td{ text-align:center; color: var(--muted); padding: 32px; font-size: 13px; }

  footer{
    text-align:center;
    color: var(--muted);
    font-size: 12px;
    margin-top: 28px;
    font-family:'Courier New', monospace;
  }

  @media (max-width: 640px){
    .company, #p3-tabelUser thead th:nth-child(5){ display:none; }
  }

  /* ===== PRAKTIKUM 4 ===== */
  .p4-body-flex{
    display:flex;
    justify-content:center;
  }

  #p4-loadBtn{
    appearance:none;
    border:none;
    cursor:pointer;
    padding: 13px 28px;
    border-radius: 999px;
    font-size: 14px;
    font-weight:700;
    color:#fff;
    background: linear-gradient(135deg, var(--idle), #a68be0);
    box-shadow: 0 10px 24px -10px rgba(134,116,201,0.55);
    transition: transform .15s ease, background .2s ease;
    margin-bottom: 22px;
  }
  #p4-loadBtn:hover{ transform: translateY(-2px); }
  #p4-loadBtn:disabled{ opacity:0.6; cursor:default; transform:none; }

  .status-card{
    display:flex;
    align-items:center;
    gap:14px;
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 18px;
    padding: 16px 18px;
    margin-bottom: 22px;
    box-shadow: 0 14px 34px -28px rgba(58,50,38,0.5);
    transition: border-color .25s ease;
  }

  .status-icon{
    width: 38px; height:38px;
    border-radius: 14px;
    flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    background: var(--line);
    font-size: 16px;
    transition: background .25s ease;
    position:relative;
  }

  .status-icon.state-idle{ background: rgba(134,116,201,0.12); color: var(--idle); }
  .status-icon.state-loading{ background: rgba(255,183,3,0.15); color: var(--loading); }
  .status-icon.state-success{ background: rgba(46,196,182,0.14); color: #1b8f85; }
  .status-icon.state-error{ background: rgba(255,111,89,0.14); color: var(--error); }

  .spin-ring{
    position:absolute;
    inset:-3px;
    border-radius:14px;
    border: 2px solid transparent;
    border-top-color: var(--loading);
    animation: spin .8s linear infinite;
    display:none;
  }
  .status-icon.state-loading .spin-ring{ display:block; }

  .status-text .label{
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--muted);
    font-family:'Courier New', monospace;
    margin-bottom: 3px;
  }
  .status-text .msg{ font-size: 14px; color: var(--text); }
  .status-card.state-error .msg{ color: var(--error); }
  .status-card.state-success .msg{ color: #1b8f85; }

  .status-card.state-idle{ border-color: var(--line); }
  .status-card.state-loading{ border-color: rgba(255,183,3,0.4); }
  .status-card.state-success{ border-color: rgba(46,196,182,0.4); }
  .status-card.state-error{ border-color: rgba(255,111,89,0.45); }

  #p4-daftarUser{
    list-style:none;
    margin:0; padding:0;
    display:flex;
    flex-direction:column;
    gap:8px;
  }

  #p4-daftarUser li{
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 14px;
    opacity: 0;
    transform: translateY(6px);
    animation: rise .35s ease forwards;
    box-shadow: 0 8px 20px -18px rgba(58,50,38,0.6);
  }
  #p4-daftarUser li .u-name{ font-weight:700; }
  #p4-daftarUser li .u-email{ color: var(--muted); font-size:13px; display:block; margin-top:2px; }

  @keyframes rise{
    to{ opacity:1; transform: translateY(0); }
  }

  /* ===== PRAKTIKUM 5 ===== */
  .p5-body-flex{
    display:flex;
    justify-content:center;
  }

  .layout{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
  }
  @media (max-width: 720px){
    .layout{ grid-template-columns: 1fr; }
  }

  .card{
    background: var(--panel);
    border: 1px solid var(--line);
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 16px 40px -32px rgba(58,50,38,0.5);
  }

  .card h3{
    margin: 0 0 18px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--muted);
    font-family:'Courier New', monospace;
    display:flex;
    align-items:center;
    gap:8px;
  }
  .card h3::before{
    content:"";
    width:7px; height:7px;
    border-radius: 2px;
    background: var(--accent);
    transform: rotate(45deg);
  }

  label{
    display:block;
    font-size: 12px;
    color: var(--muted);
    margin-bottom: 6px;
    margin-top: 16px;
  }
  label:first-of-type{ margin-top:0; }

  input{
    width:100%;
    background: #fffaf1;
    border: 2px solid var(--line);
    color: var(--text);
    padding: 12px 14px;
    border-radius: 12px;
    font-size: 14px;
    outline:none;
    transition: border-color .15s ease, box-shadow .15s ease;
  }
  input:focus{
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(134,116,201,0.15);
  }

  button[type="submit"]{
    appearance:none;
    border:none;
    cursor:pointer;
    width:100%;
    margin-top: 22px;
    padding: 13px 20px;
    border-radius: 999px;
    font-size: 14px;
    font-weight:700;
    color:#fff;
    background: linear-gradient(135deg, var(--accent), #a68be0);
    box-shadow: 0 10px 24px -10px rgba(134,116,201,0.55);
    transition: transform .15s ease, opacity .15s ease;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
  }
  button[type="submit"]:hover{ transform: translateY(-2px); }
  button[type="submit"]:disabled{ opacity:0.6; cursor:default; transform:none; }

  button[type="submit"] .spinner{
    width:14px; height:14px;
    border-radius:50%;
    border: 2px solid rgba(255,255,255,0.35);
    border-top-color: #fff;
    animation: spin .7s linear infinite;
    display:none;
  }
  button[type="submit"].loading .spinner{ display:inline-block; }
  button[type="submit"].loading .btn-label::after{ content: "Mengirim..."; }
  button[type="submit"].loading .btn-label{ font-size:0; }
  button[type="submit"].loading .btn-label::after{ font-size:14px; }

  .console{
    background: #fffaf1;
    border: 2px solid var(--line);
    border-radius: 12px;
    padding: 16px;
    font-family: 'Courier New', monospace;
    font-size: 12.5px;
    line-height: 1.6;
    white-space: pre-wrap;
    word-break: break-word;
    min-height: 180px;
    color: var(--muted);
    position: relative;
  }
  .console.state-success{ color: #1b8f85; border-color: rgba(46,196,182,0.4); }
  .console.state-error{ color: var(--error); border-color: rgba(255,111,89,0.45); }

  .console-dots{
    position:absolute;
    top:10px; left:12px;
    display:flex;
    gap:5px;
  }
  .console-dots span{
    width:8px; height:8px;
    border-radius:50%;
    background: var(--line);
  }
  .console-body{ margin-top: 22px; }

  .badge{
    display:inline-block;
    font-size: 10px;
    padding: 2px 10px;
    border-radius: 999px;
    background: rgba(134,116,201,0.14);
    color: var(--accent);
    margin-left: 8px;
    vertical-align: middle;
    font-weight:700;
  }

  /* ===== TUGAS MANDIRI (TODOS) ===== */
  .p6-body-flex{
    display:flex;
    justify-content:center;
  }

  #p6-loadBtn{
    appearance:none;
    border:none;
    cursor:pointer;
    padding: 13px 26px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg, var(--accent), #a68be0);
    box-shadow: 0 10px 24px -10px rgba(134,116,201,0.55);
    transition: transform .15s ease;
    display:flex;
    align-items:center;
    gap:8px;
  }
  #p6-loadBtn:hover{ transform: translateY(-2px); }
  #p6-loadBtn:disabled{ opacity:0.6; cursor:default; transform:none; }

  #p6-loadBtn .spinner{
    width:14px; height:14px;
    border-radius:50%;
    border: 2px solid rgba(255,255,255,0.35);
    border-top-color: #fff;
    animation: spin .7s linear infinite;
    display:none;
  }
  #p6-loadBtn.loading .spinner{ display:inline-block; }

  .p6-summary{
    display:flex;
    gap:16px;
    font-size: 13px;
    color: var(--muted);
    font-family: 'Courier New', monospace;
    margin-bottom: 4px;
  }
  .p6-summary .done{ color: #1b8f85; }
  .p6-summary .pending{ color: var(--error); }

  .p6-status-line{
    color: var(--muted);
    font-size: 13px;
    margin-bottom: 18px;
    min-height: 18px;
  }

  .p6-title-cell{ color: var(--text); }
  .p6-title-cell.done-title{
    color: var(--muted);
    text-decoration: line-through;
    text-decoration-color: var(--line);
  }

  .p6-tag{
    display:inline-flex;
    align-items:center;
    gap:6px;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 999px;
    white-space: nowrap;
  }
  .p6-tag::before{
    content:"";
    width:6px; height:6px;
    border-radius:50%;
  }
  .p6-tag.done{
    color: #1b8f85;
    background: rgba(46,196,182,0.12);
    border: 1px solid rgba(46,196,182,0.35);
  }
  .p6-tag.done::before{ background: var(--success); }

  .p6-tag.pending{
    color: var(--error);
    background: rgba(255,111,89,0.12);
    border: 1px solid rgba(255,111,89,0.35);
  }
  .p6-tag.pending::before{ background: var(--error); }
</style>
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <div class="nav-inner">
      <div class="nav-brand">Praktikum API</div>
      <div class="nav-tabs">
        <button class="nav-tab active" data-page="p3" onclick="gotoPage('p3')">3 · Tabel API</button>
        <button class="nav-tab" data-page="p4" onclick="gotoPage('p4')">4 · Loading &amp; Error</button>
        <button class="nav-tab" data-page="p5" onclick="gotoPage('p5')">5 · POST Data</button>
        <button class="nav-tab" data-page="p6" onclick="gotoPage('p6')">Tugas Mandiri · Todos</button>
        <button class="nav-tab" data-page="p7" onclick="gotoPage('p7')">Tugas 1 · CRUD User</button>
      </div>
    </div>
  </nav>

  <!-- ===== PRAKTIKUM 3 ===== -->
  <section class="page active" id="page-p3">
    <div class="wrap">
      <div class="eyebrow">API · Database MySQL</div>
      <h1>Direktori <span>Pengguna</span></h1>
      <p class="sub">Menarik data langsung dari database <code>belajar_api</code> (tabel <code>users</code>) dan menampilkannya sebagai tabel interaktif.</p>

      <div class="toolbar">
        <button id="p3-loadBtn" onclick="p3_loadData()">Muat Data Tabel</button>
        <input id="p3-search" type="text" placeholder="Cari nama, username, atau email..." oninput="p3_filterRows()">
      </div>

      <div class="status" id="p3-status">
        <span class="spinner" id="p3-spinner"></span>
        <span id="p3-statusText"></span>
      </div>

      <div class="table-shell" id="p3-tabelUser">
        <table>
          <thead>
            <tr>
              <th class="idx">No</th>
              <th>Pengguna</th>
              <th>Email</th>
              <th>Telepon</th>
              <th>Website</th>
            </tr>
          </thead>
          <tbody id="p3-isiTabel"></tbody>
        </table>
      </div>

      <footer>api/ambil_user.php &middot; database belajar_api</footer>
    </div>
  </section>

  <!-- ===== PRAKTIKUM 4 ===== -->
  <section class="page" id="page-p4">
    <div class="p4-body-flex">
    <div class="wrap-narrow">
      <div class="eyebrow">Fetch API · Status Handling</div>
      <h1>Loading &amp; Error Handling</h1>
      <p class="sub">Mengambil data pengguna sambil menampilkan status yang jelas: idle, loading, berhasil, atau gagal.</p>

      <button id="p4-loadBtn" onclick="p4_loadData()">Ambil Data</button>

      <div class="status-card state-idle" id="p4-statusCard">
        <div class="status-icon state-idle" id="p4-statusIcon">
          <span class="spin-ring"></span>
          <span id="p4-iconGlyph">•</span>
        </div>
        <div class="status-text">
          <div class="label" id="p4-statusLabel">Menunggu</div>
          <div class="msg" id="p4-status">Klik tombol untuk mengambil data dari server.</div>
        </div>
      </div>

      <ul id="p4-daftarUser"></ul>

      <footer>api/ambil_user.php &middot; database belajar_api</footer>
    </div>
    </div>
  </section>

  <!-- ===== PRAKTIKUM 5 ===== -->
  <section class="page" id="page-p5">
    <div class="p5-body-flex">
    <div class="wrap-wide">
      <div class="eyebrow">Fetch API · POST · MySQL</div>
      <h1>Tambah Data Pengguna</h1>
      <p class="sub">Mengirim data form ke <code>api/tambah_user.php</code> dan benar-benar menyimpannya ke database <code>belajar_api</code>.</p>

      <div class="layout">
        <div class="card">
          <h3>Form Input</h3>
          <form id="p5-formUser">
            <label for="p5-nama">Nama</label>
            <input type="text" id="p5-nama" placeholder="Masukkan nama lengkap" required>

            <label for="p5-username">Username</label>
            <input type="text" id="p5-username" placeholder="mis. johndoe" required>

            <label for="p5-email">Email</label>
            <input type="email" id="p5-email" placeholder="nama@email.com" required>

            <label for="p5-phone">Telepon <span style="text-transform:none;letter-spacing:0;">(opsional)</span></label>
            <input type="text" id="p5-phone" placeholder="08xxxxxxxxxx">

            <label for="p5-website">Website <span style="text-transform:none;letter-spacing:0;">(opsional)</span></label>
            <input type="text" id="p5-website" placeholder="contoh.com">

            <button type="submit" id="p5-submitBtn">
              <span class="spinner"></span>
              <span class="btn-label">Kirim Data</span>
            </button>
          </form>
        </div>

        <div class="card">
          <h3>Respons Server <span class="badge" id="p5-statusBadge">menunggu</span></h3>
          <div class="console" id="p5-hasilRespon">
            <div class="console-dots"><span></span><span></span><span></span></div>
            <div class="console-body">- Belum ada data dikirim -</div>
          </div>
        </div>
      </div>

      <footer>api/tambah_user.php &middot; database belajar_api</footer>
    </div>
    </div>
  </section>

  <!-- ===== TUGAS MANDIRI (TODOS) ===== -->
  <section class="page" id="page-p6">
    <div class="p6-body-flex">
    <div class="wrap-narrow" style="max-width:720px;">
      <div class="eyebrow">API · JSONPlaceholder / Todos</div>
      <h1>Daftar Tugas</h1>
      <p class="sub">Mengambil data dari <code>/todos</code> dan menandai setiap tugas sebagai selesai atau belum selesai.</p>

      <div class="toolbar">
        <button id="p6-loadBtn" onclick="p6_loadData()">
          <span class="spinner"></span>
          <span id="p6-btnLabel">Tampilkan Daftar Tugas</span>
        </button>
      </div>

      <div class="p6-status-line" id="p6-statusLine"></div>
      <div class="p6-summary" id="p6-summary"></div>

      <div class="table-shell" id="p6-tabelTugas">
        <table>
          <thead>
            <tr>
              <th class="idx">No</th>
              <th>Judul Tugas</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="p6-isiTabel"></tbody>
        </table>
      </div>

      <footer>jsonplaceholder.typicode.com/todos</footer>
    </div>
    </div>
  </section>

  <!-- ===== TUGAS 1 · CRUD USER (aplikasi terpisah, dimuat via iframe) ===== -->
  <section class="page" id="page-p7">
    <div class="wrap" style="padding-top:0;">
      <div class="eyebrow">CRUD · Users + Alamat</div>
      <h1>Tugas 1 <span>Data User</span></h1>
      <p class="sub">Aplikasi terpisah dengan backend <code>api.php</code> sendiri (tabel <code>tugas1_users</code>), dimuat di sini lewat iframe.</p>
      <div style="background:var(--panel);border:1px solid var(--line);border-radius:20px;overflow:hidden;box-shadow:0 20px 50px -35px rgba(58,50,38,0.4);">
        <iframe src="Data.html" title="Tugas 1 CRUD User" style="width:100%;height:80vh;border:none;display:block;"></iframe>
      </div>
    </div>
  </section>

<script>
  /* ===== NAVIGASI ===== */
  function gotoPage(id){
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('page-' + id).classList.add('active');
    document.querySelector('.nav-tab[data-page="' + id + '"]').classList.add('active');
  }

  /* ===== PRAKTIKUM 3 ===== */
  const p3_palette = ['#ff6f59', '#2ec4b6', '#ffb703', '#8674c9', '#ff9a3d', '#3aa6ff'];
  let p3_allUsers = [];

  function p3_initials(name){
    return name.split(' ').map(w => w[0]).slice(0,2).join('').toUpperCase();
  }

  function p3_colorFor(index){
    return p3_palette[index % p3_palette.length];
  }

  function p3_renderRows(users){
    const body = document.getElementById('p3-isiTabel');
    if(users.length === 0){
      body.innerHTML = `<tr class="empty-row"><td colspan="5">Tidak ada hasil yang cocok.</td></tr>`;
      return;
    }
    body.innerHTML = users.map(item => `
      <tr>
        <td class="idx">${String(item._idx).padStart(2,'0')}</td>
        <td>
          <div class="user-cell">
            <div class="avatar" style="background:${p3_colorFor(item._idx)}">${p3_initials(item.name)}</div>
            <div>
              <span class="name">${item.name}</span>
              <span class="username">@${item.username}</span>
            </div>
          </div>
        </td>
        <td class="email"><a href="mailto:${item.email}">${item.email}</a></td>
        <td class="company">${item.phone || '-'}</td>
        <td class="company">${item.website || '-'}</td>
      </tr>
    `).join('');
  }

  function p3_filterRows(){
    const q = document.getElementById('p3-search').value.trim().toLowerCase();
    const filtered = p3_allUsers.filter(u =>
      u.name.toLowerCase().includes(q) ||
      u.username.toLowerCase().includes(q) ||
      u.email.toLowerCase().includes(q)
    );
    p3_renderRows(filtered);
  }

  function p3_loadData(){
    const btn = document.getElementById('p3-loadBtn');
    const spinner = document.getElementById('p3-spinner');
    const statusText = document.getElementById('p3-statusText');

    btn.disabled = true;
    spinner.style.display = 'inline-block';
    statusText.textContent = 'Mengambil data dari API...';

    fetch("api/ambil_user.php")
      .then(response => response.json())
      .then(data => {
        p3_allUsers = data.map((item, index) => ({...item, _idx: index + 1}));
        p3_renderRows(p3_allUsers);

        document.getElementById('p3-tabelUser').style.display = 'block';
        document.getElementById('p3-search').style.display = 'block';
        statusText.textContent = `${data.length} pengguna dimuat.`;
        btn.textContent = 'Muat Ulang';
      })
      .catch(err => {
        statusText.textContent = 'Gagal memuat data. Coba lagi.';
        console.error(err);
      })
      .finally(() => {
        btn.disabled = false;
        spinner.style.display = 'none';
      });
  }

  /* ===== PRAKTIKUM 4 ===== */
  function p4_setState(state, message){
    const card = document.getElementById('p4-statusCard');
    const icon = document.getElementById('p4-statusIcon');
    const glyph = document.getElementById('p4-iconGlyph');
    const label = document.getElementById('p4-statusLabel');
    const status = document.getElementById('p4-status');

    card.className = 'status-card state-' + state;
    icon.className = 'status-icon state-' + state;
    status.innerText = message;

    const glyphs = { idle: '•', loading: '', success: '✓', error: '!' };
    const labels = { idle: 'Menunggu', loading: 'Memuat', success: 'Berhasil', error: 'Gagal' };
    glyph.textContent = glyphs[state];
    label.textContent = labels[state];
  }

  function p4_loadData() {
    const btn = document.getElementById('p4-loadBtn');
    const listEl = document.getElementById('p4-daftarUser');

    btn.disabled = true;
    listEl.innerHTML = '';
    p4_setState('loading', 'Sedang mengambil data dari server...');

    fetch("api/ambil_user.php")
      .then(response => {
        if (!response.ok) {
          throw new Error("Gagal terhubung ke server (Status: " + response.status + ")");
        }
        return response.json();
      })
      .then(data => {
        p4_setState('success', "Berhasil memuat " + data.length + " data!");

        listEl.innerHTML = data.map((item, i) => `
          <li style="animation-delay:${i * 40}ms">
            <span class="u-name">${item.name}</span>
            <span class="u-email">${item.email}</span>
          </li>
        `).join('');
      })
      .catch(error => {
        p4_setState('error', 'Error: ' + error.message);
      })
      .finally(() => {
        btn.disabled = false;
      });
  }

  /* ===== PRAKTIKUM 5 ===== */
  const p5_consoleEl = document.getElementById('p5-hasilRespon');
  const p5_consoleBody = p5_consoleEl.querySelector('.console-body');
  const p5_statusBadge = document.getElementById('p5-statusBadge');
  const p5_submitBtn = document.getElementById('p5-submitBtn');

  function p5_setConsole(state, text){
    p5_consoleEl.className = 'console state-' + state;
    p5_consoleBody.textContent = text;
    const labels = { idle: 'menunggu', loading: 'mengirim', success: 'berhasil', error: 'gagal' };
    p5_statusBadge.textContent = labels[state];
  }

  document.getElementById("p5-formUser").addEventListener("submit", function(e) {
    e.preventDefault();

    const dataBaru = {
      name: document.getElementById("p5-nama").value,
      username: document.getElementById("p5-username").value,
      email: document.getElementById("p5-email").value,
      phone: document.getElementById("p5-phone").value,
      website: document.getElementById("p5-website").value
    };

    p5_submitBtn.disabled = true;
    p5_submitBtn.classList.add('loading');
    p5_setConsole('loading', 'Mengirim data ke server...');

    fetch("api/tambah_user.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(dataBaru)
    })
    .then(async response => {
      const result = await response.json();
      if (!response.ok || !result.success) {
        throw new Error(result.message || "Gagal menyimpan data.");
      }
      return result;
    })
    .then(result => {
      p5_setConsole('success',
        result.message + "\nID baru di database: " + result.data.id +
        "\n\nDetail:\n" + JSON.stringify(result.data, null, 2)
      );
      document.getElementById("p5-formUser").reset();
    })
    .catch(err => {
      p5_setConsole('error', 'Gagal mengirim data!\n' + err.message);
    })
    .finally(() => {
      p5_submitBtn.disabled = false;
      p5_submitBtn.classList.remove('loading');
    });
  });

  /* ===== TUGAS MANDIRI (TODOS) ===== */
  function p6_renderRows(todos){
    const body = document.getElementById('p6-isiTabel');
    body.innerHTML = todos.map((item, index) => `
      <tr>
        <td class="idx">${index + 1}</td>
        <td class="p6-title-cell ${item.completed ? 'done-title' : ''}">${item.title}</td>
        <td>
          ${item.completed
            ? '<span class="p6-tag done">[Selesai]</span>'
            : '<span class="p6-tag pending">[Belum Selesai]</span>'
          }
        </td>
      </tr>
    `).join('');
  }

  function p6_renderSummary(todos){
    const done = todos.filter(t => t.completed).length;
    const pending = todos.length - done;
    document.getElementById('p6-summary').innerHTML = `
      <span class="done">✓ ${done} selesai</span>
      <span class="pending">✗ ${pending} belum selesai</span>
    `;
  }

  function p6_loadData(){
    const btn = document.getElementById('p6-loadBtn');
    const btnLabel = document.getElementById('p6-btnLabel');
    const statusLine = document.getElementById('p6-statusLine');
    const tableShell = document.getElementById('p6-tabelTugas');

    btn.disabled = true;
    btn.classList.add('loading');
    btnLabel.textContent = 'Mengambil data...';
    statusLine.textContent = 'Sedang mengambil data dari server...';
    statusLine.style.color = '';
    document.getElementById('p6-summary').innerHTML = '';

    fetch("https://jsonplaceholder.typicode.com/todos")
      .then(response => {
        if (!response.ok) {
          throw new Error("Gagal terhubung ke server (Status: " + response.status + ")");
        }
        return response.json();
      })
      .then(data => {
        statusLine.textContent = `Berhasil memuat ${data.length} tugas.`;
        p6_renderRows(data);
        p6_renderSummary(data);
        tableShell.style.display = 'block';
      })
      .catch(error => {
        statusLine.textContent = 'Error: ' + error.message;
        statusLine.style.color = 'var(--error)';
      })
      .finally(() => {
        btn.disabled = false;
        btn.classList.remove('loading');
        btnLabel.textContent = 'Tampilkan Daftar Tugas';
      });
  }
</script>

</body>
</html>