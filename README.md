Instalación del Proyecto
Descargar el proyecto:

Si has descargado el archivo .zip, descomprímelo en la ubicación donde desees instalar el proyecto.
Configuración del Servidor:

Copia el contenido descomprimido en el directorio raíz de tu servidor web. Por ejemplo, si estás usando XAMPP, colócalo en C:\xampp\htdocs\RC.
Configuración de la Base de Datos:

Importa el archivo online_store.sql en tu gestor de bases de datos.
Abre phpMyAdmin y selecciona la base de datos que deseas utilizar, luego utiliza la opción "Importar" para cargar el archivo online_store.sql.
Asegúrate de que las credenciales de la base de datos en el proyecto coincidan con las de tu entorno. Esto usualmente se configura en un archivo config.php dentro del directorio includes o similar.
[Colocar aquí una imagen de la importación de la base de datos en phpMyAdmin]

Configuración de Archivos:

Revisa los archivos en el directorio includes para asegurarte de que la conexión a la base de datos esté correctamente configurada.
Si necesitas ajustar las rutas, verifica los archivos de configuración, generalmente encontrados en el directorio includes.
Iniciar el Proyecto:

Asegúrate de que el servidor web esté corriendo.
Abre un navegador web y navega a http://localhost/RC (o la ruta que hayas configurado en tu servidor).
[Colocar aquí una imagen de la página principal del proyecto una vez cargada en el navegador]

Estructura de Archivos y Directorios
controller/: Contiene los controladores que manejan la lógica de la aplicación.
css/: Incluye archivos de estilo CSS que definen la apariencia del sitio.
db/: Podría contener configuraciones específicas para la base de datos o scripts adicionales.
images/: Directorio donde se almacenan todas las imágenes utilizadas en la aplicación.
includes/: Almacena los archivos que son comúnmente incluidos en múltiples páginas, como cabeceras, pies de página, o scripts de configuración.
pages/: Aquí se encuentran las páginas web individuales del sitio, como el inicio, productos, contacto, etc.
Uso y Navegación por el Sitio Web
Página de Inicio:

Navega a la página principal para ver una vista general de la tienda.
[Colocar aquí una imagen de la página de inicio]

Páginas de Productos:

Accede a las distintas páginas de productos para explorar las categorías disponibles.
[Colocar aquí una imagen de una página de productos]

Funciones Adicionales:

Revisa las funcionalidades adicionales como carrito de compras, gestión de usuarios, etc.
[Colocar aquí una imagen de alguna funcionalidad específica]