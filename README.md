Fee Calculation
=====

This app calculates the fee for passed `term` and `amount`.
The default configuration uses the following configuration:
```php
<?php
// Default interpolator
// It interpolates the needed value linearly between 2 points (x0,y0) and (x1,y1) 
$interpolator = new \Math\Interpolator\LinearInterpolator();

// Default normalizer
// It normalizes the final fee, that fee + amount will be divisible by 5 without reminder
$normalizer = new Math\Normalizer\DefaultNormalizer();

// Default ranges for task, which match the provided task values.
$ranges =[
    12 => [
        1000 => 50,
        2000 => 90,
        3000 => 90,
        4000 => 115,
        5000 => 100,
        20000 => 400,
    ],
    24 => [
        1000 => 70,
        2000 => 100,
        3000 => 120,
        20000 => 800,
    ]];
?>

```
 

# Installation
To install the app run the command.
```bash
git clone git@github.com:wtorsi/fee-calculator.git && cd fee-calculator && ./make
``` 

# Run
To run the app use the following syntax.
```bash
./bin/run $term $amount
``` 

Or if you want to use default dataset.
```bash
./bin/run < ./var/data.txt
``` 

# Test

To run all tests, just run the command.

```bash
./test
``` 
