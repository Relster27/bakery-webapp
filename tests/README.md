# Laravel PHP Tests

Sekarang test di project ini disederhanakan menjadi **satu test utama**:

- `tests/Unit/LowStockWatchTest.php`

## Apa yang dites

Test ini memastikan aturan `Low Stock Watch` bekerja saat:

- `quantity_on_hand` tepat sama dengan `reorder_level`

Kalau kondisi itu terpenuhi, inventory dianggap low stock dan akan ikut dipakai oleh dashboard melalui scope model yang sama.

## Kenapa ini dipindah ke `tests/Unit`

Rule low stock sekarang diletakkan di model `Inventory`:

- `scopeAtOrBelowReorderLevel()`
- `isAtOrBelowReorderLevel()`

Jadi test fokus ke aturan bisnis intinya, bukan ke seluruh route/HTML dashboard.

## Cara menjalankan

```powershell
cd D:\SE\final\bakery-webapp
php artisan test --filter=LowStockWatchTest
```

Atau jalankan semua test:

```powershell
php artisan test
```
