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
// It normalizes the final value, that value should be divisible by 5 without remainder
$normalizer = new Math\Normalizer\DefaultNormalizer();

// Default ranges for task, which match the provided task values.
$ranges =[
    12 => [
        1000 => .05,
        2000 => .045,
        3000 => .03,
        4000 => .02875,
        20000 => .02,
    ],
    24 => [
        1000 => .07,
        2000 => .05,
        20000 => .04,
    ]];
?>

```
 

# Installation
To install the app run the command.
```bash
./make
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
