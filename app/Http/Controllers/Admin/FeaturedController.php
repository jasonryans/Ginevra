<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::all();
        return view('admin.features.index', compact('features'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:features,name',
            'product_id' => 'required|exists:products,id',
        ], [
            'name.required' => 'Nama fitur wajib diisi.',
            'name.unique' => 'Fitur dengan nama ini sudah ada.',
            'name.max' => 'Nama fitur maksimal 255 karakter.',
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists' => 'Produk yang dipilih tidak valid.',
        ]);

        try {
            Feature::create($validated);
            return redirect()->back()->with('success', 'Fitur berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan fitur. Silakan coba lagi.');
        }
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:features,name,' . $feature->id,
            'product_id' => 'required|exists:products,id',
        ], [
            'name.required' => 'Nama fitur wajib diisi.',
            'name.unique' => 'Fitur dengan nama ini sudah ada.',
            'name.max' => 'Nama fitur maksimal 255 karakter.',
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists' => 'Produk yang dipilih tidak valid.',
        ]);

        try {
            $feature->update($validated);
            return redirect()->back()->with('success', 'Fitur berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui fitur. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $feature = Feature::findOrFail($id);
            $feature->delete();
            return redirect()->back()->with('success', 'Fitur berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus fitur. Silakan coba lagi.');
        }
    }
}