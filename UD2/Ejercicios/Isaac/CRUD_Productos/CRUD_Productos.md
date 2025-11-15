## Enunciado del Problema:

**Descripción:**  
Desarrolla una aplicación web en PHP que permita a los usuarios realizar operaciones CRUD (Crear, Leer, Actualizar y Eliminar) en la tabla `PRODUCTO` de una base de datos llamada `TIENDA`. La tabla `PRODUCTO` contiene los siguientes campos:

- **ID:** Identificador único de cada producto.
- **NOMBRE:** Nombre del producto.
- **PRECIO:** Precio del producto (decimal con dos decimales).

La aplicación debe cumplir con los siguientes requisitos:

1. **Listar** todos los productos existentes en la base de datos en la pantalla principal.
2. **Agregar** nuevos productos a la base de datos.
3. **Editar** productos existentes (nombre y precio).
4. **Eliminar** productos de la base de datos.

La pantalla principal (index.php) debe mostrar una lista de productos, con botones para **añadir**, **editar**, y **eliminar** en cada producto.

**Requisitos:**  
Implementa el sistema utilizando el patrón de diseño **MVC** (Modelo-Vista-Controlador) y organiza el código en tres capas: **Modelo** para la lógica de la base de datos, **Vista** para la interfaz de usuario y **Controlador** para manejar las interacciones de los usuarios.

### Estructura del Proyecto

El proyecto debe seguir la siguiente estructura de carpetas y archivos:

```
/CRUD_Productos/
│
├── /model/
│   ├── Producto.php
│   └── ProductoModel.php
│
├── /view/
│   ├── agregar.php
│   ├── editar.php
│   └── eliminar.php
│
└── index.php
```

### Descripción de los Archivos

#### 1. **index.php**
   - Este archivo es el punto de entrada de la aplicación y muestra la lista de productos desde el inicio.
   - Al cargar la lista de productos, cada uno debe tener botones para **editar** y **eliminar**.
     - Muestra un mensaje de confirmación antes de eliminar un producto.
   - Un botón adicional **Añadir** debe permitir acceder al formulario para añadir nuevos productos.

#### 2. **/model/ProductoModel.php**
   - Esta clase representa el modelo de la tabla `PRODUCTO` y contiene métodos para interactuar con la base de datos.
   - Métodos principales:
     - `obtenerTodos()`: Obtiene todos los productos.
     - `obtenerPorId($id)`: Obtiene un producto por su ID.
     - `agregar($producto)`: Agrega un nuevo producto.
     - `actualizar($producto)`: Actualiza un producto existente.
     - `eliminar($producto)`: Elimina un producto por ID.

#### 5. **/view/agregar.php**
   - Muestra un formulario para agregar un nuevo producto.
   - Este formulario debe tener campos para el **nombre** y **precio** del producto, y un botón para enviar el formulario.

#### 6. **/view/editar.php**
   - Muestra un formulario para editar un producto existente.
   - El formulario debe estar precargado con los datos del producto seleccionado para facilitar la edición y guardar los cambios en la base de datos.

#### 7. **/view/eliminar.php**

### Funcionamiento

1. **Pantalla Principal (index.php):**  
   - Al ingresar a la aplicación, el usuario verá la lista de productos con nombre, precio y opciones para **Editar** y **Eliminar** cada producto.
   - Un botón **Añadir Producto** estará disponible para crear un nuevo producto.

2. **Agregar Producto:**  
   - Al hacer clic en el botón "Añadir Producto", el usuario accede al formulario (`agregar.php`) donde debe introducir el nombre y el precio del producto.

3. **Editar Producto:**  
   - Al hacer clic en el botón "Editar" junto a un producto, el usuario accede al formulario de edición (`editar.php`), con los datos precargados del producto que se desea modificar.

4. **Eliminar Producto:**  
   - Al hacer clic en el botón "Eliminar" junto a un producto, el usuario es redirigido a (`eliminar.php`) para borrar el producto de la base de datos. Muestra un mensaje de confirmación antes de eliminar un producto.