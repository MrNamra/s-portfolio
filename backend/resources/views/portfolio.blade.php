<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Portfolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{route('portfolio.store')}}" enctype="multipart/form-data">
                        @csrf
                        <lable > Cover Photo </lable>
                        <input type="file" name="coverphoto" class="mt-3 mb-3 form-control" />
                        <hr />
                        <lable class="mt-3"> Infomation</lable>
                        <textarea class="form-control mt-3 mb-3" name="information" id="information"></textarea>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif
</x-app-layout>
<script>
    $(document).ready(function() {
        $('#information').summernote()
    })
</script>
