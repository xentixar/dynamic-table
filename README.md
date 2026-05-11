# Dynamic Table

`xentixar/dynamic-table` is a Filament package that adds dynamic table behavior.

## Features

- Adds `Table::liveSelection()` macro for reactive selection syncing.
- Supports optional Livewire callback method execution on selection changes.

## Requirements

- PHP 8.2+
- Filament Tables `^5.0`
- Illuminate Support `^13.0`

## Installation

Install with Composer:

```bash
composer require xentixar/dynamic-table
```

The package uses Laravel package discovery, so the service provider is auto-registered.

## Quick Start

Apply `liveSelection()` on your table definition:

```php
use Filament\Tables\Table;

public static function table(Table $table): Table
{
    return $table
        ->liveSelection();
}
```

## Usage

### 1) Basic usage

```php
public static function table(Table $table): Table
{
    return $table->liveSelection();
}
```

### 2) Conditional enable/disable

```php
public static function table(Table $table): Table
{
    return $table->liveSelection(
        condition: auth()->user()?->can('bulkSelectUsers') ?? false,
    );
}
```

### 3) Use custom Livewire property

```php
public static function table(Table $table): Table
{
    return $table->liveSelection(
        livewireProperty: 'selectedUsers',
    );
}
```

### 4) Trigger a Livewire method on selection change

```php
public static function table(Table $table): Table
{
    return $table->liveSelection(
        livewireMethod: 'onSelectionChanged',
    );
}

public function onSelectionChanged(
    array $selectedRecords,
    array $deselectedRecords,
    bool $isTrackingDeselectedRecords,
): void {
    // Your logic here
}
```

If `livewireMethod` is not provided, the component refreshes automatically.

## API Reference

- `condition` (`bool`, default: `true`)
  - Enable or disable live selection behavior.
- `livewireProperty` (`string`, default: `selectedTableRecords`)
  - Livewire property used for current selection state.
- `livewireMethod` (`?string`, default: `null`)
  - Optional Livewire method called when selection changes.
  - Receives `(array $selectedRecords, array $deselectedRecords, bool $isTrackingDeselectedRecords)`.

## Troubleshooting

- `Method liveSelection does not exist`:
  - Run `composer dump-autoload` and clear app caches (`php artisan optimize:clear`).
- Callback not firing:
  - Ensure the method name in `livewireMethod` matches exactly and is `public`.
- Selection state not where expected:
  - Verify the `livewireProperty` name matches your component property.

## License

MIT

See [LICENSE](LICENSE) for full text.
