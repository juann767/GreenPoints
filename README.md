#  GreenPoints — Proyecto Final

## Universidad Gerardo Barrios (UGB)

**Programación Computacional IV**
**Proyecto Final**

---

# Equipo de desarrollo

Juan Espinal Espinal Coto SMSS102323

Diego Martín López Moreno SMSS097824

Walter Alexander Ramírez Benítez SMSS082124

Franklin Aldahir Portillo Flores SMSS011624

---

# Descripción

**GreenPoints** es una aplicación web desarrollada con **Laravel** que busca incentivar el cuidado del medio ambiente mediante un sistema de recompensas basado en acciones ecológicas. La plataforma permite que los usuarios registren actividades de reciclaje, acumulen puntos y los utilicen para canjear premios, promoviendo así la participación en prácticas sostenibles.

Además de las funcionalidades para los usuarios, el sistema incorpora herramientas administrativas para gestionar premios, dispositivos ecológicos y la información general de la plataforma.

---

#  Objetivo del proyecto

Desarrollar una plataforma que fomente la cultura del reciclaje y la responsabilidad ambiental mediante un sistema de puntos y recompensas, utilizando tecnologías web modernas y una arquitectura organizada bajo el framework Laravel.

---

# Funcionalidades principales

## Autenticación de usuarios

El sistema cuenta con un módulo completo de autenticación que permite:

* Registro de nuevos usuarios.
* Inicio y cierre de sesión.
* Acceso a funcionalidades según el tipo de usuario.

---

## Registro de acciones ecológicas

Los usuarios pueden registrar actividades relacionadas con el reciclaje y otras acciones ambientales, generando un historial personal de participación.

Entre sus funciones se encuentran:

* Registro de nuevas acciones.
* Consulta del historial.
* Administración de registros.

---

## Sistema de puntos

Cada acción ecológica realizada genera una cantidad determinada de puntos para el usuario, incentivando la participación constante dentro de la plataforma y permitiendo obtener beneficios mediante el sistema de recompensas.

---

## Catálogo y canje de premios

La plataforma incorpora un catálogo de premios que pueden ser obtenidos utilizando los puntos acumulados.

Este módulo permite:

* Consultar los premios disponibles.
* Realizar canjes.
* Llevar un historial de premios obtenidos.

---

## Gestión de dispositivos ecológicos

El sistema permite administrar los diferentes dispositivos o puntos ecológicos registrados, incluyendo operaciones de:

* Consulta.
* Registro.
* Edición.
* Eliminación.

---

## Mapa de puntos ecológicos

GreenPoints incorpora un módulo de mapa que facilita la visualización de los puntos o dispositivos ecológicos registrados, proporcionando una referencia para los usuarios sobre su ubicación.

---

## Gestión de perfil

Cada usuario dispone de un perfil desde el cual puede administrar su información personal, actualizar sus datos y modificar su contraseña.

---

## Generación de comprobantes

El sistema incluye un módulo de comprobantes asociados a los registros realizados, permitiendo la consulta y visualización de comprobantes con código QR para validar la información correspondiente.

---

## Dashboard

La aplicación cuenta con un panel principal que reúne la información más importante del usuario y facilita el acceso a los distintos módulos del sistema desde una interfaz organizada e intuitiva.

---

## Panel de administración

El proyecto incorpora un área administrativa destinada a la gestión del sistema, desde la cual es posible administrar diferentes recursos y supervisar el funcionamiento general de la plataforma.

---

# Arquitectura

El proyecto fue desarrollado utilizando la arquitectura **Modelo-Vista-Controlador (MVC)** proporcionada por Laravel, permitiendo una organización clara entre la lógica de negocio, la interfaz de usuario y el acceso a los datos.

La aplicación está estructurada mediante:

* Modelos
* Controladores
* Vistas Blade
* Rutas
* Migraciones
* Seeders
* Base de datos

---

# Tecnologías utilizadas

* Laravel
* PHP
* Blade Templates
* CSS
* JavaScript
* SQLite
* Composer

---

# Impacto del proyecto

GreenPoints propone una solución tecnológica para incentivar hábitos sostenibles mediante un sistema de gamificación, donde las acciones ecológicas realizadas por los usuarios se transforman en puntos y beneficios. De esta manera, la plataforma combina educación ambiental, participación ciudadana y desarrollo de software en una aplicación orientada al cuidado del medio ambiente.


# Funcionalidades Complementarias

Además de las funcionalidades principales, GreenPoints incorpora elementos de gamificación que motivan la participación de los usuarios mediante:

* Sistema de niveles ecológicos basado en puntos acumulados.
* Insignias y logros obtenidos por reciclajes, puntos y canjes realizados.
* Barras de progreso para visualizar el avance del usuario.
* Estadísticas personales de actividad dentro de la plataforma.

Estas características fortalecen la experiencia de usuario y promueven una participación constante en actividades orientadas al cuidado del medio ambiente.

---

# Trabajo Colaborativo y Aprendizajes

Durante el desarrollo de GreenPoints se aplicaron metodologías de trabajo colaborativo para la planificación, diseño e implementación de cada módulo del sistema. El proyecto permitió fortalecer conocimientos en desarrollo web utilizando Laravel, gestión de bases de datos, arquitectura MVC, control de versiones y diseño de interfaces orientadas al usuario.

Asimismo, se adquirió experiencia en la integración de funcionalidades como autenticación, sistemas de recompensas, generación de códigos QR, geolocalización y gamificación, contribuyendo al desarrollo de soluciones tecnológicas con impacto social y ambiental.

# Conclusión

GreenPoints es una plataforma desarrollada para incentivar prácticas sostenibles mediante un sistema de puntos y recompensas. A través de herramientas como el registro de acciones ecológicas, canje de premios, geolocalización de puntos ecológicos y elementos de gamificación, el sistema fomenta la participación activa de los usuarios en el cuidado del medio ambiente, aplicando los conocimientos adquiridos durante el desarrollo de aplicaciones web con Laravel.


