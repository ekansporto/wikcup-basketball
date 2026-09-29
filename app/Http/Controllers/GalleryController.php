<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of tournament gallery photos.
     */
    public function index(Request $request)
    {
        $kategori = $request->query('kategori', 'all');

        $query = Gallery::orderBy('tanggal', 'desc')->orderBy('id_gallery', 'asc');

        if ($kategori !== 'all' && !empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        $galleries = $query->get();
        $totalPhotos = $galleries->count();

        return view('galleries.index', compact('galleries', 'totalPhotos', 'kategori'));
    }

    /**
     * Display the specified gallery item.
     */
    public function show(Gallery $gallery)
    {
        $gallery->load('match.teamA', 'match.teamB');
        return view('galleries.show', compact('gallery'));
    }

    /**
     * Admin placeholders
     */
    public function create() { abort(403); }
    public function store(Request $request) { abort(403); }
    public function edit(Gallery $gallery) { abort(403); }
    public function update(Request $request, Gallery $gallery) { abort(403); }
    public function destroy(Gallery $gallery) { abort(403); }
}
