<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $portfolio = null;
        if($id) {
            $portfolio = Portfolio::findOrFail($id);
        }
        if($request->ajax()) {
            $data = Portfolio::select(['id', 'coverpic', 'info'])->find($id);
            return response()->json($data);
        }
        return view('portfolio', compact('portfolio'));
    }
    public function ApiIndex(Request $request)
    {
        $data = Portfolio::select(['id', 'coverpic', 'info'])->orderBy('display_order', 'asc')->paginate(10);
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
                $filePath = url('public/images/' . $fileName);
            }
    
            $portfolio = Portfolio::findorFail($request->input('id'));

            if($filePath) {
                $portfolio->coverpic = $filePath;
            }
            $portfolio->info = $request->input('information');
            
            if ($request->has('display_order')) {
                $newOrder = $request->input('display_order');

                if ($portfolio->display_order != $newOrder) {
                    
                    if ($portfolio->display_order < $newOrder) {
                        Portfolio::where('display_order', '>', $portfolio->display_order)->where('display_order', '<=', $newOrder)->decrement('display_order');
                    } else {
                        Portfolio::where('display_order', '>=', $newOrder)->where('display_order', '<', $portfolio->display_order)->increment('display_order');
                    }
                    
                    $portfolio->display_order = $newOrder;
                }
            }
            $portfolio->save();

            return redirect()->back()->with('success', 'Portfolio created successfully!');
            
        } catch (\Exception $e) {
            \Log::error("PortfolioController/edit Error: " . $e->getMessage());
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
    public function contect(Request $request)
    {
        try{
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'message' => 'required|string|max:1000',
            ]);

            $name = $request->name;
            $email = $request->email;
            $message = $request->message;

            $to = env('MAIL_TO_ADDRESS');
            $subject = "SomeOne Contact You From Portfolio";
            $body = "Name: " . $name . "\nEmail: " . $email . "\nMessage: " . $message;

            $a= Mail::raw($body, function ($mail) use ($to, $subject, $email, $name) {
                $mail->to($to)
                     ->subject($subject)
                     ->replyTo($email, $name);
            });
            return response()->json(['status' => true, 'message' => 'Message sent successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Internal server error.',
            ], 422);
        } catch (Exception $e) {
            \Log::error("PortfolioController/contect Error: " . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'Something went wrong.']);
        }
    }
    public function aboutMe()
    {
        $about = Storage::get('about.txt');
        return view('about', compact('about'));
    }
    public function ApiAbout()
    {
        $data = Storage::get('about.txt');
        return response()->json($data);
    }
    public function aboutMeEdit(Request $request)
    {
        Storage::put('about.txt', $request->about);
        return redirect()->back()->with('success', 'About updated successfully!');
    }
}
