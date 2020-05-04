<?php

namespace App\Http\Controllers\API;

use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImageCollection;
use App\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Image::latest()->get())
                    ->addIndexColumn()
                    ->addColumn('empty', function($row){
                        return '';
                    })
                    ->addColumn('preview', function($row){
                        return '<img src="'. asset($row->path) .'" class="img-preview img-responsive img-thumbnail" width="150" height="150">';
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="" class="select-item btn btn-light btn-sm">Select</a>';
                        return $btn;
                    })
                    ->rawColumns(['preview', 'action'])
                    ->setRowAttr([
                        'data-entry-id' => function($row) {
                            return $row->id;
                        },
                    ])
                    ->make(true);
        }
    }

    public function destroy(Request $request)
    {
        $data = $request->validate([
            'IDs' => 'required|array',
            'IDs.*' => 'required|integer',
        ], [
            'IDs.*.required' => 'Each ID must be integer.',
        ]);

        $images = Image::whereIn('id', $data['IDs'])->get();
        foreach($images as $image) {
            dump(storage_path($image->path));
            if(unlink(public_path($image->path))) {
                $image->delete();
            }
        }

        return true;
    }
}
