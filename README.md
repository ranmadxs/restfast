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
Los métodos de la clase pueden utilizar las siguientes anotaciones:

```java
@Path("/lista/{id}/{code}")
```
Completa la uri definida en la clase, se puede utilizar para identificar el método de la clase, se pueden utilizar queryParams
para este caso id, code.

```java
@GET, @POST
```
Nos indica el tipo con el cual es expuesto el método

Un ejemplo de implementación sería:

```php
/**
 @Path("/exampleRest")
 @Produces(mediaType="json")
 */
class ExampleRest {

 	/**
	 @Path("/listAll/")
	 @GET
	 */
	 public function listAll(){
	    ...
	    return $lista;
	 }
	 
	 	/**
	 @Path("/delete/{id}")
	 @GET
	 */        
	 public function delete($id){
	  ...
  }

	/**
	 @Path("/create")
	 @POST
	 */
	public function create(){
	 // dentro se ocupa el $_POST para recuperar la información
	 ...
	}
  
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
