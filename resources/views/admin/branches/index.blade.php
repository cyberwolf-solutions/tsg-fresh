@extends('layouts.adminMaster')

@section('content')
    <form id="createBranchForm">
        @csrf
        <input type="text" name="id" placeholder="Branch ID" required>
        <input type="text" name="domain" placeholder="Domain" required>
        <button type="submit">Create Branch</button>
    </form>

    <div id="responseMessage"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#createBranchForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('branches.store') }}",
                    type: "POST",
                    data: {
                        'id': $('input[name="id"]').val(),
                        'domain': $('input[name="domain"]').val()
                    },
                    success: function(response) {
                        $('#responseMessage').html('<div class="alert alert-success">' +
                            response.message + '</div>');
                        $('#createBranchForm')[0].reset();
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = '';
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorMessage += value[0] + '<br>';
                            });
                        }
                        $('#responseMessage').html('<div class="alert alert-danger">' +
                            errorMessage + '</div>');
                    }
                });
            });
        });
    </script>
@endsection
