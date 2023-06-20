# Obtaining an API Token

## Introduction

To access the API provided by the application, developers need to obtain an API token using the OAuth2 authentication server. This document outlines the steps to acquire the token required for authenticating requests to the API.

## Prerequisites

Before proceeding with obtaining the API token, ensure that you have the following:

- Client credentials: client ID and client secret provided by your application's OAuth2 authentication server.
- Scope: The allowed scopes for the client.
- API documentation: Ensure you have access to the documentation specifying the required endpoints and parameters for token acquisition.

## Token Acquisition Steps

To obtain an API token for third-party integration, follow these steps:

### 1. Register the Third-Party Application

To obtain the required client credentials (client ID and client secret), the third-party application needs to be registered with your OAuth2 authentication server. This registration process typically involves providing the application's details, including a redirect URL if necessary.

### 2. Obtain Authorization from the Resource Owner

The third-party application must request authorization from the resource owner (end-user) to access the API on their behalf. This usually involves redirecting the user to the authorization endpoint of your OAuth2 authentication server.

The authorization request URL typically includes parameters such as:

- `response_type`: Set this to "code" to request an authorization code.
- `client_id`: The client ID obtained during registration.
- `redirect_uri`: The redirect URL where the user will be redirected after authorization.
- `scope`: Specify the desired scope of access required by the third-party application.

### 3. Exchange Authorization Code for Access Token

Once the user grants authorization, your OAuth2 authentication server will redirect them back to the third-party application's redirect URL, along with an authorization code. The third-party application must then exchange this authorization code for an access token.

To exchange the authorization code for an access token, make a POST request to the token endpoint of your OAuth2 authentication server. Provide the following parameters in the request:

- `grant_type`: Set this to "authorization_code".
- `client_id`: The client ID obtained during registration.
- `client_secret`: The client secret obtained during registration.
- `redirect_uri`: The redirect URL used during the authorization step.
- `code`: The authorization code received from the previous step.

### 4. Receive the Access Token

Upon successfully exchanging the authorization code, your OAuth2 authentication server will respond with an access token. The response may also include additional details such as the token expiration time, refresh token, and token scope.

### 5. Use the Access Token for API Requests

With the obtained access token, the third-party application can include it in the Authorization header of each API request using the Bearer token scheme. The syntax for including the access token in the request header will depend on the programming language or HTTP client library used by the third-party application.

Example Request:
```code
GET /api/endpoint Host: demo.localhost Authorization: Bearer {access_token}
```

# API Documentation: Consuming Brands, Products, and Customers Resources

## Introduction

This API documentation details how to consume the Brands, Products, and Customers resources provided by the application. These resources support the CRUD operations, allowing you to list, show, create, update, and delete data.

## Base URL

The base URL for accessing the API endpoints is: `https://api.example.com`

## Authentication

All requests to the API endpoints require authentication. Please refer to the "Obtaining an API Token for Third-Party Integration" section in the API documentation for instructions on obtaining an access token.

Include the access token in the `Authorization` header of each request using the Bearer token scheme:

```code
Authorization: Bearer {access_token}
```


## Brands Resource

### List Brands

Endpoint: `GET /api/brands`

Retrieve a list of all brands.

#### Query Parameters
-   `page[size]` (optional): Limit per page on the brand list.
-   `page[number]` (optional): get a page from the brand list.

### Show Brand

Endpoint: `GET /api/brands/{id}`

Retrieve details of a specific brand identified by its `id`.

### Create Brand

Endpoint: `POST /api/brands`

Create a new brand by providing the necessary data in the request body. 
The following validation rules apply to the request parameters: 
-  `name` (required): The name of the brand. 
-  `slug` (required, unique): The slug of the brand. It must be unique among all brands in the system. 
-  `website` (optional): The website URL of the brand. 
-  `description` (optional): The description of the brand. 
-  `position` (required, numeric): The brand's position. 
-  `is_visible` (required, boolean): Indicates whether the brand is visible. 
-  `seo_title` (optional): The SEO title of the brand. 
-  `seo_description` (optional): The SEO description of the brand. 
-  `sort` (optional, numeric): The sort order of the brand. 

Example Request:

```code
POST /api/brands Authorization: Bearer {access_token} Content-Type: application/json

{ 
	"name": "Example Brand", 
	"slug": "example-brand", 
	"website": "https://example.com", 
	"description": "This is an example brand", 
	"position": 1, 
	"is_visible": true, 
	"seo_title": "Example Brand - Best Products", 
	"seo_description": "Discover the best products from Example Brand", 
	"sort": 10 
}
```

Example Response:

```code
HTTP/1.1 200 OK Content-Type: application/json

{ 
	"data": { 
		"id": 123, 
		"name": "Example Brand", 
		"slug": "example-brand", 
		"website": "https://example.com", 
		"description": "This is an example brand", 
		"position": 1, 
		"is_visible": true, 
		"seo_title": "Example Brand - Best Products", 
		"seo_description": "Discover the best products from Example Brand", 	
		"sort": 10, 
		"created_at": "2023-06-21T12:00:00Z", 
		"updated_at": "2023-06-21T12:00:00Z" 
	} 
}
```

### Update Brand

Endpoint: `PUT /api/brands/{id}`

Update the details of a specific brand identified by its `id`. Provide the updated data in the request body.

-  `name` (optional): The name of the brand. 
-  `slug` (optional, unique): The slug of the brand. It must be unique among all brands in the system, except for the current brand being updated. 
-  `website` (optional): The website URL of the brand. 
-  `description` (optional): The description of the brand. 
-  `position` (optional, numeric): The position of the brand. 
-  `is_visible` (optional, boolean): Indicates whether the brand is visible. 
-  `seo_title` (optional): The SEO title of the brand.
-  `seo_description` (optional): The SEO description of the brand. 
-  `sort` (optional, numeric): The sort order of the brand.

Example Request:
```code
PUT /api/brands/{id} Authorization: Bearer {access_token} Content-Type: application/json

{ 
	"name": "Updated Brand Name", 
	"slug": "updated-brand", 
	"website": "https://updatedexample.com", 
	"description": "This is an updated brand", 
	"position": 2, 
	"is_visible": false, 
	"seo_title": "Updated Brand - New Products", 
	"seo_description": "Discover the new products from Updated Brand", 
	"sort": 20 
}
```


Example Response:
```code
HTTP/1.1 200 OK Content-Type: application/json

{ 
	"data": { 
		"id": 123, 
		"name": "Updated Brand Name", 
		"slug": "updated-brand", 
		"website": "https://updatedexample.com", 
		"description": "This is an updated brand", 
		"position": 2, 
		"is_visible": false, 
		"seo_title": "Updated Brand - New Products", 
		"seo_description": "Discover the new products from Updated Brand", 
		"sort": 20, 
		"created_at": "2023-06-21T12:00:00Z", 
		"updated_at": "2023-06-21T12:00:00Z" 
	}
}
```

### Delete Brand

Endpoint: `DELETE /api/brands/{id}`

Delete a specific brand identified by its `id`.

Example Request:
```code
DELETE /brands/{id} Host: api.example.com Authorization: Bearer {access_token}
```

Example Response:
```code
HTTP/1.1 204 No Content
```


## Products Resource

### List Products

Endpoint: `GET /products`

Retrieve a list of all products.

#### Query Parameters

-   `page[size]` (optional): Limit per page on the product list.
-   `page[number]` (optional): get a page from the product list.

### Show Product

Endpoint: `GET /products/{id}`

Retrieve details of a specific product identified by its `id`.

### Create Product

Endpoint: `POST /api/products`

Create a new product by providing the necessary data in the request body.

-  `name` (required): The name of the product.
-  `shop_brand_id` (exists:shop_brands, id): The ID of the associated brand. The brand must exist in the system. 
- `slug` (required, unique): The slug of the product. It must be unique among all products in the system.
-  `sku` (unique, nullable): The product's SKU (stock-keeping unit). It must be unique among all products in the system or nullable.
-  `barcode` (unique, nullable): The product's barcode. It must be unique among all products in the system or nullable. 
-  `description` (optional): The description of the product. 
-  `qty` (required, numeric): The quantity of the product. 
-  `security_stock` (required, numeric): The security stock of the product. 
-  `featured` (required, boolean): Indicates whether the product is featured. 
-  `is_visible` (required, boolean): Indicates whether the product is visible.
-  `seo_title` (optional): The SEO title of the product. 
-  `seo_description` (optional): The SEO description of the product. 
-  `sort` (optional, numeric): The sort order of the product. 
-  `old_price` (optional, numeric): The old price of the product. 
- `price` (optional, numeric): The product's price. 
- `cost` (optional, numeric): The cost of the product.
- `type` (optional, in deliverable, downloadable): The product type. 
- `published_at` (optional, date): The publish date of the product.
- `weight_value` (optional, numeric): The weight value of the product.
- `weight_unit` (optional): The weight unit of the product.
- `height_value` (optional, numeric): The height value of the product.
- `height_unit` (optional): The height unit of the product.
- `width_value` (optional, numeric): The width value of the product.
- `width_unit` (optional): The width unit of the product. 
- `depth_value` (optional, numeric): The depth value of the product. 
- `depth_unit` (optional): The depth unit of the product. 
- `volume_value` (optional, numeric): The volume value of the product. 
- `volume_unit` (optional): The volume unit of the product.

Example Request:
```code
POST /products Host: api.example.com Authorization: Bearer {access_token} Content-Type: application/json

{ 
	"name": "New Product", 
	"shop_brand_id": 123, 
	"slug": "new-product", 
	"sku": "SKU123", 
	"barcode": "BARCODE123", 
	"description": "This is a new product", 
	"qty": 10, 
	"security_stock": 5, 
	"featured": true, 
	"is_visible": true, 
	"seo_title": "New Product - Amazing Features", 
	"seo_description": "Discover the amazing features of our new product", 
	"sort": 10, 
	"old_price": 100.0, 
	"price": 80.0, 
	"cost": 60.0, 
	"type": "deliverable", 
	"published_at": "2023-06-21", 
	"weight_value": 1.5, 
	"weight_unit": "kg", 
	"height_value": 10.0, 
	"height_unit": "cm", 
	"width_value": 5.0, 
	"width_unit": "cm", 
	"depth_value": 15.0, 
	"depth_unit": "cm", 
	"volume_value": 750.0, 
	"volume_unit": "ml" 
}
```


Example Response:

```code
HTTP/1.1 201 Created Content-Type: application/json

{
   "data":{
      "id":123,
      "name":"New Product",
      "shop_brand_id":123,
      "slug":"new-product",
      "sku":"SKU123",
      "barcode":"BARCODE123",
      "description":"This is a new product",
      "qty":10,
      "security_stock":5,
      "featured":true,
      "is_visible":true,
      "seo_title":"New Product - Amazing Features",
      "seo_description":"Discover the amazing features of our new product",
      "sort":10,
      "old_price":100.0,
      "price":80.0,
      "cost":60.0,
      "type":"deliverable",
      "published_at":"2023-06-21T00:00:00Z",
      "weight_value":1.5,
      "weight_unit":"kg",
      "height_value":10.0,
      "height_unit":"cm",
      "width_value":5.0,
      "width_unit":"cm",
      "depth_value":15.0,
      "depth_unit":"cm",
      "volume_value":750.0,
      "volume_unit":"ml",
      "created_at":"2023-06-21T12:00:00Z",
      "updated_at":"2023-06-21T12:00:00Z"
   }
}
```


### Update Product

Endpoint: `PUT /products/{id}`

Update the details of a specific product identified by its `id`. Provide the updated data in the request body.

-  `name` (required): The name of the product.
-  `shop_brand_id` (exists:shop_brands, id): The ID of the associated brand. The brand must exist in the system.
-  `slug` (sometimes, unique): The slug of the product. It must be unique among all products in the system, except for the current product being updated.
-  `sku` (sometimes, unique): The SKU (stock-keeping unit) of the product. It must be unique among all products in the system, except for the current product being updated.
-  `barcode` (sometimes, unique): The product's barcode. It must be unique among all products in the system, except for the current product being updated.
-  `description` (sometimes): The description of the product.
-  `qty` (required, numeric): The quantity of the product.
-  `security_stock` (required, numeric): The security stock of the product.
-  `featured` (required, boolean): Indicates whether the product is featured.
-  `is_visible` (required, boolean): Indicates whether the product is visible.
-  `seo_title` (sometimes): The SEO title of the product.
-  `seo_description` (sometimes): The SEO description of the product.
-  `sort` (sometimes, numeric): The sort order of the product.
-  `old_price` (sometimes, numeric): The old price of the product.
-  `price` (sometimes, numeric): The product's price.
-  `cost` (sometimes, numeric): The cost of the product.
-  `type` (sometimes, in:deliverable,downloadable): The product type.
-  `published_at` (sometimes, date): The publish date of the product.
-  `weight_value` (sometimes, numeric): The weight value of the product.
-  `weight_unit` (sometimes): The weight unit of the product.
-  `height_value` (sometimes, numeric): The height value of the product.
-  `height_unit` (sometimes): The height unit of the product.
-  `width_value` (sometimes, numeric): The width value of the product.
-  `width_unit` (sometimes): The width unit of the product.
-  `depth_value` (sometimes, numeric): The depth value of the product.
-  `depth_unit` (sometimes): The depth unit of the product.
-  `volume_value` (sometimes, numeric): The volume value of the product.
-  `volume_unit` (sometimes): The volume unit of the product.

Example Request:
```code
PUT /api/products/123 Authorization: Bearer {access_token} Content-Type: application/json

{ 
	"name": "Updated Product", 
	"description": "Updated product description", 
	"price": 90.0 
}

```


Example Response:

```code
HTTP/1.1 200 OK Content-Type: application/json

{
   "data":{
      "id":123,
      "name":"Updated Product",
      "shop_brand_id":123,
      "slug":"new-product",
      "sku":"SKU123",
      "barcode":"BARCODE123",
      "description":"Updated product description",
      "qty":10,
      "security_stock":5,
      "featured":true,
      "is_visible":true,
      "seo_title":"New Product - Amazing Features",
      "seo_description":"Discover the amazing features of our new product",
      "sort":10,
      "old_price":100.0,
      "price":90.0,
      "cost":60.0,
      "type":"deliverable",
      "published_at":"2023-06-21T00:00:00Z",
      "weight_value":1.5,
      "weight_unit":"kg",
      "height_value":10.0,
      "height_unit":"cm",
      "width_value":5.0,
      "width_unit":"cm",
      "depth_value":15.0,
      "depth_unit":"cm",
      "volume_value":750.0,
      "volume_unit":"ml",
      "created_at":"2023-06-21T12:00:00Z",
      "updated_at":"2023-06-21T13:00:00Z"
   }
}
```

### Delete Product

Endpoint: `DELETE /products/{id}`

Delete a specific product identified by its `id`.

Example Request:
```code
DELETE /products/123 Host: api.example.com Authorization: Bearer {access_token}
```


Example Response:
```code
HTTP/1.1 204 No Content
```

## Customers Resource

### List Customers

Endpoint: `GET /customers`

#### Query Parameters

-   `filter[name]` (optional): Filter the list of customers by name.
-   `page[size]` (optional): Limit per page on the customer list.
-   `page[number]` (optional): get a page from the customer list.

Retrieve a list of all customers or search for customers by name or email.

Example request;

```code
GET /customers?filter[name]=John&page[size]=4
Authorization: Bearer {access_token}
```

### Show Customer

Endpoint: `GET /customers/{id}`

Retrieve details of a specific customer identified by their `id`.

### Create Customer

Endpoint: `POST /customers`

Create a new customer by providing the necessary data in the request body. The following validation rules apply to the request parameters:

- `name` (required): The name of the customer.
- `email` (required, unique): The customer's email address. It must be unique among all customers in the system.
- `photo` (image): An optional image file representing the customer's photo.
- `gender` (required, enum): The gender of the customer. It must be either "male" or "female".
- `phone` (required): The customer's phone number.
- `birthday` (required, date, format: Y-m-d): The customer's birthday. It must be in the format "YYYY-MM-DD".

Example Request:

```code
POST /api/customers Authorization: Bearer {access_token} Content-Type: application/json

{ 	
	"name": "John Doe", 
	"email": "johndoe@example.com", 
	"photo": [image file], 
	"gender": "male", 
	"phone": "1234567890", 
	"birthday": "1990-01-01"
}
```


Example Response:

```code
HTTP/1.1 200 OK Content-Type: application/json

{ 
	"data": { 
		"id": 123, 
		"name": "John Doe", 
		"email": "johndoe@example.com", 
		"photo_url": "https://example.com/uploads/johndoe.jpg", 
		"gender": "male", 
		"phone": "1234567890", 
		"birthday": "1990-01-01", 
		"created_at": "2023-06-21T12:00:00Z", 
		"updated_at": "2023-06-21T12:00:00Z" 
	} 
}
```


### Update Customer

Endpoint: `PUT /api/customers/{id}`

Update the details of a specific customer identified by their `id`. Provide the updated data in the request body. The following validation rules apply to the request parameters:

- `name` (optional): The name of the customer.
- `email` (optional, unique): The customer's email address. It must be unique among all customers in the system, except for the current customer being updated.
- `photo` (optional, image): An optional image file representing the customer's photo.
- `gender` (optional, enum): The gender of the customer. It must be either "male" or "female".
- `phone` (optional): The customer's phone number.
- `birthday` (optional, date, format: Y-m-d): The customer's birthday. It must be in the format "YYYY-MM-DD".

Example Request:

```code
PUT /api/customers/{id} Authorization: Bearer {access_token} Content-Type: application/json

{ 
	"name": "John Doe", 
	"email": "johndoe@example.com", 
	"photo": [image file], 
	"gender": "male", 
	"phone": "1234567890", 
	"birthday": "1990-01-01"
}
```


Example Response:

```code
HTTP/1.1 200 OK Content-Type: application/json

{ 
	"data": { 
		"id": 123, 
		"name": "John Doe", 
		"email": "johndoe@example.com", 
		"photo_url": "https://example.com/uploads/johndoe.jpg", 
		"gender": "male", 
		"phone": "1234567890", 
		"birthday": "1990-01-01", 
		"created_at": "2023-06-21T12:00:00Z", 
		"updated_at": "2023-06-21T12:00:00Z" 
	} 
}
```


### Delete Customer

Endpoint: `DELETE /customers/{id}`

Delete a specific customer identified by their `id`.

Example Request:
```code
DELETE /api/customers/{id} Authorization: Bearer {access_token}
```


Example Response:
```code
HTTP/1.1 204 No Content
```

Please ensure to incorporate the provided validation rules into your application's code and adjust the documentation as necessary based on your implementation.


Please let me know if you need any further assistance!