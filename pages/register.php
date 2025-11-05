<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
</head>
<body>
  <h1>Registro</h1>
  <form id="registerForm">
    <label>Nombre:</label>
    <input type="text" id="nombre" required><br><br>

    <label>Correo:</label>
    <input type="email" id="correo" required><br><br>

    <label>Contraseña:</label>
    <input type="password" id="contrasena" required><br><br>

    <button type="submit">Registrarse</button>
  </form>

  <p id="resultado"></p>

  <script>
    const form = document.getElementById("registerForm");
    const resultado = document.getElementById("resultado");

    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const data = {
        nombre: document.getElementById("nombre").value,
        correo: document.getElementById("correo").value,
        contrasena: document.getElementById("contrasena").value
      };

      try {
        const res = await fetch("/api/user/create", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data)
        });

        // Intentar leer la respuesta como JSON
        const json = await res.json();

        resultado.textContent = JSON.stringify(json, null, 2);
      } catch (err) {
        console.error("Error:", err);
        resultado.textContent = "❌ Error al conectar con el servidor.";
      }
    });
  </script>
</body>
</html>
