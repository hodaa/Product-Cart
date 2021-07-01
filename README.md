## Product Cart
This is CLI for a cart of products, accepts multiple products, combines offers, and displays a total detailed bill in different currencies (based on user selection).

## Installation
* `cp .env.example .env`

* Put this in your .env

    * TAX=14
    * PRECISION=2
    * CURRENCY=USD
    * DEFAULT_CURRENCY=USD

* `docker-compose up -d`

From PHP image
* `docker-compose exec php bash`
    * `composer install`
    * `php artisan key:generate`



## Usage
php artisan create: cart {currency} {items}

_**ex:**_
* `php artisan create: cart USD jacket shoes jacket t-shirt`
* `php artisan create: cart EGP Pants`



## Testing
From PHP image
* `docker-compose exec php bash`

Run

    vendor/phpunit/bin



##Architecture
* you can  set these value-form .env to be the dynamic overall project
    * TAX=14
    * PRECISION=2 //number of PRECISION you want to view price
    * CURRENCY=USD // if the currency not given
    * DEFAULT_CURRENCY=USD


* If you want  to add a new discount you can go to
  `app/Enums/DiscountPlans` and add the plan number that you will insert in `Offer`
  table when inserting the item and then got to  `app\strategies\DiscountPlans` and implement your new plan.


* if you want to add a new section to the bill like service just go to `app/composite/`
  and your new class and implement interface bill



## Design Pattern Used
1- `Static Factory` pattern to convert plan  Number from DB to the  according class should be implemented

2- `Strategy pattern that I can dynamically implement any discount plan according to plan number from DB

3- `Composite` pattern to composite bill sections dynamically

3- `service` pattern I added all business logic in separate classes each class contains only one responsibility.

## Performance
-
1- I chose to add all currencies and all Opposite symbols in a file in the config you can find it
`config/currencies` as reading from a file will be better than reading from third-party or even DB,Because these currencies rarely changed.

2- I Put an index on `name` column as this will make the query is faster.




## Tools
* PHP7.4
* Laravel
* Docker
* phpunit






    
