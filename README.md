## Framework Laravel 

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/downloads.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

## Documentación Oficial

Laravel es un framework basado en PHP y que trabaja con el patrón de arquitectura de software MVC (Modelo Vista controlador), el cual permite agilizar el flujo de desarrollo y trabajo. Su flexibilidad hace que las integraciones con herramientas tanto back end como front end sean fácilmete asimiladas.   

Se construye la base de la aplicación con Laravel 4.2 para aplicar de forma organizada y coherente el modelo vista - controlador.

Laravel poseé Eloquent, un OMR(Object-Relational Mapping) que permite mapear los datos almacenados en la base de datos en un lenguaje de script SQL a objetos de PHP y viceversa.

A su vez Eloquent permite realizar migraciones para llevar control sobre las operaciones en la base de datos. En el caso especifico relacionado de esta aplicación se maneja de la siguiente manera:

​Base de datos MySql:

**Usuarios:**
```sh
public function up()
{
	Schema::create('users', function($table){
		$table->increments('id');
		$table->string('name', 60);
		$table->string('phone', 20);
		$table->string('email', 100)->index();
		$table->string('password', 100);
		$table->tinyInteger('type');
		$table->string('code', 20);
		$table->string('facebookId', 20)->index();
		$table->tinyInteger('state');
		$table->rememberToken();
		$table->timestamps();
	});
}

public function down()
{
	Schema::dropIfExists('users');
}
```

​**Permisos:**
```sh
public function up()
{
	Schema::create('user_privileges', function($table){
		$table->increments('id');
		$table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
		$table->boolean('view')->default(0);
		$table->boolean('edit')->default(0);
		$table->boolean('delete')->default(0);
		$table->timestamps();
	});
}

public function down()
{
	Schema::dropIfExists('user_privileges');
}
```

Al separar la capa logica de los datos, la aplicación se normaliza en temas como rendimiento y escalabilidad, llevando un control más soberanos sobre estos.

La documentación del framework se puede encontrar en [sitio Laravel](http://laravel.com/docs/4.2).

### Licencia Laravel

El framework Laravel es un software open-sourced bajo la licencia [MIT](http://opensource.org/licenses/MIT)

### Plugins y librerias usadas

Lista de plugins usados en este proyecto:

| Plugin | URL |
| ------ | ------ |
| jQuery | [Sitio](https://jquery.com/) |
| Bootstrap | [Sitio](http://getbootstrap.com/) [Github](https://github.com/twbs/bootstrap) |
| SDK Facebook para PHP | [Sitio](https://developers.facebook.com/docs/reference/php) [Github](https://github.com/facebook/php-graph-sdk) |

## SDK(Software Development Kit) de Facebook para PHP

El SDK de Facebook para PHP es una biblioteca con funciones especificas para integrar el inicio de sesión con Facebook y solicitar peticiones al API Graph, con el fin de lograr control total de como interactúa con entornos de alojamiento y marcos web específicos.

Este proyecto se integra con esta libreria para poder autenticar y/o registrar con una cuenta de Facebook a los usuarios de acuerdo al requerimiento solicitado.

La documentación de la libreria se encuentra en [Desarrolladores Facebook](https://developers.facebook.com/docs/reference/php)

## Bootstrap CSS

Bootstrap es una herramienta front end que permite agilizar el flujo de trabajo utilizando recursos CSS, también tiene soporte de herramientas como LESS y SASS de acuerdo a la magnitud del desarrollo.

Es compatibley ampliamente utilizado con frameworks de desarrollo Back end como Laravel que se usa para este proyecto, y otros de front end, asi como el complementos propiamente dicho: JQuery, por lo tanto su versatilidad, simpleza y compatibilidad entrega un plus estético y funcional a este proyecto.

La documentación del framework se encuentra en: [sitio Bootstrap](http://getbootstrap.com/)

## jQuery

jQuery es una libreria multiplataforma de JavaScript que gracias a su versatilidad y comportamiento se ha ganado un espacio importante en el desarrollo web.

Dentro de este proyecto es utilizado como complemento en algunas funciones del lado del cliente para complementar y juntarse con Bootstrap para aportar en la experiencia de usuario.

Al ser una libreria de JavaScript tiene funciones propias que permiten la escalabilidad de cualquier proyecto en especial del tipo en mención.

Complementos como Ajax, hacen que JQuery sea un complemento natural de un buen proyecto web.

jQuery es software libre y de código abierto, posee un doble licenciamiento bajo la Licencia MIT y la Licencia Pública General de GNU v2, permitiendo su uso en proyectos libres y privados.

la documentación de la libreria se encuentra en: [sitio jQuery](https://jquery.com/)