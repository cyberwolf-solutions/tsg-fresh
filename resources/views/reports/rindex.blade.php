<x-default-layout>

    @section('title', 'Summary Reports')

    @section('breadcrumbs')
        {{ Breadcrumbs::render('report.index') }}

    @endsection


    <div>

        <div class="repo__com">
            <div class="repo_sub_com card card-flush">
                <h1 class="repo_title fs-4 text-capitalize">purchase</h1>
                <div class="repo_line"></div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">amount</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">328512.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">purchase</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">61</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">paid</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light" value="0.00">0.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">tax</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">0.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">discount</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">0.00</h3>
                    </div>
                </div>
            </div>

            {{-- sale --}}
            <div class="repo_sub_com card card-flush">
                <h1 class="repo_title fs-4 text-capitalize">sale</h1>
                <div class="repo_line"></div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">amount</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">328512.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">purchase</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">61</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">paid</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light" value="0.00">0.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">tax</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">0.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">discount</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">0.00</h3>
                    </div>
                </div>
            </div>

            {{-- slae return  --}}
            <div class="repo_sub_com card card-flush">
                <h1 class="repo_title fs-4 text-capitalize">sale return </h1>
                <div class="repo_line"></div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">amount</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">328512.00</h3>
                    </div>
                </div>

                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">return</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light" value="0.00">0.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">tax</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">0.00</h3>
                    </div>
                </div>

            </div>

            {{-- purchase return  --}}
            <div class="repo_sub_com card card-flush">
                <h1 class="repo_title fs-4 text-capitalize">purchase return</h1>
                <div class="repo_line"></div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">amount</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">328512.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">return</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">61</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">tax</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light" value="0.00">0.00</h3>
                    </div>
                </div>
            </div>

            {{-- profit / loss  --}}

            <div class="repo_sub_com card card-flush">
                <h1 class="repo_title fs-4 text-capitalize">profit / loss</h1>
                <div class="repo_line"></div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">sale</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">328512.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">product cost</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">61</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">profit</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light" value="0.00">0.00</h3>
                    </div>
                </div>

            </div>
            <div class="repo_sub_com card card-flush">
                <h1 class="repo_title fs-4 text-capitalize">profit / loss</h1>
                <div class="repo_line"></div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">sale</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">328512.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">product cost</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">61</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">sale return</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light" value="0.00">0.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">purchase </h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">0.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">profit</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">0.00</h3>
                    </div>
                </div>
            </div>



            {{-- net profit  --}}
            <div class="repo_sub_com card card-flush">
                <h1 class="repo_title fs-4 text-capitalize">net profit / net loss</h1>
                <div class="repo_line"></div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">amount</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">328512.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">purchase</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">61</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">paid</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light" value="0.00">0.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">tax</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">0.00</h3>
                    </div>
                </div>
                <div class="repo_details_lines">
                    <div class="repo_detail_title">
                        <h1 class="fs-5 fw-light text-capitalize">discount</h1>
                    </div>
                    <div class="repo_amount">
                        <h3 class="fs-6 fw-light">0.00</h3>
                    </div>
                </div>
            </div>



        </div>

</x-default-layout>
