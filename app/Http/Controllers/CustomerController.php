<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::orderBy('idcustomer')->paginate(5);
        return view('customer.index', compact('customer'));
    }

    // customer-tambah.php (tampilkan form)
    public function create()
    {
        return view('customer.create');
    }

    // petugas-tambah.php (proses simpan)
    public function store(Request $request)
    {
        $request->validate([
            'idcustomer'   => 'required|unique:customer,idcustomer',
            'kepada_yth' => 'required',
            'alamat'     => 'required',
        ]);

        Customer::create($request->only('idcustomer', 'kepada_yth', 'alamat'));

        return redirect()->route('customer.index')
                         ->with('success', 'Data Customer Berhasil Disimpan!');
    }

    // customer-ubah.php (tampilkan form edit)
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit', compact('customer'));
    }

    // customer-ubah.php (proses update)
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kepada_yth' => 'required',
            'alamat'     => 'required',
        ]);

        Customer::findOrFail($id)->update($request->only('kepada_yth', 'alamat'));

        return redirect()->route('customer.index')
                         ->with('success', 'Data Customer Berhasil Diperbarui!');
    }

    // customer-hapus.php
    public function destroy(string $id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('customer.index')
                         ->with('success', 'Data Customer Berhasil Dihapus!');
    }
}
