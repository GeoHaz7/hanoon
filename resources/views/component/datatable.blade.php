@extends('layouts.app')

@section('content')
    <table id="example" class="display stripe  table" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Desscription</th>
                <th>Brief</th>
                <th>Author</th>
            </tr>
        </thead>

    </table>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "ajax": "{{ route('news.data') }}",
                "columns": [{
                        "data": "name"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "short_brief"
                    },
                    {
                        "data": "author"
                    },
                ]
            });
        });
    </script>
@endsection
