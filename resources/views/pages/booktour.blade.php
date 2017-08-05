@extends('layout.master')
@section('title')
Book tour
@endsection
<link rel="stylesheet" type="text/css" href="user_asset/css/slide_hotel.css" />
@section('content')
<article class="col-sm-push-3 col-sm-9">

    <!--Thông tin tour + đặt tour-->
    <div class="hotel_name">
        <div class="name_star">
            <h1>{{$tour->tour_name}}</h1>
        </div>
    </div>
    <!-- hành trình tour -->
    <div class="position">
        <i class="fa fa-map-marker" aria-hidden="true"></i>
        <span style="font-size: 130%">
            <?php
                $journey = $tour->journey;//có dạng list các id của các place
                $placeList = explode('-', $journey);
                $journeyTour = "";
                foreach($placeList as $placeId) {
                    foreach($places as $place) {
                        if($place->place_id == $placeId) {
                            $journeyTour .= $place->place_name.', ';
                        }
                    }
                }
                //loại bỏ ký tự ', ' cuối cùng trong chuỗi
                echo substr($journeyTour,0,-2);
            ?>
        </span>
    </div>
    <!-- end: hành trình tour -->

    <div class="hotel_item row">
        <div class="col-sm-8  image_hotel">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">

                <!-- Wrapper for slides -->
                <?php $i = 0; ?>
                <div class="carousel-inner">
                        @foreach($tourImages as $img)
                            @if($img->tour_id == $tour->tour_id)
                                @if($i == 0)
                                    <div class="item active">
                                @else
                                    <div class="item">
                                @endif
                                <img src="{{$img->image}}" alt="tour_image" style="height: 40%;">
                            </div>
                            <?php ++$i; ?>
                            @endif
                        @endforeach
                </div>

                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <!-- hiển thị dấu chấm tròn trên slide ảnh tour -->
                    @for($j = 0; $j < $i; $j++)
                        @if($j == 0)
                            <li data-target="#myCarousel" data-slide-to="{{$j}}" class="active"></li>
                        @else
                            <li data-target="#myCarousel" data-slide-to="{{$j}}"></li>
                        @endif
                    @endfor
                    <!-- end: hiển thị dấu chấm tròn trên slide ảnh tour -->
                </ol>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
            <!-- thông tin tỏur -->
            <div class="col-sm-4  info_hotel">
                <h3><a>Thông tin tour</a> </h3>
                <div class="hotel_border">
                    <div class="hotel_address">
                        <p class="kichThuocChu" style="font-size: 120%"><i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp;
                            <?php echo substr($journeyTour,0,-2); ?>
                        </p>
                        <p class="kichThuocChu" style="font-size: 120%">
                            <i class="fa fa-table" aria-hidden="true"></i>
                            Ngày khởi hành: {{$tour->begin_time}}
                        </p>
                    </div>
                    <div class="hotel_ultilities">
                        <ul class="list-inline">
                            <li style="font-size: 120%"><i class="fa fa-dashboard" aria-hidden="true"></i>&nbsp; {{$tour->duration}}</li>

                            <li style="font-size: 120%">
                                <?php
                                    $vehicle = $tour->vehicle;
                                    $vehicleList = explode('-', $vehicle);
                                    foreach($vehicleList as $vehicleId) {
                                        foreach($tourVehicles as $vhc) {
                                            if($vhc->vehicle_id == $vehicleId) {
                                                ?>
                                                <i class="<?php echo $vhc->class_name; ?>" aria-hidden="true"></i>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            Phương tiện
                            </li>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="booking">
                    <div style="font-size: 2em; text-align: right;">
                        <strong>Giá tour: </strong>
                    </div>
                    <div class="book_hotel">
                        <div class="hotel_price" style="font-size: 170%">
                            <del>
                                <?php echo number_format((float)$tour->base_price);?> Đ
                            </del>
                        </div>
                    </div>
                    <div class="book_now" style="font-size: 170%">
                        <strong><?php echo number_format((float)$tour->sale_price); ?> Đ</strong>
                    </div>
                </div>
            </div>
            <!-- end: thông tin tour -->
        </div>

        <!--Chi tiết tour-->
        <div class="hotel_Detail">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#information" aria-controls="information" role="tab" data-toggle="tab">Tổng quan</a></li>
                <li role="presentation"><a href="#price" aria-controls="price" role="tab" data-toggle="tab">Lịch trình</a></li>
                <li role="presentation"><a href="#ultilities" aria-controls="ultilities" role="tab" data-toggle="tab">Dịch vụ</a></li>
                <li role="presentation"><a href="#appraise" aria-controls="appraise" role="tab" data-toggle="tab">Ghi chú</a></li>
            </ul>
            <div class="tab-content">

                <!-- Tổng quát -->
                <div role="tabpanel" class="tab-pane active" id="information">
                    {!!$tour->overview!!}
                </div>
                <!-- end: tổng quát -->

                <!-- lịch trình -->
                <div role="tabpanel" class="tab-pane" id="price">
                    {!!$tour->schedule!!}
                </div>
                <!-- end: lịch trình -->

                <!-- dịch vụ -->
                <div role="tabpanel" class="tab-pane" id="ultilities">
                    <div class="list_ultilities">
                        <?php
                            $serviceList = $tour->services;
                            $serviceList = explode('-', $serviceList);
                            foreach($serviceList as $serviceId) {
                                foreach($tourServices as $sv) {
                                    if($sv->service_id == $serviceId) {
                                        ?>
                                        <p><i class="fa fa-arrows" aria-hidden="true"></i> <?php echo $sv->service_name; ?></p>

                                        <?php
                                        break;
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
                <!-- end: dịch vụ -->

                <!-- ghi chú -->
                <div role="tabpanel" class="tab-pane" id="appraise">
                    {!!$tour->note!!}
                </div>
                <!-- end: ghi chú -->
            </div>
        </div>
        <hr>
        <!-- form thanh toán -->
        <!-- thông báo lỗi -->
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session('noti'))
        <div class="alert alert-success">
            {{session("noti")}}
        </div>
        @endif
        <!-- end: thông báo lỗi -->
        <form action="{{asset(route('postBookTour'))}}" id="booktour-form" method="post" style="background-color: #b2dba1; padding: 10px">
            <div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="tourId" id="tourId" value="{{$tour->tour_id}}"/>
                <div class="mda-tilte-3">
                    <span class="mda-tilte-name" style="font-weight: bold; color: red">THÔNG TIN ĐẶT TOUR CỦA KHÁCH HÀNG</span>
                </div>
                <div id="mda-guest-b" class="">

                    <div class="form-group col-md-4">
                        <label for="phone">Số điện thoại *:<span id="bookPhoneError" class="error"></span></label>
                        <input data-error="#bookPhoneError" type="text" name="phone" id="phone" class="form-control numeric" placeholder="Nhập số điện thoại" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="address">Địa chỉ *:<span id="bookAddressError" class="error"></span></label>
                        <input data-error="#bookAddressError" type="text" name="address" id="address" class=" form-control " placeholder="Nhập địa chỉ" required>
                    </div>

                    <div class="form-group col-md-8">
                        <label for="note">Ghi chú:</label>
                        <input type="text" name="note" id="note" class="form-control" placeholder="Nhập ghi chú">
                    </div>

                    <p class="clearfix"></p>
                    <div class="form-group col-md-4">
                        <label for="adult">Người lớn: </label>
                        <input type="number" name="adult" id="adult" class="form-control mda-quantity tour-quantity1 q-adult1" min="1" placeholder="Số lượng người lớn"/>

                    </div>
                    <div class="form-group col-md-4">
                        <label for="child">Trẻ em(7 - 14 tuổi ): </label>
                        <input type="number" name="child" id="child" class="form-control mda-quantity tour-quantity1 q-child1" min="0" placeholder="Số lượng trẻ em từ 7 - 14 tuổi"/>
                    </div>

                </div>
                <p class="clearfix"></p>
            </di>

            <div class="mda-tour-customer mda-price-tour-r">
                <table style="width: 100%" class="mda-table table">
                    <thead>

                    </thead>
                    <tbody id="customer-infos">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="paddingtable" colspan="4"></td>
                            <td><strong>Mã giảm giá</strong></td>
                            <td colspan="4" class="price right">
                                <div class="clearfix mda-row-f promo-box footer-sumary">
                                    <div class="mda-col mda-col-2">
                                        <span style="width:75%; float:left">
                                            <input name="discountCode" id="discountCode" style="width: 100%;" class="form-control" placeholder="Nhập M&#227; Giảm Gi&#225;" />
                                        </span> &nbsp; &nbsp;
                                        <button type="submit" class="btn btn-primary" onclick="loadDoc()">Check</button>
                                    </div>
                                </div>
                            </td>
                            <td><span id="promo-pricediscount"></span></td>
                        </tr>
                        <tr>
                            <input type="hidden" value="{{$tour->sale_price}}" name="salePrice" id="salePrice"/>
                            <td colspan="5"></td>
                            <td colspan="3"><strong>Tổng giá trị tour</strong></td>
                            <td class="price right">
                                <input type="text" value="0" readonly />
                                <span class="mda-money" id="sumary" style="max-width: 80px; text-align:right"></span>đ

                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                            <td colspan="3"><strong>Tiền đặt cọc</strong></td>
                            <td class="price right">
                                <input type="text" name="holdprice" value="0" readonly/>
                                <span class="mda-money" id="holdprice" style="max-width: 80px; text-align:right"></span>đ
                            </td>
                        </tr>

                        <tr>
                            <td colspan="5"></td>
                            <td colspan="3"><strong>Thanh toán</strong></td>
                            <td class="price right">
                                <input type="text" value="0" readonly/>
                                <span class="mda-money" id="payprice" style="max-width: 80px; text-align:right"></span>đ
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <p class="clearfix"></p>
            <div>
                <div class="mda-tilte-3">
                    <span class="mda-tilte-name" style="font-weight: bold; color: red">Hình thức thanh toán</span>
                </div>
                <label class="radio-inline">
                    <input type="radio" name="paymethod" checked value="mallualy" class="payment-method"><strong>Thanh toán tại công ty</strong>
                </label>
                <label class="radio-inline">
                    <input type="radio" name="paymethod"  value="bankCard" class="payment-method"><strong>Thanh to&#225;n qua thẻ ngân hàng</strong>
                </label>
            </div>

            <p class="clearfix"></p>
            <div class="mda-provision">
                <h3>Điều khoản thanh toán</h3>
                <div style="height: 150px; width: 760px; width: auto; overflow: auto; border: 1px solid #ccc;">
                    <h4 style="text-align:justify"> CÁC HÌNH THỨC THANH TOÁN TẠI DU LỊCH SUNSHINE</h4>

                    <p style="text-align:justify"><strong>1, Thanh toán bằng tiền mặt:</strong></p>

                    <p style="text-align:justify">Qúy khách vui lòng đến trụ sở của công ty hoặc các chi nhánh văng phòng của công ty du lịch VIETTRAVEL để thanh toán</p>

                    <p style="text-align:justify"><strong>2, H&igrave;nh thức chuyển khoản ng&acirc;n h&agrave;ng:</strong></p>

                    <p style="text-align:justify">T&ecirc;n t&agrave;i khoản: C&Ocirc;NG TY CỔ PHẦN TRUYỀN TH&Ocirc;NG DU LỊCH VIỆT</p>

                    <p style="text-align:justify">Ngân hàng: </p>
                    <p>
                        AGRIBANK &ndash; T&agrave;i khoản: 123456782902
                    </p>
                    <p>
                        MB &ndash; T&agrave;i khoản: 1234567899811
                    </p>
                    <p>
                        ACB &ndash; T&agrave;i khoản: 123456789872
                    </p>

                    <p style="text-align:justify">Qu&yacute; kh&aacute;ch vui l&ograve;ng li&ecirc;n hệ với <span style="color:#FF0000"><strong>HOTLINE:&nbsp;&Acirc;u - &Uacute;c - Mỹ: 0938.30.44.88 | Ch&acirc;u &Aacute;: 0938.346.588 | Trong nước: 0909.189.888 &nbsp;để được hỗ trợ, tư vấn chi tiết </strong></span>về h&igrave;nh thức thanh to&aacute;n chuyển khoản.</p>

                    <p style="text-align:justify">Khi thực hiện việc chuyển khoản, qu&yacute; kh&aacute;ch vui l&ograve;ng ghi r&otilde; họ t&ecirc;n, địa chỉ, điện thoại v&agrave; nội dung chuyến du lịch cụ thể đ&atilde; được qu&yacute; kh&aacute;ch chọn đăng k&yacute;.<br />
                        Sau khi thực hiện việc chuyển khoản, qu&yacute; kh&aacute;ch vui l&ograve;ng Fax Ủy Nhiệm Chi về c&ocirc;ng ty v&agrave; liện hệ nh&acirc;n vi&ecirc;n phụ tr&aacute;ch tuyến để nhận được v&eacute; du lịch ch&iacute;nh thức từ c&ocirc;ng ty Du Lịch Việt.</p>
                    </div>

                </div>
                <br />
                <div class="pull-left">
                    <label class="radio-inline"><input type="checkbox" name id="accept-policy" required><strong> Tôi đã đọc và chấp nhận điều khoản trên</strong></label>
                </div>
                <!-- <input type="hidden" name="codeDay" id="codeDay" value="15-07-2017" />
                <input type="hidden" name="customerlistjson" id="customerlist-json" />
                <input type="hidden" id="valid-customerjson" />
                <input type="hidden" name="type" value="3" />
                <input type="hidden" id="sumary-post" name="sumary" value="0" />
                <input type="hidden" name="scheduleid" value="1cwPgwrvoPI%3d" /> -->
                <div class="panel-body">
                    <div class=" clearfix pull-right">
                        <input class="btn btn-success" type="submit" value="HOÀN TẤT ĐẶT TOUR" />
                    </div>
                </div>
            </form>
            <!-- end: form thanh toán -->
            <div>
                <div class="hotel_relate">
                    <h3>Tour du lịch liên quan</h3>
                    <div class="row">
                        @foreach($relativeTours as $relativeTour)
                            <div class="col-sm-4">
                                <div class="hr_item">
                                    <!-- giá tour liên quan -->
                                    <div class="">
                                        <strong class="btn btn-primary"><?php echo number_format((float)$relativeTour->sale_price); ?> Đ</strong>

                                        <a href="{{asset(route('getBookTour', ['tourId' => $relativeTour->tour_id]))}}" class="btn btn_slide">Đặt tour ngay</a>
                                    </div> <br>
                                    <!-- end: giá tour liên quan -->

                                    <div class="image_hotel">
                                        @foreach($tourImages as $img)
                                            @if($img->tour_id == $relativeTour->tour_id)
                                                <a href="{{asset(route('getDetailTour', ['idTour' => $relativeTour->tour_id]))}}"><img src="{{$img->image}}" alt="tour_image" class="img-responsive"></a>
                                                <?php break; ?>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="info_hotel">
                                    <h3><a href="{{asset(route('getDetailTour', ['idTour' => $relativeTour->tour_id]))}}">{{$relativeTour->tour_name}}</a> </h3>
                                    <!-- giá vé tour -->

                                    <!-- end: giá vé tour -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </article>
            @endsection

            <!-- chèn phần tìm kiếm -->
            @section('sidebar')
            @include('layout.sidebar')
            @endsection

            @section('script')
            <script>
            function loadDoc() {
                var xhttp = new XMLHttpRequestObject();
            }
            </script>
            @endsection

            <!-- <script type="text/javascript" src="user_asset/js/jquery.tmpl.min.js"></script>
            <script type="text/javascript" src="user_asset/js/jquery.easing.1.3.js"></script>
            <script type="text/javascript" src="user_asset/js/jquery.elastislide.js"></script>
            <script type="text/javascript" src="user_asset/js/gallery.js"></script> -->
