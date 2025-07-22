<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Models\UserDetails;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {

        $user = Auth::user();
        if ($user && $user->is_admin) {
            return  $this->getProducts($request);
        } else {
            return $this->show();
        }
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
            'image' => 'required|url|max:255',


        ]);

        $data = $request->all();
        $data['AddedBy'] = Auth::user()->id;
        Product::create($data);

        return redirect()->route('dashboard')->with('success', 'Product Added successfully.');
    }


    public function edit(Product $product)
    {


        return view('products.edit', compact('product'));
    }


    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'image' => 'nullable|url|max:255',
        ]);

        $product->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Product updated successfully.');
    }


    public function destroy(Product $product)
    {
        $product->delete();


        return redirect()->route('dashboard')->with('success', 'Product deleted successfully.');
    }

    public function getProducts(Request $request)
    {
        $query = Product::query();

        if ($search = $request->search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        if ($request->has('sortby')) {
            $sortBy = $request->sortby;
            $sortMap = [
                'name_asc' => ['name', 'asc'],
                'name_desc' => ['name', 'desc'],
                'price_asc' => ['price', 'asc'],
                'price_desc' => ['price', 'desc'],
                'quantity_asc' => ['stock', 'asc'],
                'quantity_desc' => ['stock', 'desc'],

            ];

            if (isset($sortMap[$sortBy])) {
                $query->orderBy($sortMap[$sortBy][0], $sortMap[$sortBy][1]);
            } else {
                $query->latest();
            }
        }


        $products = $query->latest()->paginate(10);

        return view('dashboard', compact('products'));
    }



    //Search products
    public function show()
    {
        $query = Product::query();

        $query->where('is_active', true);

        if (request()->filled('search')) {
            $search = request('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if (request()->filled('sortby')) {
            switch (request('sortby')) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    break;
            }
        }

        $filterBy = request('filter_by');
        $operator = request('filter_operator');

        if ($filterBy && $filterBy !== 'default' && $operator && $operator !== 'default') {

            $opMap = [
                'gt' => '>',
                'lt' => '<',
                'eq' => '=',
                'gte' => '>=',
                'lte' => '<='
            ];

            if ($operator === 'ran' && request()->filled('filter_from') && request()->filled('filter_to')) {
                $range = [request('filter_from'), request('filter_to')];
                $query->whereBetween($filterBy === 'date' ? 'created_at' : $filterBy, $range);
            }

            elseif (request()->filled('filter_value') && isset($opMap[$operator])) {
                $sqlOp = $opMap[$operator];
                $value = request('filter_value');

                $query->where($filterBy === 'date' ? 'created_at' : $filterBy, $sqlOp, $value);
            }
        }

       
        $products = $query->latest()->paginate(20);

        return view('products.index', compact('products'));
    }




    public function Order(Product $product)
    {


        $userid = Auth::id();
        $userdetails = UserDetails::where('user_id', $userid)->first();

        return view('products.order', [
            'product' => $product,
            'userdetails' => $userdetails,
        ]);
    }

    public function placeOrder(Request $request, Product $product)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1',
        ]);


        $profileController = new ProfileController();
        $details = $profileController->StoreUserDetails($request);
        if (!$details) {
            return redirect()->back()->withErrors(['error' => 'Failed to save user details.']);
        }

        $newStock = $product->stock - $request->quantity;
        if ($newStock < 0) {
            return redirect()->back()->withErrors(['error' => 'Not enough stock available.']);
        }

        $OrderContrloller = new OrderController();
        $orderController = new OrderController();
        $orderResult = $orderController->store($request, $product);
        if (!$orderResult) {
            return redirect()->back()->withErrors(['error' => 'Failed to place order.']);
        }


        $product->stock = $newStock;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Order placed successfully.');
    }
}
