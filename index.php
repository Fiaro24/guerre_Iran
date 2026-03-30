<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Military Login</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.9));
        color: #fff;
    }

    .container {
        width: 100%;
        max-width: 400px;
        padding: 30px;
        border-radius: 12px;
        background: rgba(20, 20, 20, 0.85);
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 0 25px rgba(0,0,0,0.6);
        backdrop-filter: blur(8px);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #d4af37;
    }

    .input-group {
        margin-bottom: 15px;
    }

    label {
        font-size: 13px;
        margin-bottom: 5px;
        display: block;
        color: #ccc;
    }

    .password-wrapper {
        position: relative;
    }

    input {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #444;
        background: #111;
        color: #fff;
        outline: none;
        transition: 0.3s;
    }

    input:focus {
        border-color: #d4af37;
        box-shadow: 0 0 8px #d4af37;
    }

    .toggle-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #ccc;
        cursor: pointer;
        font-size: 16px;
    }

    .toggle-btn:hover {
        color: #d4af37;
    }

    button.submit-btn {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        background: #d4af37;
        color: #000;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    button.submit-btn:hover {
        background: #b8922e;
    }

    .message {
        margin-top: 12px;
        text-align: center;
        font-size: 14px;
    }

    .error {
        color: #ff4d4d;
    }

    .success {
        color: #4dff88;
    }

    @media (max-width: 480px) {
        .container {
            margin: 20px;
            padding: 20px;
        }

        h2 {
            font-size: 18px;
        }
    }
</style>
</head>

<body>

<div class="container">
    <h2>ACCESS LOGIN</h2>

    <form id="loginForm">
        <div class="input-group">
            <label>IDENTIFIANT</label>
            <input type="email" id="email" placeholder="Enter ID" required>
        </div>

        <div class="input-group">
            <label>MOT DE PASSE</label>
            <div class="password-wrapper">
                <input type="password" id="password" placeholder="Enter Code" required>
                <button type="button" class="toggle-btn" onclick="togglePassword()">👁</button>
            </div>
        </div>

        <button type="submit" class="submit-btn">ENTER</button>

        <div id="message" class="message"></div>
    </form>
</div>

<script>
    const form = document.getElementById("loginForm");
    const message = document.getElementById("message");

    form.addEventListener("submit", function(e) {
        e.preventDefault();MOT

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        if (!email || !password) {
            message.textContent = "⚠️ Tous les champs sont requis";
            message.className = "message error";
            return;
        }

        // Simulation login
        if (email === "admin@test.com" && password === "1234") {
            message.textContent = "✅ ACCÈS AUTORISÉ";
            message.className = "message success";
        } else {
            message.textContent = "❌ ACCÈS REFUSÉ";
            message.className = "message error";
        }
    });

    function togglePassword() {
        const passwordInput = document.getElementById("password");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    }MOT
</script>

</body>
</html>