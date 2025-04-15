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
                    @if($portfolio)
                        <form method="POST" action="{{route('portfolio.edit')}}" enctype="multipart/form-data">
                            <div class="col-2">
                                <lable>Index Number</lable>
                                <input type="number" name="display_order" value="{{$portfolio ? $portfolio->display_order : 'null'}}" class="mt-3 mb-3 col-2 form-control" />
                            </div>
                    @else
                        <form method="POST" action="{{route('portfolio.store')}}" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <lable > Cover Photo </lable>
                        <input type="hidden" name="id" value="{{$portfolio ? $portfolio->id : 'null'}}" class="mt-3 mb-3 form-control" />
                        <input type="file" name="coverphoto" class="mt-3 mb-3 form-control" />
                        <hr />
                        <div>
                            <lable class="mt-3">Infomation</lable>
                            <textarea class="form-control mt-3 mb-3" name="information" id="information">{{$portfolio ? $portfolio->info : ''}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Upload</button>
                    </form>
                </div>
            </div>
        </div>
        <table id="datatable" class="display">
            <thead>
                <tr>
                    <th>Index</th>
                    <th>Cover Pic</th>
                    <th>Info</th>
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
<style>
    .tox-statusbar__branding {
        display: none;
    }
</style>
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
                url: '{{route("api.portfolip")}}',
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
                    data: 'coverpic',
                    render: function(data, type, row){
                        return `<img src="${data}" width="80" height="60"/>`;
                    }
                },
                {
                    data: 'info',
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
        window.location.href = '/portfolio?id=' + id;
        // alert('Edit id: ' + id);
        // you can redirect or open modal here
    }

    // Delete Function
    function deleteData(id) {
        if(confirm('Are you sure to delete?')) {
            $.ajax({
                url: '{{route("portfolio.delete")}}' + '?id=' + id,
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
