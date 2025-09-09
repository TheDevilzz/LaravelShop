<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\product;
use App\Models\cart;
use App\Models\historyorder;
use App\Models\User;

class products extends Controller
{
    function index(){
        $products = product::paginate(50);
        return view('welcome', compact('products'));
    }
    public function cart(){
        if (!auth()->check()) {
            return redirect('/login');
        }
        $cart = Cart::with('product')->where('userID', auth()->id())->get();

        return view('cart', compact('cart'));
    }
    public function addCart(Request $request, $id)
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    $cart = Cart::where('userID', auth()->id())
                ->where('ProductID', $id)
                ->first();

    if ($cart) {
        
        $data = [
            'CartQuantity' => $cart->CartQuantity + 1,
            'updated_at' => now(),
        ];
        Cart::where('id', $cart->id)->update($data);
    } else {
        
        $data = [
            'userID' => auth()->id(),
            'ProductID' => $id,
            'CartQuantity' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        Cart::insert($data);
    }

    return redirect()->route('cart');
}
    public function deleteCart($id){
        if (!auth()->check()) {
            return redirect('/login');
        }
        $cart = Cart::where('id', $id)->first();
        Cart::where('id', $id)->delete();
        return redirect()->route('cart');
    }

    public function pluscart($id){
        if (!auth()->check()) {
            return redirect('/login');
        }
        $cart = Cart::where('id', $id)->first();
        if ($cart->CartQuantity == $cart->product->ProductQuantity) {
            return redirect()->route('cart');
        }else{
            $cart->CartQuantity = $cart->CartQuantity + 1;
            Cart::where('id', $id)->update(['CartQuantity' => $cart->CartQuantity]);
            return redirect()->route('cart');
        }
        
    }
    public function minuscart($id){
        if (!auth()->check()) {
            return redirect('/login');
        }
        $cart = Cart::where('id', $id)->first();
        if ($cart->CartQuantity <= 0) {
            return redirect()->route('deleteCart', $id);
        }else{
            $cart->CartQuantity = $cart->CartQuantity - 1;
            Cart::where('id', $id)->update(['CartQuantity' => $cart->CartQuantity]);
            return redirect()->route('cart');
        }
        
    }
    public function checkout(Request $request)
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    $request->validate([
        'address'     => 'required',
        'city'        => 'required',
        'postcode'    => 'required',
        'country'     => 'required',
    ]);

    $cart = Cart::with('product')->where('userID', auth()->id())->get();

    foreach ($cart as $item) {
        if ($item->CartQuantity > $item->product->ProductQuantity) {
            return redirect()->route('cart')
                             ->with('error', 'Product ' . $item->product->ProductName . ' out of stock!');
        }
    }

    $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->postcode . ', ' . $request->country;

    $productList = $cart->map(function($item) {
        return [
            'ProductID'       => $item->ProductID,
            'ProductName'     => $item->product->ProductName,
            'CartQuantity'    => $item->CartQuantity,
            'ProductPrice'    => $item->product->ProductPrice,
        ];
    });

    $data = [
        'userID'      => auth()->id(),
        'username'    => auth()->user()->username,
        'Address'     => $fullAddress,
        'ProductList' => json_encode($productList), 
        'status'      => 'pending',
        'TotalPrice'  => $request->TotalPrice,
    ];

    historyorder::insert($data);

    foreach ($cart as $item) {
        $item->product->ProductQuantity -= $item->CartQuantity;
        Product::where('id', $item->ProductID)
               ->update(['ProductQuantity' => $item->product->ProductQuantity]);
    }

    Cart::where('userID', auth()->id())->delete();

    return redirect()->route('cart')->with('success', 'Order placed successfully!');
}

    public function productdetail($id){
        $product = product::where('id', $id)->first();
        return view('productdetail', compact('product'));
    }
    public function addCarts(Request $request, $id)
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    $quantity = $request->inputQuantity ?? 1; // default 1
    $cart = Cart::where('userID', auth()->id())
                ->where('ProductID', $id)
                ->first();

    if ($cart) {
        $cart->CartQuantity += $quantity;
        $cart->updated_at = now();
        $cart->save();
    } else {
        Cart::insert([
            'userID' => auth()->id(),
            'ProductID' => $id,
            'CartQuantity' => $quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->route('cart');
}
public function updateRole(Request $request, $id)
    {
        // ตรวจสอบว่ามี role ที่ส่งมาหรือไม่ และต้องเป็น admin หรือ user เท่านั้น
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        // ค้นหาผู้ใช้
        $user = User::findOrFail($id);

        // อัปเดต role
        $user->role = $request->role;
        $user->save();

        // ส่งกลับไปพร้อมข้อความสำเร็จ
        return redirect()->back()->with('success', 'อัปเดตสิทธิ์ของผู้ใช้เรียบร้อยแล้ว!');
    }



}
