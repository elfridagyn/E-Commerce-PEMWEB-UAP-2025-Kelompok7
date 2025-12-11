use App\Models\ShippingType;
use Illuminate\Database\Seeder;

class ShippingTypeSeeder extends Seeder
{
    public function run(): void
{
    \App\Models\ShippingType::insert([
        [
            'name' => 'Reguler',
            'estimate' => '2 - 4 hari',
            'cost' => 9000,
        ],
        [
            'name' => 'Kargo',
            'estimate' => '3 - 7 hari',
            'cost' => 15000,
        ],
        [
            'name' => 'Instant',
            'estimate' => '1 hari',
            'cost' => 20000,
        ],
    ]);
}

}
