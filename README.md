# Prueba final para competencia en Symfony

Aquí voy a explicar lo que he hecho paso a paso en este examen.

1. Crea un nuevo proyecto de symfony llamado blog.

2. Configura en fichero . env y crea una base de datos llamada blog a través de la línea de comandos.

3. Crear una entidad Artículo con los siguientes atributos:

id
titulo
contenido 3. Crea una entidad Usuario con los siguientes atributos:

id
nombre 4. Crea una entidad Categoria con los siguientes atributos:

id
nombre 5. Crea las siguientes relaciones
Un usuario puede escribir muchos artículos. Todo artículo debe tener asignado un usuario.
Un artículo puede tener muchas categorias. 6. Crea el controlador de Artículos con todas las acciones para el CRUD . Ten en cuenta que cuando se crea un Artículo por debe tener un usuario asigno y por lo menos una categoría.

7. Comprueba con POSTMAN que todo funciona correctamente.

----- OPCIONAL------

8.  Crea el controlador de Categoria con todas las acciones para el CRUD.

9.  Crea el controlador de Usuario con todas las acciones para el CRUD.

## Creación del proyecto

```
composer create-project symfony/skeleton blog
```

## Instalación de paquetes

```
composer require jms/serializer-bundle
composer require friendsofsymfony/rest-bundle
composer require symfony/maker-bundle
composer require symfony/orm-pack
```

## Algunas configuraciones

En la carpeta _config/packages/fos_rest.yaml_ he comentado la línea routing_loader y he descomentado las tres últimas líneas

## El archivo .env

Este archivo lo he añadido al .gitignore y he modificado algunas líneas

he comentado la línea de Postgress y he descomentado la siguiente:

```
DATABASE_URL="mysql://root:@127.0.0.1:3306/blog?serverVersion=8.0.32&charset=utf8mb4"
```

## Creación de la base de datos

Con la configuración anterior y el comando

```
php bin/console doctrine:database:create
```

se ha creado correctamente la base de datos, pudiéndola ver en phpmyadmin

## Creación de entidades

las entidades las he creado con el comando:

```
php bin/console make:entity NombreClase
```

cada una con su nombre de clase correspondiente y en mayúsculas, he creado Articulo, Categoria

y el usuario lo he creado con el comando:

```
php bin/console make:user
```

No me ha dejado, la consola me ha dicho que si quiero hacer esto, tengo que hacer el siguiente comando:

```
composer require security
```

He vuelto a crear el usuario esta vez con éxito.

Como no me deja hacer la modificación de usuario con el mismo comando, he borrado la entidad y el repositorio y he creado una nueva con el comando make:entity para no tener problemas

## Relaciones de tablas

Una vez creadas las 3 entidades, he creado las relaciones, volviendo a utilizar el comando de crear Entity para cada una, añadiendo sus campos.

He creado en Usuario un nuevo campo articulos de tipo OneToMany

He cread en Articulo un nuevo campo categorias de tipo ManyToMany

## Migraciones

Una vez terminadas las relaciones de tablas, he realizado los siguientes comandos para las migraciones:

```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

compruebo que están las relaciones bien hechas en phpMyAdmin

Se ha creado una tabla pivote para articulo_categoria y las relaciones parecen estar hechas correctamente.

## Controladores

Empiezo con el crud de Usuarios y Categorías, función para mostrar todos y para crear uno, así no tengo que tocar la base de datos manualmente
