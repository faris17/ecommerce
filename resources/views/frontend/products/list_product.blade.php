<div class="row" style="padding:10px">
    <section class="section featured-product wow fadeInUp">
        @foreach ($products as $product)
            @php
                //jika image tidak kosong
            $imageurl = ''; @endphp

            @if ($product->images != '')
                @foreach ($product->images as $dataimage)
                    @php
                        $imageurl = $dataimage->imageproducturl;
                        break;
                    @endphp
                @endforeach
            @endif
            <div class="col-md-4">
                <div class="item item-carousel">
                    <div class="products">
                        <div class="product">
                            <div class="product-image">
                                <div class="image"><a href="detail.html"><img
                                            src="{{ asset('upload/products/' . $imageurl) }}" alt="" width="50px"
                                            height="150px"></a>
                                </div>
                                <!-- /.image -->
                                @if ($product->diskon != null || $product->diskon != '0')
                                    <div class="tag sale">
                                        <span>{{ $product->diskon }}%</span>
                                    </div>
                                @endif

                            </div>
                            <!-- /.product-image -->

                            <div class="product-info text-left">
                                @php
                                    $parameter = Crypt::encrypt($product->id);
                                @endphp
                                <h3 class="name"><a
                                        href="{{ route('product.detail', $parameter) }}">{{ $product->namaproduk }}</a>
                                </h3>
                                {{-- <div class="rating rateit-small"></div> --}}
                                <div class="description"></div>
                                <div class="product-price"> <span class="price">@currency($product->hargasatuan)
                                    </span>
                                    @if ($product->hargacoret != null)
                                        <span style="color: rgb(143, 136, 136)" class="price-before-discount">
                                            @currency($product->hargacoret)
                                        </span>
                                    @endif
                                </div>
                                <!-- /.product-price -->

                            </div>
                            <!-- /.product-info -->
                            {{-- <div class="cart clearfix animate-effect">
                                        <div class="action">
                                            <ul class="list-unstyled">
                                                <li class="add-cart-button btn-group">
                                                    <button class="btn btn-primary icon" data-toggle="dropdown"
                                                        type="button"> <i class="fa fa-shopping-cart"></i> </button>
                                                    <button class="btn btn-primary cart-btn" type="button">Add to
                                                        cart</button>
                                                </li>
                                                <li class="btn-group">

                                                    <button class="btn btn-danger" type="button"> <i
                                                            class="icon fa fa-heart"></i> Wishlist</button>
                                                </li>

                                            </ul>
                                        </div>
                                        <!-- /.action -->
                                    </div> --}}
                            <!-- /.cart -->
                        </div>
                        <!-- /.product -->

                    </div>
                    <!-- /.products -->
                </div>
            </div>

        @endforeach

    </section>
</div>
<div class="col-md-12">
    {{ isset($products->links) ? $products->links('pagination::bootstrap-4') : '' }}
</div>


<style>
    #product {
        margin-left: -30px !important;
        width: 100%;
    }

</style>
