Arquitectura Hexagonal: Cómo construir un producto usando DDD y con Drupal como infraestructura
Drupalcamp 2023

Este es el repositorio de la presentación de la charla de la drupalcamp de sevilla 2023.

Puedes encontrar la presentación aquí:
 - https://docs.google.com/presentation/d/1n9ef6_3IaKqyPj6VvL1hiYRPlJASVt3e25twnx-DZ2c/edit?usp=sharing

En la presentación he añadido slides con un poco más de explicación acerca de arquitecturas limpias y DDD.

El código está estructurado siguiendo las directrices de la arquitectura hexagonal.

Dentro de la carpeta app está el bounded context "drupalcamp" que incluye el Dominio, los casos de uso y la infraestructura.

También se incluye un módulo llamado ddd donde están el routing y el services necesarios para que funcione la aplicación

Se irán añadiendo entidades y casos hasta completar algo funcional, así como un front desacoplado en javascript.

Se acepta feedback y sugerencias

##API
### Create a Room
POST http://localhost:8844/web/api/room
{
"name": "NTT Data",
"building": "ETSI",
"address": "Reina Mercedes",
"floor": 3
}

### Update Room name
PUT /api/room/update/Hiberus/?new_name=1xInternet

### Get Room List
GET /api/room?fields=name,building,address

Ver fichero drupalcamp.http para más información.
