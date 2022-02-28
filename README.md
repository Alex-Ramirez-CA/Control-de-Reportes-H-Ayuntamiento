# Control-de-Reportes-H-Ayuntamiento

## Requerimientos
### Funcionales
1. El usuario accederá al sistema mediante un logueo.
2. Los usuarios “cliente, filtro y técnico” accederán al sistema con las llaves dadas por el usuario denominado “administrador” y no podrán cambiarlas al menos que el administrador así lo decida.
3. El sistema contará con cuatro vistas, una para cada tipo de usuario:  
    a. El usuario denominado “cliente” hará el levantamiento de reporte mediante un formulario que se mostrará en pantalla. Además tendrá accesos al historial de todos sus reportes hechos con sus respectivos estatus.
    b. El usuario denominado “filtro” podrá ver y asignar todos los reportes hechos por el cliente a una o más áreas técnicas específicas (administrativo, soporte técnico y/o redes). Además podrá completar el reporte si lo ve necesario.
    c. El usuario denominado “técnico” podrá ver todos los reportes que tiene dependiendo su área de especialidad y podrá asignarle un estatus (por hacer, haciendo o finalizado).
    d. El usuario denominado “administrador” podrá crear, actualizar o eliminar a todo tipo de usuarios. Además que tendrá acceso al historial de los reportes hechos.  
4. Una vez que el usuario cliente levante el reporte, este no podrá ser eliminado. 
5. El formato con el cual el cliente tendrá que subir el reporte será:
    a. Título
    b. Descripción
    c. Archivos multimedia (fotos, videos o archivos)
6. El sistema agregará automáticamente al formato del reporte los siguientes datos:
    a. Fecha
    b. Datos del usuario
    c. Departamento de donde se hace el reporte
    d. Datos referentes al equipo
7. El sistema enviará un correo electrónico al cliente con cada uno de los estatus del reporte.
8. Se implementará una acción de añadir comentarios al reporte para que el cliente y el técnico puedan estar en comunicación constantemente, además de que se podrán adjuntar archivos multimedia a los mismos.

### No Funcionales
1. La aplicación será de tipo WEB, tanto para ordenador como para móvil.
2. Los colores del sistema se tomarán de un manual el cual nos proporcionará la institución.
3. Los logos de la institución serán proporcionados por ellos.
4. Habrá 4 tipos de usuarios (administrador, filtro, técnico y cliente)
5. La base de datos a utilizar será de tipo relacional
6. El motor de base de datos a utilizar es MySQL
7. El desarrollo se dividirá en FrontEnd y BackEnd
8. El FrontEnd y el BackEnd se comunicarán mediante una API Rest
9. Para el FrontEnd se utilizará las tecnologías HTML, CSS y JavaScript
10. Se utilizará el Framework de React para JavaScript
11. Para el BackEnd se utilizara el lenguaje PHP en su versión 7 en adelante
12. Se estará utilizando el Framework CodeIgniter para PHP
13. La aplicación se alojará en los servidores locales del establecimiento
14. El servidor de internet a utilizar es APACHE XAMPP en su versión (#)
15. La aplicación será compatible con navegadores Chrome, Edge y Firefox
16. Esta será responsive para pantallas de tipo ordenador, laptop y moviles
17. Será necesario una conexión a la red local para poder hacer uso de la misma
