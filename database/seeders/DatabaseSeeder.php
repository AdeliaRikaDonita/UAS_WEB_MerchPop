<?php

namespace Database\Seeders;

use App\Models\PhotoCard;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin MerchPopRika',
            'email' => 'admin@merchpoprika.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buyer contoh
        $buyer = User::create([
            'name' => 'Rika Kolektor',
            'email' => 'buyer@merchpoprika.test',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '081234567890',
            'address' => 'Jl. Melati No. 10, Banjarbaru, Kalimantan Selatan',
        ]);

        // Seller 1 + toko + photocard
        $seller1 = User::create([
            'name' => 'Dinda Trader',
            'email' => 'seller1@merchpoprika.test',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '081211112222',
        ]);

        $store1 = Store::create([
            'user_id' => $seller1->id,
            'name' => 'binderbias.id',
            'slug' => 'binderbias-id-'.Str::random(4),
            'description' => 'Official photocard trader terpercaya sejak 2021. Semua item dijamin original.',
            'address' => 'Banjarbaru, Kalimantan Selatan',
            'phone' => '081211112222',
        ]);

        $cardsBinder = [
            ['name' => 'Hanni ver. B', 'category' => 'NewJeans — Get Up', 'price' => 210000, 'stock' => 3, 'condition' => 'Near Mint'],
            ['name' => 'Karina Armageddon ver.', 'category' => 'aespa — Armageddon', 'price' => 90000, 'stock' => 8, 'condition' => 'Mint'],
            ['name' => 'Sohee ver.', 'category' => 'RIIZE — Unveil', 'price' => 85000, 'stock' => 12, 'condition' => 'Mint'],
            ['name' => 'Wonyoung ver.', 'category' => "IVE — I've Mine", 'price' => 70000, 'stock' => 15, 'condition' => 'Sealed'],
            ['name' => 'Chaewon Easy ver.', 'category' => 'LE SSERAFIM — Easy', 'price' => 78000, 'stock' => 10, 'condition' => 'Mint'],
        ];

        foreach ($cardsBinder as $c) {
            PhotoCard::create([
                'store_id' => $store1->id,
                'name' => $c['name'],
                'slug' => Str::slug($c['name']).'-'.Str::random(4),
                'description' => 'Photocard official dari album resmi, kondisi sesuai deskripsi, dibungkus toploader + sleeve.',
                'price' => $c['price'],
                'stock' => $c['stock'],
                'category' => $c['category'],
                'condition' => $c['condition'],
            ]);
        }

        // Seller 2 + toko + photocard
        $seller2 = User::create([
            'name' => 'Alya Fansite',
            'email' => 'seller2@merchpoprika.test',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '081233334444',
        ]);

        $store2 = Store::create([
            'user_id' => $seller2->id,
            'name' => 'holo.trade',
            'slug' => 'holo-trade-'.Str::random(4),
            'description' => 'Spesialis fansign photocard & merch limited edition.',
            'address' => 'Banjarmasin, Kalimantan Selatan',
            'phone' => '081233334444',
        ]);

        $cardsHolo = [
            ['name' => 'Felix ATE ver.', 'category' => 'Stray Kids — ATE', 'price' => 95000, 'stock' => 6, 'condition' => 'Mint'],
            ['name' => 'Mingyu Fansign ver.', 'category' => 'SEVENTEEN — 17 Is Right Here', 'price' => 180000, 'stock' => 2, 'condition' => 'Near Mint'],
            ['name' => 'Yeonjun ver.', 'category' => 'TXT — The Star Chapter', 'price' => 65000, 'stock' => 20, 'condition' => 'Sealed'],
            ['name' => 'Jennie Born Pink ver.', 'category' => 'BLACKPINK — Born Pink', 'price' => 250000, 'stock' => 4, 'condition' => 'Near Mint'],
        ];

        foreach ($cardsHolo as $c) {
            PhotoCard::create([
                'store_id' => $store2->id,
                'name' => $c['name'],
                'slug' => Str::slug($c['name']).'-'.Str::random(4),
                'description' => 'Diperoleh langsung dari event fansign resmi, disertai proof unboxing.',
                'price' => $c['price'],
                'stock' => $c['stock'],
                'category' => $c['category'],
                'condition' => $c['condition'],
            ]);
        }
    }
}
