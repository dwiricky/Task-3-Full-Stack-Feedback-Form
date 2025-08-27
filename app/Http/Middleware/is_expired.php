<?php

namespace App\Http\Middleware;

use App\Models\Barang;
use App\Models\Stock;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class is_expired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $cart = session()->get('cart');
            $exp = 60; //interval waktu penambahan barang ke keranjang

            if ($cart) {
                foreach ($cart as $key => $item) {
                    $last = $item['last_updated'];
                    $exp_time = Carbon::parse($last)->addMinutes($exp);

                    if (now()->greaterThan($exp_time)) {
                        $id_barang = $item["id_barang"];
                        $cart_stock = $item["quantity"];

                        // Fetch the 'Barang' instance and its related 'Stock' instance
                        $barang = Barang::findOrFail($id_barang);
                        $stock = $barang->stock;

                        $update_stock = $stock->stock + $cart_stock;

                        // Update the status based on the updated stock value
                        if ($update_stock > 0) {
                            $status = 'Tersedia';
                        } else {
                            $status = 'Habis';
                        }

                        // Update the stock and status in the database
                        $stock->update([
                            'stock' => $update_stock,
                            'status' => $status,
                        ]);

                        // Remove the expired item from the cart
                        unset($cart[$key]);
                    }
                }

                // Save the updated cart back to the session
                session()->put('cart', $cart);
            }
        }
        return $next($request);
    }
}
