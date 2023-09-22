# Football World Cup Score Board
Simple test library 

# How to use
Implements Service
```php
$scoreBoard = new ScoreBoard();
```
next add games
```php
$scoreBoard->addGame(new Team('Mexico'), new Team('Canada'));
$scoreBoard->addGame(new Team('Spain'), new Team('Brazil'));
```
and upload score 
```php
$scoreBoard->uploadScore(new Team('Mexico'), new Team('Canada'), 1, 2);
$scoreBoard->uploadScore(new Team('Mexico'), new Team('Canada'), 2, 2);
```
If You want to set the result lover than the current. This library return exception. Example:  
* From Mexico `1` - Canada `2`
* To Mexico `0` - Canada `2`

Default start score is `0` to `0` so we can't go to down to negative values.


# Test example
```shell
composer install
composer test
```
