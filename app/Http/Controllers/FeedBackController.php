<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use Exception;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class FeedBackController extends Controller
{
    public function index(Request $request) {
        $id = $request->id;
        $feedback = null;
        if($id) {
            $feedback = FeedBack::findOrFail($id);
        }
        if($request->ajax()) {
            $data = FeedBack::select(['id', 'name', 'deg', 'img', 'message'])->find($id);
            return response()->json($data);
        }
        return view('feedback', compact('feedback'));
    }
    public function ApiIndex(Request $request) {
        try{
            if($request->datatable == 'true'){
                $data = FeedBack::select(['id', 'name', 'deg', 'img', 'message', 'isActive'])->orderBy('created_at', 'desc')->paginate(10);
            } else {
                $data = FeedBack::select(['id', 'name', 'deg', 'img', 'message'])->where('isActive', 1)->orderBy('created_at', 'desc')->paginate(10);
            }
            return response()->json($data);
        } catch (Exception $e) {
            \Log::error("FeedBackController/index Error: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrog!.'
            ]);
        }
    }
    public function store(Request $request) {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'des' => ['required', 'string', 'max:255'],
                'coverphoto' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'feedback' => ['required', 'string'],
            ]);

            $show = ($request->show)? 1 : 0;
            $base64Image = null;

            if ($request->hasFile('coverphoto')) {
                $image = $request->file('coverphoto');
                if ($request->hasFile('coverphoto')) {
                    $image = $request->file('coverphoto');
                    $resizedImage = Image::make($image)->resize(100, 100)->encode($image->getClientOriginalExtension());
                    $base64Image = 'data:' . $image->getClientMimeType() . ';base64,' . base64_encode($resizedImage);
                }
                // Resize image to 100x100
                $resizedImage = Image::make($image)->resize(100, 100)->encode($image->getClientOriginalExtension());
                $base64Image = 'data:' . $image->getClientMimeType() . ';base64,' . base64_encode($resizedImage);
            }

            if (!$base64Image) {
                return redirect()->back()->with('error', 'Image not uploaded!');
            }

            $feedback = FeedBack::updateOrCreate(
                [
                    'id' => $request->input('id'),
                ],
                [
                    'name' => $request->input('name'),
                    'deg' => $request->input('des'),
                    'img' => $base64Image,
                    'message' => $request->input('feedback'),
                    'isActive' => $show,
                ]
            );

            return redirect()->back()->with('success', 'FeedBack created successfully!');
        } catch (\Exception $e) {
            \Log::error("FeedBackController/store Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.' . $e->getMessage());
        }
    }
    public function edit(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'des' => ['required', 'string', 'max:255'],
                'coverphoto' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'feedback' => ['required', 'string'],
            ]);
            $base64Image = null;

            if ($request->hasFile('coverphoto')) {
                $image = $request->file('coverphoto');
                if ($request->hasFile('coverphoto')) {
                    $image = $request->file('coverphoto');
                    $resizedImage = Image::make($image)->resize(100, 100)->encode($image->getClientOriginalExtension());
                    $base64Image = 'data:' . $image->getClientMimeType() . ';base64,' . base64_encode($resizedImage);
                }
                $resizedImage = Image::make($image)->resize(100, 100)->encode($image->getClientOriginalExtension());
                $base64Image = 'data:' . $image->getClientMimeType() . ';base64,' . base64_encode($resizedImage);
            }

            $portfolio = FeedBack::findOrFail($request->input('id'));
            $show = ($request->show)?1:0;

            // Update only if image was uploaded
            if ($base64Image) {
                $portfolio->img = $base64Image;
            }

            
            $portfolio->name = $request->input('name');
            $portfolio->deg = $request->input('des');
            $portfolio->message = $request->input('feedback');
            $portfolio->isActive = $show;
            $portfolio->save();

            return redirect()->back()->with('success', 'Portfolio updated successfully!');
        } catch (\Exception $e) {
            \Log::error("FeedBackController/edit Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }
    public function delete(Request $request)
    {
        $feedback = FeedBack::find($request->id);
        if($feedback){
            $feedback->delete();
            return response()->json(['status' => 'success']);
        }
    }
}
