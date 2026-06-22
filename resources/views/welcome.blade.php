<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi P2KP & HRIS Dosen Terintegrasi. Solusi otomatisasi laporan kinerja dan Tri Dharma Perguruan Tinggi.">
    <title>Penilaian Prestasi Kerja Pegawai (P2KP) & HRIS Dosen</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --secondary: #a855f7;
            --dark: #0f172a;
            --light: #f8fafc;
            --glass: rgba(255, 255, 255, 0.8);
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--light);
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(168, 85, 247, 0.15) 0px, transparent 50%);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Header / Navbar */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 5%;
            backdrop-filter: blur(10px);
            background: rgba(248, 250, 252, 0.8);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo::before {
            content: '⚡';
            font-size: 1.4rem;
        }

        nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 600;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: var(--primary);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            opacity: 0.95;
        }

        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background: rgba(99, 102, 241, 0.05);
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 5rem 5%;
            position: relative;
        }

        .hero-badge {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--dark);
            max-width: 900px;
            animation: fadeIn 1s ease 0.2s forwards;
            opacity: 0;
        }

        .hero h1 span {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            color: #64748b;
            max-width: 650px;
            margin-bottom: 3rem;
            line-height: 1.6;
            animation: fadeIn 1s ease 0.4s forwards;
            opacity: 0;
        }

        .hero-actions {
            display: flex;
            gap: 1.5rem;
            animation: fadeIn 1s ease 0.6s forwards;
            opacity: 0;
        }

        /* Features Section */
        .features {
            padding: 5rem 5%;
            background: white;
            border-top: 1px solid #e2e8f0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 3rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: var(--light);
            padding: 2.5rem;
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
            border-color: var(--primary);
        }

        .card-icon {
            font-size: 2rem;
            background: white;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card p {
            color: #64748b;
            line-height: 1.5;
            font-size: 0.95rem;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: #94a3b8;
            text-align: center;
            padding: 3rem 5%;
            margin-top: auto;
        }

        footer p {
            font-size: 0.875rem;
        }

        /* Animations */
        @keyframes fadeIn {
            to { opacity: 1; }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            nav { display: none; } /* Simplicity for now */
            .hero-actions { flex-direction: column; width: 100%; max-width: 300px; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">Penilaian Prestasi Kerja Pegawai (P2KP)</div>
        <nav>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar Akun</a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <main class="hero">
        <h1>Kelola P2KP otomatisasi pengisian dokumen P2KP berbasis integrasi data SISTER</h1>
        
        <div class="hero-actions">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-large">Masuk ke Dashboard</a>
            @endauth
        </div>
    </main>

    <section class="features">
        <h2 class="section-title">Fitur Unggulan</h2>
        <div class="grid">
            <div class="card">
                <div class="card-icon">📁</div>
                <h3>Integrasi SISTER</h3>
                <p>Unggah file PDF LKD dari SISTER dan biarkan sistem mengisi otomatis capaian Tri Dharma Anda.</p>
            </div>
            <div class="card">
                <div class="card-icon">🔄</div>
                <h3>Alur Kerja Multi-Peran</h3>
                <p>Siklus penilaian dari Dosen, Pejabat Penilai, hingga Atasan Pejabat Penilai yang terstruktur.</p>
            </div>
            <div class="card">
                <div class="card-icon">📄</div>
                <h3>Cetak PDF Sesuai Format</h3>
                <p>Hasil akhir dokumen langsung sesuai dengan format template resmi kampus Anda.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 Penilaian Prestasi Kerja Pegawai (P2KP). Membantu Dosen Fokus pada Tri Dharma.</p>
    </footer>

</body>
</html>
