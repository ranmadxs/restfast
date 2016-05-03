# Restfast

API escrita en PHP, que permite publicar servicios Rest mediante anotaciones.

## Requerimientos de software:

 - Módulo PHP addendum

### Catálogo de Servicios Rest

Para instanciar los servicios rest se debe ocupar la clase RestFast, la cual publica un catálogo de servicios con cada una de las 
clases que han sido añadidas, ejemplo:

```php
$restFast = new RestFast();
$restFast->setClass(array("ExampleRest"));
$restFast->handle();

```
