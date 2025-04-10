<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Exception;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        return view('portfolio');
    }
    public function ApiIndex(Request $request)
    {
        $data = Portfolio::select(['id', 'coverpic', 'info'])->limit(10)->orderby('created_at', 'desc')->get();
        return response()->json([ 'data' => $data ]);
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
    
            $portfolio = new Portfolio();
            $portfolio->coverpic = $filePath;
            $portfolio->info = $request->input('information');
            $portfolio->save();
            return redirect()->back()->with('success', 'Portfolio created successfully!');
            
        } catch (\Exception $e) {
            \Log::error("PortfolioController/store Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.' .$e);
        }
    }
}
