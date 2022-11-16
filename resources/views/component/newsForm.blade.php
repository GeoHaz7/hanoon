@extends('layouts.app')

@section('content')
    <style>
        .form-news-add {
            width: 100%;
            max-width: 80%;
            padding: 15px;
            margin: auto;
        }

        input[type="text"],
        .textArea {
            background-color: #fff;
        }

        div.error {
            color: red;
            margin-bottom: 5px;
        }
    </style>
    <form id="addNewsForm" class="form-news-add">
        <div class="form-group">
            <label for="edition">Edition</label>
            <select class="custom-select mr-sm-2" id="edition" name="edition">
                <option value="" disabled selected>Choose...</option>
                @foreach ($editions as $edition)
                    <option value="{{ $edition->id }}">{{ $edition->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <div class="form-group col-12 ">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $news?->name }}">
            </div>


            @foreach ($categories as $key => $category)
                <div class="form-group col-3">
                    <input {{ in_array($category->id, $selectedCategoriesIds) ? 'checked' : '' }} type="checkbox"
                        name="category" value="{{ $category->id }}">
                    <label for="category"> {{ $category->name }} </label><br>
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="shortBrief">Short Brief</label>
            <input type="text" class="form-control" id="shortBrief" name="shortBrief"
                placeholder="Write a short brief about this news" value="{{ $news?->short_brief }}">
        </div>
        <div class="form-group">
            {{-- CkEditor --}}
            <label for="description">Description</label>
            <textarea class="form-control textArea" id="description" name="description" rows="3">{{ $news?->description }}</textarea>
        </div>

        <div class="form-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="customFile" id="customFile" accept="image/*">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#addNewsForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 10
                    },
                    description: {
                        required: true,
                        minlength: 50
                    },
                    shortBrief: {
                        required: true,
                        maxlength: 20
                    },
                    category: {
                        required: true,
                    },
                    edition: {
                        required: true,
                    },
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.insertAfter(element.parent());
                },
                submitHandler: function(form) {
                    if (window.location.href.indexOf("edit") > -1) {
                        updateNews();
                    } else {
                        addNews();


                    }

                }
            });

            function addNews() {
                var fd = new FormData();

                fd.append('name', $('#name').val());
                fd.append('description', $('#description').val());

                var arr = [];

                $('input:checked').each(function() {
                    arr.push($(this).val());
                });

                fd.append('category', arr);
                fd.append('shortBrief', $('#shortBrief').val());
                fd.append('edition', $('#edition').val());
                fd.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "/news/store",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: fd,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: response,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (response == 'success') {
                            }
                            location.href = "{{ url('/data') }}";
                        });
                    },
                    error: function(err) {

                    }
                });
            }

            function updateNews() {
                var fd = new FormData();

                fd.append('name', $('#name').val());
                fd.append('description', $('#description').val());

                var arr = [];

                $('input:checked').each(function() {
                    arr.push($(this).val());
                });

                fd.append('category', arr);
                fd.append('shortBrief', $('#shortBrief').val());
                fd.append('edition', $('#edition').val());
                fd.append('_method', 'PUT');
                fd.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: "/news/{{ $news->id }}/put",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: fd,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: response,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (response == 'success') {}
                            location.href = "{{ url('/data') }}";
                        });
                    },
                    error: function(err) {

                    }
                });
            }
        })
    </script>
@endsection
