
# Roulette test task



## Indices

* [Default](#default)

  * [Player Register](#1-player-register)
  * [Login](#2-login)
  * [Spin](#3-spin)
  * [Rounds Statistic](#4-rounds-statistic)
  * [Players Activity](#5-players-activity)


--------


## Default



### 1. Player Register



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: localhost:8080/api/v1/player/register
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |



***Body:***

```js        
{
	"username": "david",
	"password": 123,
	"firstName": "David",
	"lastName": "Jones"
}
```



### 2. Login



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: localhost:8080/api/v1/login
```


***Headers:***

| Key | Value | Description |
| --- | ------|-------------|
| Content-Type | application/json |  |



***Body:***

```js        
{
	"username": "david",
	"password": 123
}
```



### 3. Spin



***Endpoint:***

```bash
Method: POST
Type: RAW
URL: localhost:8080/api/v1/roulette/spin
```


***Body:***

```js        
{
	"number": 5
}
```



### 4. Rounds Statistic



***Endpoint:***

```bash
Method: GET
Type: RAW
URL: localhost:8080/api/v1/roulette/statistic/rounds
```


### 5. Players Activity



***Endpoint:***

```bash
Method: GET
Type: RAW
URL: localhost:8080/api/v1/roulette/players-activity
```