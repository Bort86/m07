1) (SERVIDOR) MODIFICACIONS PER OFERIR RESTFUL WS DE CATEGORIAS:

- fitxers nous:
service.php
controller/ws/ServiceMainController.class.php
controller/ws/ServiceCategoryController.class.php


- fitxers modificats:
.htaccess (per reescriure URLs)
model/Category.class.php (afegit interfaz jsonSerialize)
view/CategoryView.class.php (afegit 2 mètodes: display_json, display_json_message)


- explicació de Rewrite Rule en .htaccess

#Per accedir amb URL:
#  http://localhost/mvc_db_service/category 
#o http://localhost/mvc_db_service/category/
#
#quan la nostra aplicació admet:
# a http://localhost/mvc_db_service/service.php?object=category&option=list
#
# Apache treu el prefix (la part que coincideix amb directori o fitxer)
# I aplica el patró sobre l'ultima part: category o category/
# Al patró indiquem que comenci i acabi per category i la barra la marquem opcional
#RewriteRule ^category/?$ service.php?object=category&option=list

# el mateix de forma genérica, serveix per category, producte, user,...
# indiquem que nomes admet lletres i pot estar buit.
# cada part entre paréntesi en un patró, la podem referenciar amb $1,$2,...
RewriteRule ^([a-zA-Z]+)/?$ service.php?object=$1


#reescriu URL:
#   http://localhost/mvc_db_service/category/1 
# o http://localhost/mvc_db_service/category/1/
# a http://localhost/mvc_db_service/service.php?object=category&option=find&id=1

#RewriteRule ^category/1/?$ service.php?object=category&option=find&id=1

# fet de forma genérica (serveix per category, producte, user,...), i per qualsevol id
RewriteRule ^([a-zA-Z_]+)/(([0-9])+)/?$ service.php?object=$1&id=$2



2) (CLIENT) MODIFICACIONS PER CONSUMIR UN RESTFUL WS DE CATEGORIAS:

-fitxers nous:
model/wsclient/CategoryWsDAO.class.php (enviar peticions REST HTTP)
controller/CategoryExtController.class.php (identic al CategoryController.class.php, canviat model)
model/CategoryExtModel.class.php (identic al CategoryModel.class.php, canviat DAO per obtenir dades del WS)

-fitxers modificats:
view/menu/MainMenu.html (afegir una opcio de menu per categ. externes)
controller/MainController.class.php (si menu categ. externes, cridat nou controlador)
