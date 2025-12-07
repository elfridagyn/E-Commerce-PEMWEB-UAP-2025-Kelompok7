namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class SellerStoreController extends Controller
{
    public function index()
    {
        // cek apakah seller sudah punya toko
        if (auth()->user()->store) {
            return redirect()->back()->with('error', 'Anda sudah memiliki toko');
        }

        return view('seller.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        Store::create([
            'user_id' => auth()->id(),
            'store_name' => $request->store_name,
            'description' => $request->description,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'pending',
        ]);

        return redirect()->route('home')->with('success', 'Toko berhasil diajukan, menunggu verifikasi admin.');
    }
}
