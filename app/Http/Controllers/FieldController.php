<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fields = Field::latest()->paginate(10);
        return view('admin.fields.index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fields.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga_perjam' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable',
        ]);
    
        // Proses upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/fields'), $filename);
        }
    
        // Simpan ke database
        Field::create([
            'nama' => $request->nama,
            'harga_perjam' => $request->harga_perjam,
            'gambar' => $filename, // simpan nama file saja
            'deskripsi' => $request->deskripsi,
        ]);
    
        return redirect()->route('admin.fields.index')->with('success', 'Field created successfully.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Field $field)
    {

            }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field)
    {
        $field = Field::find($field->id);
        return view('admin.fields.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Field $field)
{
    $request->validate([
        'nama' => 'required',
        'harga_perjam' => 'required|numeric',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'deskripsi' => 'nullable',
    ]);

    // Inisialisasi data
    $data = [
        'nama' => $request->nama,
        'harga_perjam' => $request->harga_perjam,
        'deskripsi' => $request->deskripsi,
    ];

    // Jika user upload gambar baru
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($field->gambar && file_exists(public_path('uploads/fields/' . $field->gambar))) {
            unlink(public_path('uploads/fields/' . $field->gambar));
        }

        $file = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/fields'), $filename);

        $data['gambar'] = $filename;
    }

    // Update field
    $field->update($data);

    return redirect()->route('admin.fields.index')->with('success', 'Field updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Field $field)
    {
        $field = Field::find($field->id);
        $field->delete();
        return redirect()->route('admin.fields.index')->with('success', 'Field deleted successfully.');
    }
}
