<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Product;
use App\ProductImage;
use App\Category;

class ProductController extends Controller
{
    public function index()
    {
    	$products = Product::paginate(10);
    	return view('admin.products.index')->with(compact('products')); //listado
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
    	return view('admin.products.create')->with(compact('categories')); //formulario de registro
    }

    public function store(Request $request)
    {
        // validar
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para el producto.',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'description.required' => 'Es necesario ingresar una descripción corta para el producto.',
            'description.max' => 'La descripción debe tener como máximo 200 caracteres.',
            'price.required' => 'Es necesario ingresar un precio para el producto.',
            'price.numeric' => 'El precio del producto no puede contener letras.',
            'price.min' => 'El precio no admite valores negativos.',
        ];

        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'price' => 'required|numeric|min:0',
        ];
        
        $this->validate($request, $rules, $messages);

    	//registrar nuevo producto en la BD

        //Imprimir parámetros
        //dd($request->all());

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->long_description = $request->input('long_description');
        $product->category_id = $request->category_id;

        $product->save(); // INSERT

        return redirect('/admin/products');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit')->with(compact('product', 'categories')); //formulario de edición
    }

    public function update(Request $request, $id)
    {

        // validar
        $messages = [
            'name.required' => 'Es necesario ingresar un nombre para el producto.',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'description.required' => 'Es necesario ingresar una descripción corta para el producto.',
            'description.max' => 'La descripción debe tener como máximo 200 caracteres.',
            'price.required' => 'Es necesario ingresar un precio para el producto.',
            'price.numeric' => 'El precio del producto no puede contener letras.',
            'price.min' => 'El precio no admite valores negativos.',
        ];

        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'price' => 'required|numeric|min:0',
        ];

        $this->validate($request, $rules, $messages);

        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->long_description = $request->input('long_description');
        $product->category_id = $request->category_id;

        if ($product->category_id == 0)
            $product->category_id = NULL;

        $product->save(); // UPDATE

        return redirect('/admin/products');
    }

    public function destroy($id)
    {
        ProductImage::where('product_id', $id)->delete(); // Necesario eliminar también la relación con la tabla de productimage.

        $product = Product::find($id);
        $product->delete(); // DELETE

        return back(); // abreviación del redirect, porque ya está en el listado de productos.
    }
}
