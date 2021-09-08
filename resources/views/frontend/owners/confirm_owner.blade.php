@extends('frontend.main_master')
@section('content')
    <div class="body-content">
        <div class="container">
            <div>
                <div class='col-md-6' style="padding:10px">
                    &nbsp;&nbsp;<a href="{{ route('user.owners') }}"><i class='fa fa-arrow-left'></i> Back</a>
                </div>
                <!--Grid column-->
                @if ($data != null)

                    <div class="col-md-12 text-center">
                        <div class="col-md-6" style="background-color:white">
                            <div class="card">

                                <div class="card-title">
                                    <h3>Biaya Registrasi</h3>
                                </div>
                                <div class="card-body"
                                    style="font-size:18px; margin-top:20px; border:2px dotted gray; padding-bottom:50px; line-height: 2;">
                                    <br>
                                    <img src="{{ asset('upload/owner/' . $data->owner->coverimage) }}" width="100px"
                                        height="140px" />

                                    <h4>{{ $data->owner->namausaha }}</h4>
                                    <strong>Type Usaha</strong>
                                    :
                                    {{ $data->typeowner->nametypeowner }}<br>
                                    <strong>Tanggal Join</strong>
                                    @php
                                        $tanggal = \Carbon\Carbon::parse($data->created_at)->format('d, M Y');

                                        echo $tanggal;
                                    @endphp
                                    <br>
                                    <strong>Biaya</strong>
                                    @currency($data->harga)
                                    /Tahun

                                    <br>
                                    @if ($data->status == 'PENDING')
                                        <a id="linkpayment" href="{{ $data->payment_url }}" target="_blank"><button
                                                class='btn btn-default' id="buttonBayar">
                                                Bayar
                                            </button>
                                        </a>
                                    @else
                                        <div style="margin-top:50px">
                                            @php
                                                $parameter = Crypt::encrypt($data->id);
                                            @endphp
                                            <a id="paymenturl"
                                                href="{{ route('user.owner.payment', $parameter) }}"><button
                                                    class='btn btn-primary'>
                                                    Generate Ulang
                                                </button>
                                            </a>
                                        </div>
                                    @endif



                                </div>
                            </div>
                        </div>

                    </div>

                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            //cek url payment

            $('#paymenturl').click(function(e) {
                e.preventDefault();
                $("#buttonBayar").html("Processing...");
                $.ajax({
                    url: $("#paymenturl").attr('href'),
                    method: 'get',
                    success: function(result) {
                        $("#linkpayment").attr('href', result.success);
                        $("#buttonBayar").html("New Link, Click To Pay");
                        console.log(result);
                    }
                });
                // var tes = $("#paymenturl").attr('href');
                // alert(tes);
            });
        });
    </script>
@endsection
