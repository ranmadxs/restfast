# Restfast

API escrita en PHP, que permite publicar servicios Rest mediante anotaciones.

## Requerimientos de software:

 - Módulo PHP addendum

### Anotaciones Rest-Fast

```java
@Path("/exampleRest")
```
Indica la ruta relativa donde se encuentran todos los servicios disponibles

```java
 @Produces(mediaType="json")
```
El tipo de respuesta del servicio, para este caso json

Un ejemplo de la implementación de estas dos clases sería:

```php
/**
 @Path("/exampleRest")
 @Produces(mediaType="json")
 */
class ExampleRest {
 ...
}
```


### Catálogo de Servicios Rest

Para instanciar los servicios rest se debe ocupar la clase RestFast, la cual publica un catálogo de servicios con cada una de las clases que han sido añadidas, indicando sus parámetros y el endpoint

Ejemplo:

```php
$restFast = new RestFast();
$restFast->setClass(array("ExampleRest"));
$restFast->handle();

```
