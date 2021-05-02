# eArc-resource-api

rest-api -> handles earc/data entities + routing

GET 	rest-end-point/namespace/product?template=json   Retrieve the (paginated) collection as json
GET 	rest-end-point/namespace/product?template={id}   Retrieve the (paginated) collection interpreted via an earc template
GET 	rest-end-point/namespace/product/-/{pk}?template=json   Retrieve a product as json
GET 	rest-end-point/namespace/product/-/{pk}?template={id}   Retrieve a product interpreted via an earc template

POST 	rest-end-point/namespace/product 	                    Create a new product
POST 	rest-end-point/namespace/product?template=json 	        Create a new product and returns it as json
POST 	rest-end-point/namespace/product?template={id} 	        Create a new product and returns it interpreted via an earc template
PUT 	rest-end-point/namespace/product/-/{pk} 	            Update a product
PUT 	rest-end-point/namespace/product/-/{pk}?template=json 	Update a product and returns it as json
PUT 	rest-end-point/namespace/product/-/{pk}?template={id} 	Update a product and returns it interpreted via an earc template
PATCH 	rest-end-point/namespace/product/-/{pk} 	            Apply a partial modification to a product
PATCH 	rest-end-point/namespace/product/-/{pk}?template=json 	Apply a partial modification to a product and returns it as json
PATCH 	rest-end-point/namespace/product/-/{pk}?template={id} 	Apply a partial modification to a product and returns it interpreted via an earc template
DELETE 	rest-end-point/namespace/product/-/{pk} 	            Delete a product
DELETE 	rest-end-point/namespace/product/-/{pk}?template=json 	Delete a product and returns all products as json
DELETE 	rest-end-point/namespace/product/-/{pk}?template={id} 	Delete a product and returns all products interpreted via an earc template

