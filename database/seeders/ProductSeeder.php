<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Mendapatkan ID kategori yang sesuai
        $categories = Category::whereIn('name', [
            'Makanan Cepat Saji',
            'Minuman Soda',
            'Minuman Energi',
            'Minuman Dingin',
            'Ciki - Ciki'
        ])->get()->keyBy('name');

        $products = [
            ['name' => 'Burger', 'detail' => 'Burger dengan daging sapi dan sayuran segar.', 'price' => 30000, 'stock' => 30, 'category' => 'Makanan Cepat Saji', 'image' => 'https://www.pixelstalk.net/wp-content/uploads/2016/08/Fast-food-backgrounds-free-download.jpg'],
            ['name' => 'Hot Dog', 'detail' => 'Hot dog dengan saus dan mustard.', 'price' => 25000, 'stock' => 40, 'category' => 'Makanan Cepat Saji', 'image' => 'https://i.pinimg.com/originals/9e/37/0f/9e370f382275d949d81fb3f94df594c3.jpg'],
            ['name' => 'French Fries', 'detail' => 'Kentang goreng renyah.', 'price' => 15000, 'stock' => 50, 'category' => 'Makanan Cepat Saji', 'image' => 'https://www.pixelstalk.net/wp-content/uploads/2016/08/Fast-food-backgrounds-free-download.jpg'],
            ['name' => 'Soda Cola', 'detail' => 'Minuman bersoda cola.', 'price' => 10000, 'stock' => 60, 'category' => 'Minuman Soda', 'image' => 'https://cdn.idntimes.com/content-images/post/20181025/2017-03-22-post-58d2284515776-750d152134b703d6d260b475ebbaa0ef.jpg'],
            ['name' => 'Orange Soda', 'detail' => 'Minuman bersoda rasa jeruk.', 'price' => 12000, 'stock' => 55, 'category' => 'Minuman Soda', 'image' => 'https://cdn-brilio-net.akamaized.net/news/2018/04/28/142148/769798-1000xauto-5-minuman-dingin.jpg'],
            ['name' => 'Energy Drink', 'detail' => 'Minuman energi untuk menyegarkan badan.', 'price' => 15000, 'stock' => 40, 'category' => 'Minuman Energi', 'image' => 'https://i.pinimg.com/originals/c9/32/d6/c932d6d07e57bdb90530918e94b74ac3.jpg'],
            ['name' => 'Vitamin Water', 'detail' => 'Minuman vitamin dengan rasa buah.', 'price' => 20000, 'stock' => 45, 'category' => 'Minuman Energi', 'image' => 'https://www.diabetes.co.uk/wp-content/uploads/2019/01/iStock-680111050.jpg'],
            ['name' => 'Iced Coffee', 'detail' => 'Kopi dingin dengan es batu.', 'price' => 25000, 'stock' => 30, 'category' => 'Minuman Dingin', 'image' => 'https://www.trippers.id/wp-content/uploads/2020/01/kopi-dingin.jpeg'],
            ['name' => 'Lemonade', 'detail' => 'Minuman lemon dingin.', 'price' => 15000, 'stock' => 50, 'category' => 'Minuman Dingin', 'image' => 'https://cdn-idntimes.com/content-images/community/2018/10/es-kuwut1-784cec59dfe036da16cdeeab4809c742.jpg'],
            ['name' => 'Chips', 'detail' => 'Cemilan keripik gurih.', 'price' => 20000, 'stock' => 35, 'category' => 'Ciki - Ciki', 'image' => 'https://www.travelordietrying.com/wp-content/uploads/2019/11/8.-thai-chicken-green-curry_t20_b8BnNg.jpg'],
            ['name' => 'Candy', 'detail' => 'Permen manis dengan berbagai rasa.', 'price' => 10000, 'stock' => 60, 'category' => 'Ciki - Ciki', 'image' => 'https://www.thespruceeats.com/thmb/GxBFK8FjELXLZdpOx5dB2nDRXUA=/2040x1470/filters:fill(auto,1)/GettyImages-182061573-c99e36ed248a4aabb6bda4e57263fd7d.jpg'],
            ['name' => 'Chocolate Bar', 'detail' => 'Batang coklat dengan rasa kacang.', 'price' => 30000, 'stock' => 50, 'category' => 'Ciki - Ciki', 'image' => 'https://cdn.idntimes.com/content-images/community/2019/05/img-20190506-201911-503f89ccb0e841ecc3d0c51ac99c82be.jpg'],
            ['name' => 'Mie Goreng', 'detail' => 'Mie goreng dengan sayuran.', 'price' => 25000, 'stock' => 45, 'category' => 'Makanan Cepat Saji', 'image' => 'https://i.pinimg.com/originals/95/a7/97/95a797f4a9e75115e16496a973e413f9.jpg'],
            ['name' => 'Fried Chicken', 'detail' => 'Ayam goreng dengan rempah.', 'price' => 35000, 'stock' => 20, 'category' => 'Makanan Cepat Saji', 'image' => 'https://www.travelordietrying.com/wp-content/uploads/2019/11/8.-thai-chicken-green-curry_t20_b8BnNg.jpg'],
            ['name' => 'Coffe Ice Cream', 'detail' => 'Es krim rasa kopi.', 'price' => 20000, 'stock' => 30, 'category' => 'Minuman Dingin', 'image' => 'https://cdn-idntimes.com/content-images/community/2018/10/es-kuwut1-784cec59dfe036da16cdeeab4809c742.jpg'],
            ['name' => 'Green Tea', 'detail' => 'Teh hijau dingin.', 'price' => 15000, 'stock' => 35, 'category' => 'Minuman Dingin', 'image' => 'https://media.suara.com/pictures/653x366/2022/03/24/73731-ilustrasi-minuman-dingin-pexelscom.jpg'],
            ['name' => 'Berry Smoothie', 'detail' => 'Smoothie berry segar.', 'price' => 25000, 'stock' => 40, 'category' => 'Minuman Dingin', 'image' => 'https://cdn-brilio-net.akamaized.net/news/2018/04/28/142148/769799-1000xauto-5-minuman-dingin.jpg'],
            ['name' => 'Fruit Juice', 'detail' => 'Jus buah segar.', 'price' => 18000, 'stock' => 55, 'category' => 'Minuman Dingin', 'image' => 'https://2.bp.blogspot.com/-lXLOHGBHYvc/W2UtQesWOxI/AAAAAAAAAUc/FOrHL4LAOPgIXxo04OfIVqS6Wdtkni6XwCEwYBhgL/s1600/resep-minuman-dingin.png'],
            ['name' => 'Tortilla Chips', 'detail' => 'Keripik tortilla dengan salsa.', 'price' => 22000, 'stock' => 25, 'category' => 'Ciki - Ciki', 'image' => 'https://www.naturefresh.ca/wp-content/uploads/Plate.png'],
            ['name' => 'Snack Mix', 'detail' => 'Campuran berbagai cemilan.', 'price' => 25000, 'stock' => 30, 'category' => 'Ciki - Ciki', 'image' => 'https://static.fanpage.it/wp-content/uploads/sites/22/2020/06/iStock-1155240408.jpg'],
            ['name' => 'Lemon Iced Tea', 'detail' => 'Teh es lemon.', 'price' => 15000, 'stock' => 40, 'category' => 'Minuman Dingin', 'image' => 'https://cdn-idntimes.com/content-images/community/2018/10/es-kuwut1-784cec59dfe036da16cdeeab4809c742.jpg'],
            ['name' => 'Fruit Punch', 'detail' => 'Punch buah segar.', 'price' => 20000, 'stock' => 35, 'category' => 'Minuman Dingin', 'image' => 'https://www.trippers.id/wp-content/uploads/2020/01/kopi-dingin.jpeg'],
            ['name' => 'Energy Booster', 'detail' => 'Minuman energi dengan rasa buah.', 'price' => 22000, 'stock' => 45, 'category' => 'Minuman Energi', 'image' => 'https://cdn-brilio-net.akamaized.net/news/2018/04/28/142148/769798-1000xauto-5-minuman-dingin.jpg'],
            ['name' => 'Ice Lemon Tea', 'detail' => 'Teh lemon dingin dengan es.', 'price' => 17000, 'stock' => 40, 'category' => 'Minuman Dingin', 'image' => 'https://media.suara.com/pictures/653x366/2022/03/24/73731-ilustrasi-minuman-dingin-pexelscom.jpg'],
            ['name' => 'Energy Shot', 'detail' => 'Shot energi kecil.', 'price' => 18000, 'stock' => 50, 'category' => 'Minuman Energi', 'image' => 'https://www.diabetes.co.uk/wp-content/uploads/2019/01/iStock-680111050.jpg'],
            ['name' => 'Coke', 'detail' => 'Minuman cola klasik.', 'price' => 12000, 'stock' => 60, 'category' => 'Minuman Soda', 'image' => 'https://cdn-brilio-net.akamaized.net/news/2018/04/28/142148/769798-1000xauto-5-minuman-dingin.jpg'],
            ['name' => 'Sprite', 'detail' => 'Minuman lemon-lime.', 'price' => 10000, 'stock' => 65, 'category' => 'Minuman Soda', 'image' => 'https://cdn-idntimes.com/content-images/community/2019/05/img-20190506-201919-24f003a99903beee0441afa29b795648.jpg'],
            ['name' => 'Mineral Water', 'detail' => 'Air mineral segar.', 'price' => 8000, 'stock' => 100, 'category' => 'Minuman Dingin', 'image' => 'https://i.pinimg.com/originals/c9/32/d6/c932d6d07e57bdb90530918e94b74ac3.jpg'],
            ['name' => 'Chocolate Chip Cookies', 'detail' => 'Kue coklat chip.', 'price' => 20000, 'stock' => 30, 'category' => 'Ciki - Ciki', 'image' => 'https://cdn-idntimes.com/content-images/community/2019/05/img-20190506-201911-503f89ccb0e841ecc3d0c51ac99c82be.jpg'],
            ['name' => 'Cinnamon Rolls', 'detail' => 'Roti gulung kayu manis.', 'price' => 25000, 'stock' => 25, 'category' => 'Ciki - Ciki', 'image' => 'https://cdn-idntimes.com/content-images/community/2019/05/img-20190506-201916-03d54364744b2bc9e2548f8f280af1f3.jpg'],
            ['name' => 'Gummy Bears', 'detail' => 'Gummy bear dengan berbagai rasa.', 'price' => 12000, 'stock' => 50, 'category' => 'Ciki - Ciki', 'image' => 'https://cdn-idntimes.com/content-images/community/2019/05/img-20190506-201919-24f003a99903beee0441afa29b795648.jpg'],
            ['name' => 'Barbeque Chips', 'detail' => 'Keripik barbeque dengan rasa smoky.', 'price' => 15000, 'stock' => 40, 'category' => 'Ciki - Ciki', 'image' => 'https://cdn-idntimes.com/content-images/community/2019/05/img-20190506-201919-24f003a99903beee0441afa29b795648.jpg'],
            ['name' => 'Cheese Balls', 'detail' => 'Cemilan bola keju.', 'price' => 18000, 'stock' => 35, 'category' => 'Ciki - Ciki', 'image' => 'https://cdn-brilio-net.akamaized.net/news/2018/04/28/142148/769799-1000xauto-5-minuman-dingin.jpg'],
            ['name' => 'Ice Cream Sandwich', 'detail' => 'Sandwich es krim dengan rasa vanila.', 'price' => 22000, 'stock' => 30, 'category' => 'Ciki - Ciki', 'image' => 'https://cdn-idntimes.com/content-images/community/2018/10/es-kuwut1-784cec59dfe036da16cdeeab4809c742.jpg'],
            ['name' => 'Soda Lemon', 'detail' => 'Soda rasa lemon.', 'price' => 13000, 'stock' => 50, 'category' => 'Minuman Soda', 'image' => 'https://cdn-idntimes.com/content-images/community/2019/05/img-20190506-201916-03d54364744b2bc9e2548f8f280af1f3.jpg'],
            ['name' => 'Root Beer', 'detail' => 'Minuman root beer dengan rasa unik.', 'price' => 14000, 'stock' => 45, 'category' => 'Minuman Soda', 'image' => 'https://cdn-idntimes.com/content-images/community/2018/10/es-kuwut1-784cec59dfe036da16cdeeab4809c742.jpg'],
            ['name' => 'Ginger Ale', 'detail' => 'Minuman ginger ale dengan rasa jahe.', 'price' => 16000, 'stock' => 40, 'category' => 'Minuman Soda', 'image' => 'https://cdn-brilio-net.akamaized.net/news/2018/04/28/142148/769798-1000xauto-5-minuman-dingin.jpg'],
            ['name' => 'Smoothie Bowl', 'detail' => 'Smoothie bowl dengan topping granola.', 'price' => 28000, 'stock' => 30, 'category' => 'Minuman Dingin', 'image' => 'https://www.naturefresh.ca/wp-content/uploads/Plate.png'],
            ['name' => 'Milkshake', 'detail' => 'Milkshake dengan rasa coklat.', 'price' => 22000, 'stock' => 35, 'category' => 'Minuman Dingin', 'image' => 'https://i.pinimg.com/originals/95/a7/97/95a797f4a9e75115e16496a973e413f9.jpg'],
            ['name' => 'Cold Brew Coffee', 'detail' => 'Kopi dingin dengan rasa robusta.', 'price' => 27000, 'stock' => 25, 'category' => 'Minuman Dingin', 'image' => 'https://cdn-idntimes.com/content-images/community/2019/05/img-20190506-201911-503f89ccb0e841ecc3d0c51ac99c82be.jpg'],
            ['name' => 'Chocolate Smoothie', 'detail' => 'Smoothie coklat dengan rasa rich.', 'price' => 23000, 'stock' => 40, 'category' => 'Minuman Dingin', 'image' => 'https://cdn-idntimes.com/content-images/community/2018/10/es-kuwut1-784cec59dfe036da16cdeeab4809c742.jpg'],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'detail' => $product['detail'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'category_id' => $categories[$product['category']]->id,
                'image' => $product['image'],
            ]);
        }
    }
}
