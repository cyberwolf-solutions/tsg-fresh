@extends('landing-page.layouts.app')

@section('content')
    <div class="container-fluid p-0" style="margin-top: 90px;background-color:rgb(246, 246, 246)">
        <!-- Hero Section -->
        <!-- Hero Banner -->
        <div class="text-secondary"
            style="position: relative; background: url('{{ asset('build/images/product/f3.jpg') }}') no-repeat center center; background-size: cover; height: 300px;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; ">
                <h2 style="font-weight: bold;">Get in touch</h2>
                <p>Want to get in touch? We'd love to hear from you. Here's how you can reach us...</p>
            </div>

            <!-- Overlapping Boxes -->
            <div class="row text-center"
                style="position: absolute; bottom: 0; left: 50%; transform: translate(-50%, 50%); width: 100%; max-width: 900px;">
                <div class="col-md-6 mb-3">
                    <div class="p-4 mx-auto shadow" style="max-width: 400px; background-color: white; border-radius: 4px;">
                        <h5 class="fw-bold" style="color:rgb(48, 48, 48);font-size:14px">HOTLINE</h5>
                        <a href="tel:+94774000010" class="btn mt-2"
                            style="background-color: rgb(67, 183, 245); color: white; padding: 4px 12px; font-size: 14px; line-height: 1;">
                            +94774000010
                        </a>

                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="p-4 mx-auto shadow" style="max-width: 400px; background-color: white; border-radius: 4px;">
                        <h5 class="fw-bold" style="color:rgb(48, 48, 48);font-size:14px">TELEPHONE</h5>
                        <a href="tel:+94715406554" class="btn mt-2"
                            style="background-color:rgb(67, 183, 245); color: white; padding: 4px 12px; font-size: 14px; line-height: 1;">
                            +94715406554
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add spacing below so next content doesn't overlap boxes -->
        <div style="margin-top: 100px;"></div>




        <!-- Offices Section -->
        <div class="container text-center py-5 texts-secondary"
            style="max-width: 900px;margin-right:auto;margin-left:auto;margin-top:10px;
        background-color:white">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <h6 class="fw-bold mb-4" style="color:rgb(48, 48, 48);font-size:14px">SALES OFFICE</h6>
                        </div>
                        <div class="col-lg-8 col-md-4 col-sm-12 text-center">
                            <div class="row">
                                <div class="col-12 text-center" style="text-align: center">
                                    <h6 class="fw-bold mb-4" style="color:rgb(48, 48, 48);font-size:14px">CORPORATE BRANCHES
                                    </h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <p class="mb-1" style="color:rgb(48, 48, 48);font-size:14px">COLOMBO 3<br>No. 38, Charles Drive,
                        Colombo 03, Sri Lanka</p>
                    <p class="mb-1 mt-4" style="color:rgb(48, 48, 48);font-size:14px">Phone: +94 112 258 533</p>
                    <p class="mb-1" style="color:rgb(48, 48, 48);font-size:14px">Fax: +94 112 258 666</p>
                    <p style="color:rgb(48, 48, 48);font-size:14px">Email: info@tsg.lk</p>
                </div>
                <div class="col-md-4 mt-4">
                    <p class="mb-1" style="color:rgb(48, 48, 48);font-size:14px">DANKOTUWA<br>Bubula Watta, Dankotuwa, Sri
                        Lanka</p>
                    <p class="mb-1 mt-4" style="color:rgb(48, 48, 48);font-size:14px">Phone: +94 112 258 533</p>
                    <p class="mb-1" style="color:rgb(48, 48, 48);font-size:14px">Fax: +94 112 258 666</p>
                    <p style="color:rgb(48, 48, 48);font-size:14px">Email: info@tsg.lk</p>
                </div>
                <div class="col-md-4 mt-4">
                    <p class="mb-1" style="color:rgb(48, 48, 48);font-size:14px">JAFFNA<br>Beach Rd, Jaffna, Sri Lanka</p>
                    <p class="mb-1 mt-4" style="color:rgb(48, 48, 48);font-size:14px">Phone: +94 212 219 436</p>
                    <p class="mb-1" style="color:rgb(48, 48, 48);font-size:14px">Fax: +94 212 219 436</p>
                    <p style="color:rgb(48, 48, 48);font-size:14px">Email: info@tsg.lk</p>
                </div>
            </div>
        </div>

        <div class="container text-center py-5 text-secondary"
            style="max-width: 900px;margin-right:auto;margin-left:auto;margin-top:60px;
        background-color:white">
            <!-- Outlets -->
            <div class="row mt-5">
                <div class="col-md-4">
                    <h6 class="fw-bold" style="color:rgb(48, 48, 48);font-size:14px">COLOMBO 3</h6>
                    <p style="color:rgb(48, 48, 48);font-size:14px">No. 38, Charles Drive, Colombo 03, Sri Lanka</p>
                    <p style="color:rgb(48, 48, 48);font-size:14px">Phone: +94774000010</p>
                    <p style="color:rgb(48, 48, 48);font-size:14px">Email: marketing@tsg.lk</p>
                    <p style="color:rgb(48, 48, 48);font-size:14px"><a href="#">Get Direction</a></p>
                </div>
                <div class="col-md-4" style="color:rgb(48, 48, 48);font-size:14px">
                    <h6 class="fw-bold" style="color:rgb(48, 48, 48);font-size:14px">KOCHCHIKADE - NEGOMBO</h6>
                    <p style="color:rgb(48, 48, 48);font-size:14px">Chilaw Road, Kochchikade<br>Opening Soon</p>
                    <p style="color:rgb(48, 48, 48);font-size:14px">Email: -</p>
                    <p style="color:rgb(48, 48, 48);font-size:14px"><a href="#">Get Direction</a></p>
                </div>
                <div class="col-md-4" style="color:rgb(48, 48, 48);font-size:14px">
                    <h6 style="color:rgb(48, 48, 48);font-size:14px" class="fw-bold">KANDY</h6>
                    <p style="color:rgb(48, 48, 48);font-size:14px">#500, Peradeniya Road, Kandy, Sri Lanka</p>
                    <p style="color:rgb(48, 48, 48);font-size:14px">Email: marketing@tsg.lk</p>
                    <p style="color:rgb(48, 48, 48);font-size:14px"><a href="#">Get Direction</a></p>
                </div>
            </div>
        </div>

        <!-- Contact Form Placeholder -->
        {{-- <div class="text-center py-5">
            <h5>CONTACT US</h5>
            <p style="color: red;">Error: Contact form not found.</p>
        </div> --}}
    </div>
@endsection
