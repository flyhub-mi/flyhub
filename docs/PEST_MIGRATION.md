# PHPUnit to Pest Migration Guide

This document outlines the migration from PHPUnit to Pest PHP for the FlyHub application.

## 🚀 What is Pest?

Pest is a testing framework with a focus on simplicity. It was created by Nuno Maduro and is built on top of PHPUnit, providing a more elegant and expressive syntax for writing tests.

## 📋 Migration Overview

### What Changed

1. **Dependencies**: Replaced `phpunit/phpunit` with `pestphp/pest` and related plugins
2. **Configuration**: Replaced `phpunit.xml` with `Pest.php`
3. **Test Syntax**: Converted from class-based tests to functional tests
4. **Scripts**: Updated composer scripts for Pest commands

### Benefits of Pest

- **Cleaner Syntax**: More readable and expressive test code
- **Better Output**: Improved test output with better formatting
- **Parallel Testing**: Built-in support for parallel test execution
- **Laravel Integration**: First-class Laravel support with dedicated plugins
- **Modern PHP**: Takes advantage of modern PHP features

## 🔧 Installation & Setup

### 1. Install Pest Dependencies

```bash
composer require --dev pestphp/pest pestphp/pest-plugin-laravel pestphp/pest-plugin-parallel
```

### 2. Initialize Pest

```bash
./vendor/bin/pest --init
```

### 3. Update Configuration

The `Pest.php` file has been created with the following configuration:

```php
<?php

uses(
    Tests\TestCase::class,
    // Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('tests/Feature');

uses(Tests\TestCase::class)->in('tests/Unit');
```

## 📝 Test Syntax Comparison

### Before (PHPUnit)

```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
    }
}
```

### After (Pest)

```php
<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can be created', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    expect($user)->toHaveKey('name', 'John Doe')
        ->and($user)->toHaveKey('email', 'john@example.com');
});

test('user can login', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
});
```

## 🎯 Key Differences

### 1. Test Functions vs Classes

**PHPUnit**: Class-based with test methods
**Pest**: Functional approach with `test()` function

### 2. Assertions

**PHPUnit**: `$this->assert*()` methods
**Pest**: `expect()` function with fluent API

### 3. Setup and Teardown

**PHPUnit**: `setUp()` and `tearDown()` methods
**Pest**: `beforeEach()` and `afterEach()` functions

### 4. Data Providers

**PHPUnit**: `@dataProvider` annotations
**Pest**: `dataset()` function

## 🛠️ Available Commands

### Basic Commands

```bash
# Run all tests
composer test

# Run tests with coverage
composer test:coverage

# Run tests in parallel
composer test:parallel

# Run specific test file
./vendor/bin/pest tests/Feature/UserTest.php

# Run tests with filter
./vendor/bin/pest --filter="user"

# Run tests in specific directory
./vendor/bin/pest tests/Unit/
```

### Advanced Commands

```bash
# Run tests with verbose output
./vendor/bin/pest --verbose

# Run tests and stop on first failure
./vendor/bin/pest --stop-on-failure

# Run tests with specific group
./vendor/bin/pest --group=api

# Run tests with memory limit
./vendor/bin/pest --memory-limit=512M
```

## 🔄 Migration Process

### Automatic Migration

1. **Run the migration script**:
   ```bash
   php migrate-to-pest.php
   ```

2. **Install Pest dependencies**:
   ```bash
   composer install
   ```

3. **Verify tests pass**:
   ```bash
   composer test
   ```

4. **Clean up**:
   ```bash
   rm migrate-to-pest.php
   rm phpunit.xml
   ```

### Manual Migration Steps

1. **Convert test classes to functions**:
   - Remove class declaration
   - Convert test methods to `test()` functions
   - Update method names to snake_case

2. **Update assertions**:
   - Replace `$this->assert*()` with `expect()`
   - Use Pest's fluent assertion API

3. **Update setup/teardown**:
   - Replace `setUp()` with `beforeEach()`
   - Replace `tearDown()` with `afterEach()`

4. **Update data providers**:
   - Replace `@dataProvider` with `dataset()`

## 📊 Test Organization

### Directory Structure

```
tests/
├── Feature/           # Feature tests
│   ├── Auth/         # Authentication tests
│   ├── Api/          # API tests
│   └── ...
├── Unit/             # Unit tests
│   ├── Models/       # Model tests
│   ├── Services/     # Service tests
│   └── ...
└── Browser/          # Browser tests (Dusk)
```

### Test Naming Convention

- **Feature Tests**: `test_user_can_login.php`
- **Unit Tests**: `test_user_model_validation.php`
- **API Tests**: `test_api_user_endpoints.php`

## 🎨 Pest Features

### 1. Expectations API

```php
test('user has correct attributes', function () {
    $user = User::factory()->create();

    expect($user)
        ->toHaveKey('name')
        ->and($user->name)->toBeString()
        ->and($user->email)->toContain('@');
});
```

### 2. Datasets

```php
dataset('user roles', [
    'admin' => ['admin', true],
    'user' => ['user', false],
]);

test('user has correct permissions', function ($role, $expected) {
    $user = User::factory()->create(['role' => $role]);
    
    expect($user->hasPermission('admin'))->toBe($expected);
})->with('user roles');
```

### 3. Hooks

```php
beforeEach(function () {
    $this->user = User::factory()->create();
});

afterEach(function () {
    User::truncate();
});

test('user can be updated', function () {
    $this->user->update(['name' => 'New Name']);
    
    expect($this->user->fresh()->name)->toBe('New Name');
});
```

### 4. Groups

```php
test('admin can access dashboard', function () {
    // Test implementation
})->group('admin', 'feature');
```

## 🔍 Debugging Tests

### 1. Dump and Die

```php
test('debug test', function () {
    $user = User::factory()->create();
    dump($user->toArray()); // Pest will show this in output
    dd($user); // Stop execution and show data
});
```

### 2. Verbose Output

```bash
./vendor/bin/pest --verbose
```

### 3. Coverage Reports

```bash
composer test:coverage
```

## 🚨 Common Issues & Solutions

### 1. Test Not Found

**Issue**: `No tests found`
**Solution**: Ensure test files end with `Test.php` or use `test()` function

### 2. Class Not Found

**Issue**: `Class 'Tests\TestCase' not found`
**Solution**: Check `Pest.php` configuration and autoloading

### 3. Database Issues

**Issue**: Database connection errors in tests
**Solution**: Ensure `.env.testing` is configured correctly

### 4. Parallel Test Issues

**Issue**: Tests failing in parallel mode
**Solution**: Ensure tests are isolated and don't share state

## 📚 Additional Resources

- [Pest Documentation](https://pestphp.com/docs)
- [Laravel Testing Guide](https://laravel.com/docs/testing)
- [Pest Laravel Plugin](https://pestphp.com/docs/plugins/laravel)

## 🤝 Contributing

When adding new tests:

1. Use Pest syntax
2. Follow naming conventions
3. Add appropriate groups
4. Include data providers when needed
5. Write descriptive test names

## 📈 Performance Benefits

- **Faster Execution**: Pest is generally faster than PHPUnit
- **Parallel Testing**: Run tests in parallel for even better performance
- **Better Output**: Cleaner, more readable test output
- **Memory Efficiency**: Lower memory usage for large test suites

---

*Migration completed on: July 18, 2025* 
