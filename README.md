<h1>Vending Machine</h1>
<p>
    💻 Vending Machine PoC as a DDD and CQRS php project.
</p>

<h2>Instructions</h2>
<p>
You will need Docker and docker compose installed.
If you are a user of mac m1, don't worry, the docker compose file is addapted to this architecture.
To have the enviroment running do:
</p>

1. `make start`: will build all what is necessary for you. Just keep the port 3306 free and open
1. `make deps`: will install all the vendors dependencies
1. `make test`: will execute the unit tests of teh project
1. `make init-db`: will setup the db for the first operations.

<h2>Usage:</h2>
To use the machine you can either exec the symfony console as
`php app/apps/vending/backend/bin/console vending:machine:use` or log into the docker container and exec `vending vending:machine:use`

<h2>Vending Machine instructions:</h2>

<h3>Normal operation:</h3>
As a user you can perform different actions with the vending machine. Each action should be execute one by one.
<br>

<h4>Actions:</h4>
1. Insert Coins: insert `1.00` as 1 unit coin, `0.25`, `0.10` or `0.05` to increase your available money. No other coins are valid.
 After each coin hit *enter*. Example: `1.00`.

2. `RETURN-COINS`: type this command and hit enter. You will get your money back.
3. `GET-XXXX`: use your current money to purchase the item from the command. Valid items are: `WATER, JUICE, SODA`.
<br>Example: `GET-WATER`.

4. `exit`: Type this command to leave.

<h3>Service mode:</h3>
If you type `SERVICE` you will enter the service mode. The operation actions are:

1. `SET-COINS`: Set the amount of coins of a given value. Example: `SET-COINS, 1.00, 400` Will set 400 units of 1.00 coin.

1. `SET-XXXX`: Set the current item stock.<br> Example: `SET-WATER, 300` will set water stock to 300 units

