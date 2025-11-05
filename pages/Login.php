<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login UTU</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            width: 300px;
        }
        input, button {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 10px;
        }
        button {
            background-color: #004aad;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #003680;
        }
    </style>
</head>
<body>
<div class="card">
    <h2>Iniciar sesión</h2>
    <input type="email" id="correo" placeholder="Correo">
    <input type="password" id="contraseña" placeholder="Contraseña">
    <button onclick="login()">Ingresar</button>
    <p id="msg"></p>
</div>

<script>
async function login() {
    const email = document.getElementById("correo").value;
    const password = document.getElementById("contraseña").value;

    const response = await fetch("http://localhost/api/user/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        credentials: "include",
        body: JSON.stringify({ email, password })
    });

    const text = await response.text();
    document.getElementById("msg").textContent = text;
}
</script>
</body>
</html>
