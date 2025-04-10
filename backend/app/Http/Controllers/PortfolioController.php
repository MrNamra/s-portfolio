<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Exception;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $portfolio = null;
        if($id) {
            $portfolio = Portfolio::findOrFail($id);
        }
        return view('portfolio', compact('portfolio'));
    }
    public function ApiIndex(Request $request)
    {
        $data = Portfolio::select(['id', 'coverpic', 'info'])->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($data);
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'coverphoto' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ]);
    
            $filePath = null;
    
            if ($request->hasFile('coverphoto')) {
                $file = $request->file('coverphoto');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $fileName);
                $filePath = url('images/' . $fileName);
            }
    
            if (!$filePath) {
                return redirect()->back()->with('error', 'Cover photo not uploaded!');
            }
    
            $portfolio = Portfolio::updateOrCreate(
            [
                'id' => $request->input('id'),
            ],
            [
                'coverpic' => $filePath,
                'info' => $request->input('information'),
            ]);
            return redirect()->back()->with('success', 'Portfolio created successfully!');
            
        } catch (\Exception $e) {
            \Log::error("PortfolioController/store Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.' .$e);
        }
    }
    public function edit(Request $request)
    {
        try {
            $filePath = null;
    
            if ($request->hasFile('coverphoto')) {
                $file = $request->file('coverphoto');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $fileName);
                $filePath = url('images/' . $fileName);
            }
    
            $portfolio = Portfolio::findorFail($request->input('id'));

            if($filePath) {
                $portfolio->coverpic = $filePath;
            }
            $portfolio->info = $request->input('information');
            $portfolio->save();

            return redirect()->back()->with('success', 'Portfolio created successfully!');
            
        } catch (\Exception $e) {
            \Log::error("PortfolioController/store Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.' .$e);
        }
    }

    public function delete(Request $request)
    {
        $portfolio = Portfolio::find($request->id);
        if($portfolio){
            $portfolio->delete();
            return response()->json(['status' => 'success']);
        }
    }

    public function upoadImage(Request $request)
    {
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $name = time().rand(1,100).'.'.$file->extension();
            $file->move(public_path('uploads'), $name);
    
            return response()->json([
                'link' => url('uploads/'.$name)
            ]);
        }
    
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
