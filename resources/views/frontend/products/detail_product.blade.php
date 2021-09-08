@extends('frontend.main_master')
@section('content')
    @php
    $parameterowner = Crypt::encrypt($ownerproduct->owner_id);
    @endphp
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('usaha.detail', $parameterowner) }}">Product</a></li>
                    <li class='active'>Detail</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->
    <div class="body-content outer-top-xs">
        <div class='container'>
            <div class='row single-product'>
                <div class='col-md-3 sidebar'>
                    <div class="sidebar-module-container">
                        <div class="home-banner outer-top-n">
                            <h5>{{ $ownerproduct->owner->namausaha }}</h5>
                            <img src="{{ asset('upload/owner/' . $ownerproduct->owner->coverimage) }}" alt="Image"
                                width="250px">
                        </div>
                        <!-- ============================================== Testimonials============================================== -->
                        {{-- Testimonial tulis disini --}}
                        <!-- ============================================== Testimonials: END ============================================== -->



                    </div>
                </div><!-- /.sidebar -->
                <div class='col-md-9'>
                    <div class="detail-block">
                        <div class="row  wow fadeInUp">

                            <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
                                <div class="product-item-holder size-big single-product-gallery small-gallery">

                                    <div id="owl-single-product">
                                        @foreach ($detailproduct->images as $row)
                                            <div class="single-product-gallery-item" id="{{ $row->id }}">
                                                <a data-lightbox="{{ $row->id }}" data-title="Gallery"
                                                    href="{{ asset('upload/products/' . $row->imageproducturl) }}">
                                                    <img class="img-responsive" alt="" src="{{ asset('frontend/') }}"
                                                        data-echo="{{ asset('upload/products/' . $row->imageproducturl) }}" />
                                                </a>
                                            </div><!-- /.single-product-gallery-item -->

                                        @endforeach
                                    </div><!-- /.single-product-slider -->


                                    <div class="single-product-gallery-thumbs gallery-thumbs">
                                        <div id="owl-single-product-thumbnails">
                                            @foreach ($detailproduct->images as $row)
                                                <div class="item">
                                                    <a class="horizontal-thumb active" data-target="#owl-single-product"
                                                        data-slide="{{ $row->id }}" href="#{{ $row->id }}">
                                                        <img class="img-responsive" width="85" alt=""
                                                            src="{{ asset('frontend/assets/images/blank.gif') }}"
                                                            data-echo="{{ asset('upload/products/' . $row->imageproducturl) }}" />
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div><!-- /#owl-single-product-thumbnails -->
                                    </div><!-- /.gallery-thumbs -->

                                </div><!-- /.single-product-gallery -->
                            </div><!-- /.gallery-holder -->
                            <div class='col-sm-6 col-md-7 product-info-block'>
                                <div class="product-info">
                                    <h1 class="name">{{ $detailproduct->namaproduk }}</h1>

                                    {{-- <div class="rating-reviews m-t-20">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="rating rateit-small"></div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="reviews">
                                                    <a href="#" class="lnk">(13 Reviews)</a>
                                                </div>
                                            </div>
                                        </div><!-- /.row -->
                                    </div><!-- /.rating-reviews -->

                                    <div class="stock-container info-container m-t-10">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="stock-box">
                                                    <span class="label">Availability :</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="stock-box">
                                                    <span class="value">In Stock</span>
                                                </div>
                                            </div>
                                        </div><!-- /.row -->
                                    </div><!-- /.stock-container --> --}}

                                    <div class="description-container m-t-20">
                                        {!! $detailproduct->deskripsi !!}.
                                    </div><!-- /.description-container -->

                                    <div class="price-container info-container m-t-20">
                                        <div class="row">


                                            <div class="col-sm-6">
                                                <div class="price-box">
                                                    <span class="price">@currency($detailproduct->hargasatuan)</span>

                                                    @if ($detailproduct->hargacoret != null || $detailproduct->hargacoret != 0)
                                                        <span
                                                            class="price-strike">@currency($detailproduct->hargacoret)</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="favorite-button m-t-10">
                                                    <a class="btn btn-primary" data-toggle="tooltip" data-placement="right"
                                                        title="Wishlist" href="#">
                                                        <i class="fa fa-heart"></i>
                                                    </a>

                                                </div>
                                            </div>

                                        </div><!-- /.row -->
                                    </div><!-- /.price-container -->

                                    <div class="quantity-container info-container">
                                        <div class="row">

                                            {{-- <div class="col-sm-2">
                                                <span class="label">Qty :</span>
                                            </div> --}}

                                            {{-- <div class="col-sm-2">
                                                <div class="cart-quantity">
                                                    <div class="quant-input">
                                                        <div class="arrows">
                                                            <div class="arrow plus gradient"><span class="ir"><i
                                                                        class="icon fa fa-sort-asc"></i></span></div>
                                                            <div class="arrow minus gradient"><span class="ir"><i
                                                                        class="icon fa fa-sort-desc"></i></span></div>
                                                        </div>
                                                        <input type="text" value="1">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-7">
                                                <a title="Belum Aktif" href="#" class="btn btn-primary"><i
                                                        class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART</a>
                                            </div> --}}
                                            <div class="col-sm-7">
                                                @php
                                                    //get message
                                                    $message = "Halo kak. Saya tertarik dengan produk  $detailproduct->namaproduk, apa masih tersedia?";

                                                @endphp
                                                <a title="Belum Aktif"
                                                    href="https://api.whatsapp.com/send?phone=+{{ $ownerproduct->nohpusaha }}&text={{ $message }}"
                                                    class="btn btn-success"><i class="fa fa-whatsapp inner-right-vs"></i>
                                                    Whatsapp</a>
                                            </div>



                                        </div><!-- /.row -->
                                    </div><!-- /.quantity-container -->






                                </div><!-- /.product-info -->
                            </div><!-- /.col-sm-7 -->
                        </div><!-- /.row -->
                    </div>


                    <!-- ============================================== UPSELL PRODUCTS ============================================== -->
                    <section class="section featured-product wow fadeInUp">
                        <h3 class="section-title"> All Product </h3>
                        <div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">

                            @foreach ($products as $dataproduct)
                                @php
                                    $imageurl = '';
                                    $parameter = Crypt::encrypt($dataproduct->id);
                                @endphp

                                @if ($dataproduct->images != '')
                                    @foreach ($dataproduct->images as $dataimage)
                                        @php
                                            $imageurl = $dataimage->imageproducturl;
                                            break;
                                        @endphp
                                    @endforeach
                                @endif
                                <div class="item item-carousel">
                                    <div class="products">

                                        <div class="product">
                                            <div class="product-image">
                                                <div class="image">
                                                    <a href="{{ route('product.detail', $parameter) }}"><img
                                                            src="{{ asset('upload/products/' . $imageurl) }}" alt=""></a>
                                                </div><!-- /.image -->

                                                @if ($dataproduct->diskon != null || $dataproduct->diskon != '0')
                                                    <div class="tag sale">
                                                        <span>{{ $dataproduct->diskon }}%</span>
                                                    </div>
                                                @endif
                                            </div><!-- /.product-image -->


                                            <div class="product-info text-left">
                                                <h3 class="name"><a
                                                        href="{{ route('product.detail', $parameter) }}">{{ $dataproduct->namaproduk }}</a>
                                                </h3>
                                                {{-- <div class="rating rateit-small"></div> --}}
                                                <div class="description"></div>

                                                <div class="product-price">
                                                    <span class="price">
                                                        {{ $dataproduct->hargaproduk }}</span>
                                                    <span
                                                        class="price-before-discount">{{ $dataproduct->hargacoret }}</span>

                                                </div><!-- /.product-price -->

                                            </div><!-- /.product-info -->

                                        </div><!-- /.product -->

                                    </div><!-- /.products -->
                                </div><!-- /.item -->

                            @endforeach


                        </div><!-- /.home-owl-carousel -->
                    </section><!-- /.section -->
                    <!-- ============================================== UPSELL PRODUCTS : END ============================================== -->

                </div><!-- /.col -->
                <div class="clearfix"></div>
            </div><!-- /.row -->

























            <!-- ==== ================== BRANDS CAROUSEL ============================================== -->
            <div id="brands-carousel" class="logo-slider wow fadeInUp">

                <div class="logo-slider-inner">
                    <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                        <div class="item m-t-15">
                            <a href="#" class="image">
                                <img data-echo="assets/images/brands/brand1.png" src="assets/images/blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item m-t-10">
                            <a href="#" class="image">
                                <img data-echo="assets/images/brands/brand2.png" src="assets/images/blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item">
                            <a href="#" class="image">
                                <img data-echo="assets/images/brands/brand3.png" src="assets/images/blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item">
                            <a href="#" class="image">
                                <img data-echo="assets/images/brands/brand4.png" src="assets/images/blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item">
                            <a href="#" class="image">
                                <img data-echo="assets/images/brands/brand5.png" src="assets/images/blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item">
                            <a href="#" class="image">
                                <img data-echo="assets/images/brands/brand6.png" src="assets/images/blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item">
                            <a href="#" class="image">
                                <img data-echo="assets/images/brands/brand2.png" src="assets/images/blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item">
                            <a href="#" class="image">
                                <img data-echo="assets/images/brands/brand4.png" src="assets/images/blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item">
                            <a href="#" class="image">
                                <img data-echo="assets/images/brands/brand1.png" src="assets/images/blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->

                        <div class="item">
                            <a href="#" class="image">
                                <img data-echo="assets/images/brands/brand5.png" src="assets/images/blank.gif" alt="">
                            </a>
                        </div>
                        <!--/.item-->
                    </div><!-- /.owl-carousel #logo-slider -->
                </div><!-- /.logo-slider-inner -->

            </div><!-- /.logo-slider -->
            <!-- == = BRANDS CAROUSEL : END = -->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
@endsection
