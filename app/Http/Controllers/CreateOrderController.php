<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CreateOrderController extends Controller
{

    //order list
    public function orderList(){

        if(Auth::user()->role=='1')//1 for admin, 0 for user/customer
        {
            $orders = Order::orderBy('id','desc')->get();
        } else {
            $orders = Order::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
        }
        return view('panel.order_list',compact('orders'));
    }
    //order create
    public function orderCreate(){
        if(Auth::check()){
            return view('order_create');
        } else {
            $previous_url =  Session::put('previous_url',url()->previous());
            return redirect()->route('login');
        }
    }

    //order place
    public function orderPlace(Request $request){


        if(!empty($request->payment_due)){
            $order = new Order();
            $order->user_id = Auth::user()->id;

            if(!empty($request->payment_due)){
                $order->payment_due = $request->payment_due;
            } else{
                $order->payment_due = 0;
            }
            $order->total = $request->total;
            $order->subtotal = $request->subtotal;
            $order->save();

            //insert order details
            $cart_products = Cart::where('user_id',Auth::user()->id)->get();
            foreach($cart_products as $product){
                $order_detail = new OrderDetails;
                $order_detail->order_id = $order->id;
                $order_detail->product_id = $product->product_id;
                $order_detail->quantity = $product->quantity;
                $order_detail->save();
            }

            //remove cart item
            $cart_products = Cart::where('user_id',Auth::user()->id)->delete();
            return redirect()->back()->with('success','Order placed successfully');
        } else {
            echo 'setup payment gatway';
        }
    }//end method

    //search product method
    public function searchProducts(Request $request)
{
    $query = $request->input('query');
    $products = Product::where('name', 'like', '%' . $query . '%')->get();

    return response()->json(['products' => $products]);
}

//add to cart
public function addToCart(Request $request)
{
    $userId = auth()->id();
    $products = $request->input('products');


    foreach ($products as $productId) {
        // Check if the product already exists in the cart
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // If the product exists, update the quantity
            $cartItem->quantity += 1; // Increment quantity by 1
            $cartItem->save();
        } else {
            // If the product doesn't exist, insert it
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1, // Default quantity
            ]);
        }
    }

    //return response()->json(['message' => 'Products added to cart successfully!']);
}

//update cart product quantity
public function updateQuantity(Request $request)
{
    $cart = Cart::find($request->cart_id);
    if ($cart) {
        $cart->quantity = $request->quantity;
        $cart->save();
        return response()->json([
            'status' => 'success',
        ]);
    }

    return response()->json(['status' => 'error', 'message' => 'Cart item not found']);
}

//delete cart product
public function deleteCartProduct(Request $request){
    Cart::find($request->id)->delete();
    return response()->json([
        'status' => 'success',
    ]);
}



}
