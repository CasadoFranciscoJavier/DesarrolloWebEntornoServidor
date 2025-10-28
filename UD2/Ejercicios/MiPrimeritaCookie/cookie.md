Ejercicio sencillo para practicar **cookies en PHP** (nivel inicial, mismo estilo que el de sesiones).

---

### 🧩 Enunciado:

Desarrolla una aplicación PHP que **salude al usuario utilizando cookies**.

1. **cookie.html**:
   Crea un formulario con un solo campo de texto donde el usuario escriba su nombre y un botón para enviarlo a **cookie.php**.

2. **cookie.php**:

   * Recibe el nombre desde el formulario.
   * Crea una cookie llamada `"usuario"` con ese nombre y una duración de 1 minuto (`time() + 60`).
   * Muestra un mensaje como:
     `"Hola, [nombre]. Tu nombre se ha guardado en una cookie."`
   * Incluye un enlace a **hola_cookie.php**.

3. **hola_cookie.php**:

   * Comprueba si existe la cookie `"usuario"`.

     * Si existe, muestra `"Hola otra vez, [nombre guardado]"`.
     * Si **no existe** (porque ha expirado o no se ha creado), muestra una alerta `"No hay cookie activa"` y redirige automáticamente a **cookie.html**.
   * Añade un botón **"Borrar cookie"** que al pulsarlo elimine la cookie (estableciendo su tiempo en el pasado) y redirija a **cookie.html**.

---

¿Quieres que te dé el código completo ya hecho (en tres archivos listos para probar) o prefieres intentar hacerlo tú primero y luego lo corregimos juntos?
