# PragmaGO.TECH Interview Test - Fee Calculation - Alternative Solution

## Overview

This project is designed to calculate fees for loans based on the amount and term. It demonstrates the use of OOP concepts, SOLID principles, design patterns, and clean architecture.

## Requirements and rules

- The fee structure does not follow a formula.
- Values in between the breakpoints should be interpolated linearly between the lower bound and upper bound that they fall between.
- The number of breakpoints, their values, or storage might change.
- The term can be either 12 or 24 (number of months), you can also assume values will always be within this set.
- The fee should be rounded up such that fee + loan amount is an exact multiple of 5.
- The minimum amount for a loan is 1,000 PLN, and the maximum is 20,000 PLN.
- You can assume values will always be within this range but they may be any value up to 2 decimal places.

## Project Structure

- **App.php**: The main application entry point.
- **src/**: Contains the main source code.
    - **Contracts/**: Interfaces defining the contracts for various strategies and repositories.
    - **Enums/**: Contains the enumeration types used throughout the application to provide a set of predefined constants.
    - **Factories/**: Factory classes for creating strategy instances.
    - **Models/**: Data models used in the application.
    - **Repositories/**: Implementations of the fee structure repository.
    - **Services/**: Service classes performing core business logic.
    - **Strategies/**: Different strategy implementations for interpolation and rounding.
- **tests/**: Unit tests for various components of the application.

## Installation

No external dependencies or databases are required for this project. Use Composer to install necessary packages.

```bash
composer install
```

## Usage

To calculate the fee for a loan, run the application from the command line with the following syntax:

```bash
php App.php {amount} {term}
```

- `amount`: Loan amount (should be between 1000 and 20000 PLN)
- `term`: Loan term (should be either 12 or 24 months)

Example:

```bash
php App.php 15000 12
```

## Fee Structure

The fee structure varies based on the term (12 or 24 months) and the amount. Interpolation is used for amounts between defined breakpoints.

### Term 12

| Loan amount | Fee    |
|-------------|--------|
| 1000 PLN    | 50 PLN |
| 2000 PLN    | 90 PLN |
| 3000 PLN    | 90 PLN |
| 4000 PLN    | 115 PLN|
| 5000 PLN    | 100 PLN|
| 6000 PLN    | 120 PLN|
| 7000 PLN    | 140 PLN|
| 8000 PLN    | 160 PLN|
| 9000 PLN    | 180 PLN|
| 10000 PLN   | 200 PLN|
| 11000 PLN   | 220 PLN|
| 12000 PLN   | 240 PLN|
| 13000 PLN   | 260 PLN|
| 14000 PLN   | 280 PLN|
| 15000 PLN   | 300 PLN|
| 16000 PLN   | 320 PLN|
| 17000 PLN   | 340 PLN|
| 18000 PLN   | 360 PLN|
| 19000 PLN   | 380 PLN|
| 20000 PLN   | 400 PLN|

### Term 24

| Loan amount | Fee    |
|-------------|--------|
| 1000 PLN    | 70 PLN |
| 2000 PLN    | 100 PLN|
| 3000 PLN    | 120 PLN|
| 4000 PLN    | 160 PLN|
| 5000 PLN    | 200 PLN|
| 6000 PLN    | 240 PLN|
| 7000 PLN    | 280 PLN|
| 8000 PLN    | 320 PLN|
| 9000 PLN    | 360 PLN|
| 10000 PLN   | 400 PLN|
| 11000 PLN   | 440 PLN|
| 12000 PLN   | 480 PLN|
| 13000 PLN   | 520 PLN|
| 14000 PLN   | 560 PLN|
| 15000 PLN   | 600 PLN|
| 16000 PLN   | 640 PLN|
| 17000 PLN   | 680 PLN|
| 18000 PLN   | 720 PLN|
| 19000 PLN   | 760 PLN|
| 20000 PLN   | 800 PLN|

## Testing

Unit tests are provided to verify the functionality of various components. Use PHPUnit to run the tests.

```bash
vendor/bin/phpunit
```

