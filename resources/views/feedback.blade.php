<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('feedback') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($feedback)
                        <form method="POST" action="{{route('feedback.edit')}}" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{route('feedback.store')}}" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <lable > client Photo </lable>
                        <input type="hidden" name="id" value="{{$feedback ? $feedback->id : 'null'}}" class="mt-3 mb-3 form-control" />
                        <input type="file" name="coverphoto" class="mt-3 mb-3 form-control" />
                        <lable class="mt-3">client name</lable>
                        <input class="form-control mt-3 mb-3" name="name" id="name" value="{{$feedback ? $feedback->name : ''}}" />
                        <lable class="mt-3">client Desigenation</lable>
                        <input class="form-control mt-3 mb-3" name="des" id="des" value="{{$feedback ? $feedback->deg : ''}}" />
                        <hr />
                        <lable class="mt-3">FeedBack</lable>
                        <textarea class="form-control mt-3 mb-3" name="feedback" id="information">{{$feedback ? $feedback->message : ''}}</textarea>
                        <input type="checkbox" class="mt-3 mb-3 form-control" name="show" id="show" {{($feedback ? $feedback->isActive ? 'checked' : '' : '' )}} /> <label for="show">Show this on website</label><br>
                        <button type="submit" class="mt-3 btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
        <table id="datatable" class="display">
            <thead>
                <tr>
                    <th>Index</th>
                    <th>img</th>
                    <th>name</th>
                    <th>deg</th>
                    <th>message</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
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
</script>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea',
            // plugins: 'code table lists',
            // toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });

        $('#datatable').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: '{{route("api.feedbacks")}}?datatable=true',
                dataSrc: 'data'
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'img',
                    render: function(data, type, row){
                        return `<img src="${data}" width="80" height="60"/>`;
                    }
                },
                { data: 'name' },
                { data: 'deg' },
                {
                    data: 'message',
                    render: function(data, type, row) {
                        if (typeof data === 'string') {
                            let words = data.split(/\s+/);
                            if (words.length > 10) {
                                return words.slice(0, 10).join(' ') + '...';
                            }
                            return data;
                        }
                        return '';
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row){
                        return `
                            <button class="btn btn-primary" onclick="editData(${data})">Edit</button>
                            <button class="btn btn-danger" onclick="deleteData(${data})">Delete</button>
                        `;
                    }
                }
            ]
        });
    })
    function editData(id) {
        var url = '{{route("feedback")}}?id='+id;
        window.location.href = url;
        // alert('Edit id: ' + id);
        // you can redirect or open modal here
    }

    // Delete Function
    function deleteData(id) {
        if(confirm('Are you sure to delete?')) {
            $.ajax({
                url: '{{route("feedback.delete")}}' + '?id=' + id,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert('Deleted Successfully');
                    $('#datatable').DataTable().ajax.reload();
                }
            });
        }
    }
</script>
