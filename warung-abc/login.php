<?php
session_start();

if (isset($_SESSION['pesan_error'])) {
    $pesan_error = $_SESSION['pesan_error'];
    unset($_SESSION['pesan_error']);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Warung ABC</title>

    <style>

        /* =========================
           RESET
        ========================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }


        /* =========================
           BODY
        ========================= */

        body {
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;

            background:
                radial-gradient(
                    circle at top left,
                    rgba(235, 238, 243, 0.35),
                    transparent 35%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(219, 94, 188, 0.35),
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #e5e8ee,
                    #d47ba0,
                    #cf448a
                );

            position: relative;
            overflow: hidden;
        }


        /* =========================
           BACKGROUND DECORATION
        ========================= */

        body::before {
            content: "";

            position: absolute;

            width: 300px;
            height: 300px;

            background: rgba(255,255,255,0.08);

            border-radius: 50%;

            top: -100px;
            left: -100px;

            filter: blur(2px);
        }


        body::after {
            content: "";

            position: absolute;

            width: 350px;
            height: 350px;

            background: rgba(255,255,255,0.06);

            border-radius: 50%;

            right: -130px;
            bottom: -130px;
        }


        /* =========================
           LOGIN BOX
        ========================= */

        .login-box {
            width: 400px;

            background: rgba(255,255,255,0.97);

            padding: 40px;

            border-radius: 20px;

            position: relative;
            z-index: 2;

            box-shadow:
                0 25px 60px rgba(0,0,0,0.25),
                0 5px 20px rgba(0,0,0,0.08);

            animation: muncul 0.5s ease;
        }


        @keyframes muncul {

            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }


        /* =========================
           LOGO
        ========================= */

        .logo {
            width: 65px;
            height: 65px;

            margin: 0 auto 15px;

            display: flex;
            justify-content: center;
            align-items: center;

            background: linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            color: white;

            border-radius: 18px;

            font-size: 32px;

            box-shadow:
                0 10px 20px rgba(37,99,235,0.25);
        }


        /* =========================
           TITLE
        ========================= */

        .login-box h1 {
            text-align: center;

            color: #111827;

            font-size: 27px;

            margin-bottom: 7px;
        }


        .login-box .subtitle {
            text-align: center;

            color: #6b7280;

            font-size: 14px;

            margin-bottom: 28px;
        }


        /* =========================
           ERROR
        ========================= */

        .error {
            background: #fef2f2;

            color: #dc2626;

            border: 1px solid #fecaca;

            padding: 12px 14px;

            border-radius: 10px;

            margin-bottom: 20px;

            font-size: 13px;

            text-align: center;
        }


        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 18px;
        }


        .form-group label {
            display: block;

            color: #374151;

            font-size: 13px;

            font-weight: bold;

            margin-bottom: 8px;
        }


        /* =========================
           INPUT
        ========================= */

        .input-box {
            position: relative;
        }


        .input-icon {
            position: absolute;

            left: 14px;
            top: 50%;

            transform: translateY(-50%);

            font-size: 17px;

            color: #6b7280;

            pointer-events: none;
        }


        .input-box input {
            width: 100%;

            padding: 13px 14px 13px 43px;

            border: 1px solid #d1d5db;

            border-radius: 10px;

            outline: none;

            font-size: 14px;

            background: #f9fafb;

            color: #111827;

            transition: 0.3s;
        }


        .input-box input::placeholder {
            color: #9ca3af;
        }


        .input-box input:focus {
            border-color: #2563eb;

            background: white;

            box-shadow:
                0 0 0 4px rgba(37,99,235,0.10);
        }


        /* =========================
           BUTTON LOGIN
        ========================= */

        .btn-login {
            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 10px;

            background: linear-gradient(
                135deg,
                #e6709d,
                #d81d9a
            );

            color: white;

            font-size: 15px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;

            margin-top: 5px;

            box-shadow:
                0 8px 18px rgba(37,99,235,0.25);
        }


        .btn-login:hover {
            transform: translateY(-2px);

            box-shadow:
                0 12px 25px rgba(37,99,235,0.35);
        }


        .btn-login:active {
            transform: translateY(0);
        }


        /* =========================
           FOOTER
        ========================= */

        .footer {
            text-align: center;

            margin-top: 25px;

            padding-top: 18px;

            border-top: 1px solid #e5e7eb;

            color: #9ca3af;

            font-size: 12px;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 500px) {

            body {
                padding: 15px;
            }

            .login-box {
                width: 100%;

                padding: 30px 25px;

                border-radius: 16px;
            }

            .login-box h1 {
                font-size: 24px;
            }

        }

    </style>

</head>


<body>


    <div class="login-box">


        <!-- LOGO -->

        <div class="logo">
            🛒
        </div>


        <!-- JUDUL -->

        <h1>
            Warung ABC
        </h1>

        <p class="subtitle">
            Silakan login untuk melanjutkan
        </p>


        <!-- PESAN ERROR -->

        <?php if (isset($pesan_error)) { ?>

            <div class="error">

                ⚠️
                <?php
                echo htmlspecialchars($pesan_error);
                ?>

            </div>

        <?php } ?>


        <!-- FORM LOGIN -->

        <form
            action="proses_login.php"
            method="POST"
        >


            <!-- USERNAME -->

            <div class="form-group">

                <label>
                    Username
                </label>

                <div class="input-box">

                    <span class="input-icon">
                        👤
                    </span>

                    <input
                        type="text"
                        name="username"
                        placeholder="Masukkan username"
                        autocomplete="username"
                        required
                    >

                </div>

            </div>


            <!-- PASSWORD -->

            <div class="form-group">

                <label>
                    Password
                </label>

                <div class="input-box">

                    <span class="input-icon">
                        🔒
                    </span>

                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                </div>

            </div>


            <!-- BUTTON -->

            <button
                type="submit"
                class="btn-login"
            >

                🔐 Login

            </button>


        </form>


        <!-- FOOTER -->

        <div class="footer">

            Sistem Kasir &nbsp;•&nbsp; Warung ABC

        </div>


    </div>


</body>

</html>