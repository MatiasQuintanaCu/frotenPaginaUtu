
<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <title>Registro de usuario</title>
</head>
<body>
 <h2>Formulario de registro</h2>
 <form id="registerForm">
   <label>Nombre:</label>
   <input type="text" id="nombre" required><br><br>


   <label>Correo:</label>
   <input type="email" id="correo" required><br><br>


   <label>Contraseña:</label>
   <input type="password" id="contrasena" required><br><br>


   <button type="submit">Registrar</button>
 </form>


 <pre id="resultado"></pre>


 <script>
   document.getElementById('registerForm').addEventListener('submit', async (e) => {
     e.preventDefault();


     const nombre = document.getElementById('nombre').value;
     const correo = document.getElementById('correo').value;
     const contrasena = document.getElementById('contrasena').value;


     try {
       const res = await fetch('/v1/user/create', {
         method: 'POST',
         headers: { 'Content-Type': 'application/json' },
         body: JSON.stringify({ nombre, correo, contrasena })
       });


       const data = await res.json();
       document.getElementById('resultado').textContent = JSON.stringify(data, null, 2);
     } catch (err) {
       document.getElementById('resultado').textContent = 'Error: ' + err;
     }
   });
 </script>
</body>
</html>


