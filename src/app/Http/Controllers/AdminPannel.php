<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\product;
use App\Models\historyorder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class AdminPannel extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
        if (auth()->user()->role != 'admin') {
            return redirect('/');
        }
        return $next($request);
        });
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


    function index(){
        $users = Admin::get();
        $order = historyorder::get();
        return view('dashboard', compact('users', 'order'));
    }

    function products(){
        $products = product::paginate(10);
        return view('product', compact('products'));
    }

    function productsUpload(){
        return view('productupload');
    }

    public function addProduct(Request $request)
{
    $request->validate([
        'productName' => 'required|string|max:255',
        'productDescription' => 'required|string',
        'productPrice' => 'required|numeric|min:0',
        'productQuantity' => 'required|integer|min:0',
        'productImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // จัดการรูปภาพ
    $imageName = "TEST";
    if ($request->hasFile('productImage')) {
        $imageName = time() . '_' . Str::random(10) . '.' . $request->productImage->extension();
        $request->productImage->move(('../public/uploads/products'), $imageName);
    }

    // บันทึกข้อมูลลง database
    product::insert([
        'ProductName' => $request->productName,
        'ProductDescription' => $request->productDescription,
        'ProductPrice' => $request->productPrice,
        'ProductQuantity' => $request->productQuantity,
        'ProductImage' => $imageName,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect('product')->with('success', 'Product uploaded successfully!');
    }
    public function deleteProduct($id)
{
    $product = Product::findOrFail($id);

    if ($product->ProductImage && file_exists(public_path('uploads/products/' . $product->ProductImage))) {
        unlink(public_path('uploads/products/' . $product->ProductImage));
    }

    $product->delete();

    return redirect()->route('product')->with('success', 'Product deleted successfully!');
    }
    public function editProduct($id){
        $product = Product::findOrFail($id);
        return view('productedit', compact('product'));
    }
    public function updateProduct(Request $request, $id){
        $product = Product::where('id', $id)->first();
        $data = [
            'ProductName' => $request->productName,
            'ProductDescription' => $request->productDescription,
            'ProductPrice' => $request->productPrice,
            'ProductQuantity' => $request->productQuantity,
            'ProductImage' => $product->ProductImage,
            'created_at' => now(),
            'updated_at' => now(),

        ];
        if ($request->hasFile('productImage')) {
            $imageName = time() . '_' . Str::random(10) . '.' . $request->productImage->extension();
            $request->productImage->move(('../public/uploads/products'), $imageName);
            $data['ProductImage'] = $imageName;
        }
        Product::where('id', $id)->update($data);
        return redirect()->route('product')->with('success', 'Product updated successfully!');
    }
    public function users(){
        $users = Admin::paginate(10);
        return view('userlist', compact('users'));
    }
    public function userdelete($id){
        $user = Admin::findOrFail($id);
        $user->delete();
        return redirect()->route('userlist')->with('success', 'User deleted successfully!');
    }
    public function order(){
        $order = historyorder::paginate(10);

        return view('order', compact('order'));
    }
    

}
