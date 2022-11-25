<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShippingOption;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingOptionsController extends Controller
{
    public function __construct(private ShippingOption $shipping)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings = $this->shipping->all();

        return view('admin.shippings.index', compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shippings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $data = $request->all();

        $store->first()->shippings()->create($data);

        session()->flash('message', ['type' => 'success', 'body' => 'Sucesso ao cadastrar categoria']);

        return redirect()->route('admin.shippings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipping = $this->shipping->findOrFail($id);

        return view('admin.shippings.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shipping = $this->shipping->findOrFail($id);
        $shipping->update($request->all());

        session()->flash('message', ['type' => 'success', 'body' => 'Sucesso ao atualizar categoria']);

        return redirect()->route('admin.shippings.edit', $shipping);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping = $this->shipping->findOrFail($id);

        $shipping->delete();

        session()->flash('message', ['type' => 'success', 'body' => 'Sucesso ao remover categoria']);

        return redirect()->route('admin.shippings.index');
    }
}