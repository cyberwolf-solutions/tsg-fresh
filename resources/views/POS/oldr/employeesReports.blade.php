@extends('layouts.master-without-nav')

@section('title')
    Print Employees
@endsection

@section('content')
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
            font-family: Arial, sans-serif; /* Default font */
        }
        .container-fluid {
            padding: 20px;
        }
        .logo {
            max-width: 200px; /* Limit the logo size */
            margin-bottom: 10px; /* Add some space below the logo */
        }
        .resort-name {
            font-size: 24px; /* Larger font size for the resort name */
            color: #111316; /* Blue color */
            font-weight: bold; /* Bold text */
        }
        .employees-report {
            margin-top: 20px; /* Add space above the employees report */
        }
        .table {
            background-color: #fff; /* White background for the table */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
        }
        .table th,
        .table td {
            vertical-align: middle; /* Center content vertically */
        }
        .table th {
            background-color: #007bff; /* Blue header background */
            color: #fff; /* White text */
        }
        .table-hover tbody tr:hover {
            background-color: #f0f0f0; /* Light gray background on hover */
        }
    </style>
    <div class="container-fluid">
        <div class="row justify-content-center text-center">
            <img src="{{ asset('storage/' . $settings->logo_dark) }}" class="logo img-fluid" >
            <div class="resort-name">Ging Oya Resort</div>
        </div>
        <hr>
        <div class="row employees-report">
            <h4>Employees Report</h4>
            <div class="col-12">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>NIC</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Designation</th>
                            <th>Address</th>
                            <th>City</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nic }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->contact_primary }}</td>
                            <td>{{ $user->designation }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->city }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>
@endsection
