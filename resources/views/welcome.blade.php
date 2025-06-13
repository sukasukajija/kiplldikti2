@extends('layouts.home')

@section('content')
<style>
    .wireframe,
    .wireframe * {
        box-sizing: border-box;
    }

    .wireframe {
        background: #ffffff;
        min-height: 100vh;
        height: auto;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .frame-95 {
        display: flex;
        flex-direction: row;
        gap: 43px;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 1440px;
        height: 667px;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 121px;
        box-sizing: border-box;
        padding: 0 20px;
    }

    .frame-93 {
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 50%;
        min-width: 280px;
        max-width: 650px;
        box-sizing: border-box;
    }

    .frame-8 {
        display: flex;
        flex-direction: column;
        gap: 36px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 100%;
        max-width: 650px;
    }

    .sim-kip-kuliah-merdeka {
        text-align: left;
        font-family: "Inter-SemiBold", sans-serif;
        font-size: 48px;
        font-weight: 600;
        align-self: stretch;
    }

    .sim-kip-kuliah-merdeka span {
        display: inline-block;
    }

    .sim-kip-kuliah-merdeka-span {
        color: #071120;
    }

    .sim-kip-kuliah-merdeka-span2 {
        color: #0091c9;
    }

    .sim-kip-kuliah-merdeka-span3 {
        color: #071120;
    }

    .sim-kip-kuliah-merdeka-span4 {
        color: #0091c9;
    }

    .kartu-indonesia-pintar-kuliah {
        color: #0c1c35;
        text-align: justify;
        font-family: "Inter-Regular", sans-serif;
        font-size: 16px;
        line-height: 175%;
        font-weight: 400;
        align-self: stretch;
    }

    .login-register {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }

    .button,
    .button2 {
        width: 130px;
        height: 51px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "Montserrat-Medium", sans-serif;
        font-size: 20px;
        font-weight: 500;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .button {
        background: #11284b;
        color: #ffffff;
    }

    .button:hover {
        background: #0d1e38;
    }

    .button2 {
        background: #ffffff;
        color: #1b3e72;
        border: 1px solid #1b3e72;
    }

    .button2:hover {
        background: #f1f1f1;
    }

    .frame-94 {
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 45%;
        min-width: 220px;
        max-width: 507px;
        height: auto;
        box-sizing: border-box;
    }

    .frame-94 img {
        max-width: 100%;
        height: auto;
        object-fit: cover;
    }

    .frame-96 {
        width: 340px;
        height: 99px;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 22px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-6 {
        width: 271px;
        height: 75px;
        object-fit: cover;
    }

    /* Responsive styles */
    @media (max-width: 1200px) {
        .frame-95 {
            max-width: 1000px;
            height: auto;
            gap: 20px;
        }
        .frame-93, .frame-94 {
            max-width: 100%;
            width: 48%;
        }
    }

    @media (max-width: 900px) {
        .frame-95 {
            max-width: 700px;
            gap: 10px;
            padding: 0 10px;
        }
        .frame-93, .frame-94 {
            width: 100%;
            max-width: 100%;
        }
    }

    @media (max-width: 768px) {
        .frame-95 {
            flex-direction: column;
            gap: 20px;
            width: 100%;
            top: 120px;
            height: auto;
            position: static;
            transform: none;
            left: 0;
            padding: 0 3vw; /* lebih kecil agar tidak terlalu sempit */
        }

        .frame-93, .frame-94 {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            padding: 0 2vw; /* tambah padding samping */
        }

        .frame-8 {
            width: 100%;
            max-width: 100%;
            align-items: center;
        }

        .sim-kip-kuliah-merdeka {
            font-size: 24px; /* sedikit lebih kecil */
            text-align: center;
        }

        .kartu-indonesia-pintar-kuliah {
            font-size: 13px;
            text-align: center;
            padding: 0 2vw;
        }

        .frame-94 img {
            max-width: 95vw;
            height: auto;
        }

        .login-register {
            justify-content: center;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        .button,
        .button2 {
            width: 100%;
            max-width: 220px;
            margin: 0 auto;
        }

        .frame-96 {
            width: 100%;
            max-width: 100vw;
            height: auto;
            position: relative;
            left: 0;
            top: 0;
            transform: none;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 20px;
        }

        .image-6 {
            width: 60vw;
            max-width: 220px;
            height: auto;
            margin: 0 auto;
            display: block;
        }
    }

    @media (max-width: 480px) {
        .sim-kip-kuliah-merdeka {
            font-size: 18px;
        }
        .kartu-indonesia-pintar-kuliah {
            font-size: 11px;
        }
        .frame-96 {
            width: 100vw;
            max-width: 100vw;
            padding-top: 10px;
        }
        .image-6 {
            width: 80vw;
            max-width: 120px;
        }
        .frame-94 img {
            max-width: 98vw;
        }
        .button, .button2 {
            font-size: 16px;
            height: 44px;
        }
    }
</style>

<div class="wireframe">
    <div class="frame-96">
        <img class="image-6" src="{{ asset('img/logo.png') }}" alt="Logo" />
    </div>
    <div class="frame-95">
        <div class="frame-93">
            <div class="frame-8">
                <div class="sim-kip-kuliah-merdeka">
                    <span class="sim-kip-kuliah-merdeka-span">SIM</span>
                    <span class="sim-kip-kuliah-merdeka-span2">KIP</span>
                    <span class="sim-kip-kuliah-merdeka-span3">Kuliah</span>
                    <span class="sim-kip-kuliah-merdeka-span4">Merdeka</span>
                </div>
                <div class="kartu-indonesia-pintar-kuliah">
                    Welcome Operator! <br>
                    SIM-KIP adalah sistem yang mendukung pengelolaan program KIP Kuliah di LLDIKTI Wilayah II. Sistem ini mempermudah  pengajuan pencairan, agar memberikan layanan yang efisien dan transparan bagi semua pihak terkait.
                </div>
                <div class="login-register">
                    <a href="{{ route('register') }}" class="button">Register</a>
                    <a href="{{ route('login') }}" class="button2">Log in</a>
                </div>
            </div>
        </div>
        <div class="frame-94">
            <img src="{{ asset('img/gambar kanan.png') }}" alt="Image" />
        </div>
    </div>
</div>
@endsection
