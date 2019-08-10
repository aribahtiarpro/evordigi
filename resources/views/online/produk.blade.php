@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row">
        <div class="col-md-12 pb-4 mt-lg-4">
            <a href="/" class="animated swing col-md-2 btn btn-warning btn-topleft float-left btn-sm mb-4">
                <img width="90%" src="/logo-p.png" alt="">
            </a>
            <div class="col-md-10 float-right">
                <div class="row">
                    <div class="col-md-4 px-4 pb-4">
                        <select class="form-control" id="tokoId">
                            <option  selected value="">Semua Brand</option>
                            @foreach (App\User::all()->sortBy("name") as $u)
                                <option value="{{$u->id}}">{{ '@'.$u->username}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 px-4 pb-4">
                        <select class="form-control" id="urutkan">
                            <option selected value="terbaru">Terbaru</option>
                            {{-- <option value="terlaris">Terlaris</option> --}}
                            <option value="termurah">Termurah</option>
                            <option value="termahal">Termahal</option>
                        </select>
                    </div>
                    <div class="col-md-4 px-4 pb-4">
                        <select class="form-control" id="kategori">
                            <option selected value="">Semua Kategori</option>
                            <option value="wedding">Wedding</option>
                            <option value="birthday">Birthday</option>
                        </select>
                    </div>
                    <div class="col-md-4 px-4 pb-4">
                        <select class="form-control" id="kota">
                            <option selected value="">Semua Kota</option>
                            <option value="tasikmalaya">Tasikmalaya</option>
                            <option value="bandung">Bandung</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 px-4 pb-4">
                        <input class="form-control" id="searchData" type="text" placeholder="Cari">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            {{-- List Produk --}}
            <div class="row pr-2 animated slideInLeft" id="listproduk"></div>
            {{-- Lebih Banyak --}}
            <div class="text-center py-4 mb-4">
                <input type="hidden" id="loadMore" value="1">
                <div id="btn-lebih-banyak"></div>
            </div>
        </div>
    </div>
   </div>
</div>


<div id="modalDetail"></div>

@section('js-after')
    <script>


    // Ambil Produk
    function ambilProduk(page){
        let toko = $("#tokoId").val();
        let urutkan = $("#urutkan").val();
        let search = $("#searchData").val();

        $.get("/online/produk?page="+page,{
            search: search,
            urutkan: urutkan,
            toko: toko
        })
        .done((res) => {
            $("#loadMore").val(page+1);
            let d = res.data;
            let data = '';
            for (let i = 0; i < d.length; i++) {
                let data1 = JSON.stringify(d[i]);
                data += `<div class="col-md-6 col-lg-4 my-2 " onclick='lihatDetail(${data1})'>
                            <div class="row ml-1 produk">
                                <div class="col-5 pl-0 pb-0">
                                    <img  src="/img/${d[i].img}" class="card-img-top btn-circle" alt="...">
                                </div>
                                <div class="col-7">
                                    <h5 class="pt-2">${d[i].nama}</h5>
                                    <h6 class="p-0">
                                        @${d[i].username}
                                    </h6>
                                    <span>Rp. ${d[i].harga} </span>
                                    <button class="btn btn-warning  float-right btn-edit btn-circle m-2 btn-sm"><i class="fa fa-fire"></i> Book Now</button>
                                </div>
                            </div>
                        </div>`;
            }

            if(res.total > 9 && res.last_page != page){
                $("#btn-lebih-banyak").html(`<button class="btn btn-secondary btn-sm btn-topleft" onclick="loadMore()"><i class="fa fa-arrow-right"></i> Lebih Banyak</button>`);
            }else{
                $("#btn-lebih-banyak").html("");
            }
            if(page > 1){
                $("#listproduk").append(data);
            }else{
                $("#listproduk").html(data);
            }

            
        })
    }
    ambilProduk(1);


    function lihatDetail(d){
        // console.log(data);
        let modalDetail = `<div class="modal animated jello" id="modalD">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content p-lg-4 btn-circle">
                                        <div class="col-md-12">
                                            <div class="row animated zoomIn faster">
                                                <div class="col-md-12 col-lg-5 px-0 pb-0">
                                                    <img src="/img/${d.img}" class="card-img-top btn-circle" alt="...">
                                                </div>
                                                <div class="col-md-12 col-lg-7">
                                                        <button data-dismiss="modal" class="btn btn-secondary btn-sm float-right btn-edit btn-circle m-2"><i class="fa fa-close"></i></button>
                                                    <a class="nav-link p-0" href="#">
                                                        <h4 class="pt-2">
                                                            ${d.nama}
                                                        </h4>
                                                    </a>
                                            
                                                    <h6 class="pt-2">
                                                        <a class="nav-link p-0" href="#">@${d.username}</a>
                                                    </h6>
                                                    <span>Rp. ${d.harga} </span>
                                                    <br>
                                                    <span>Stok : ${d.stok}</span>
                                                    <br>
                                                    <p> ${d.deskripsi}...</p>
                                                    <div class="row pt-4">
                                                        <div class="col-md-12 form-group">
                                                            <label>Tanggal : </label>
                                                            <input id="tanggal" type="text" class="form-control" value="">
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label>Catatan : </label>
                                                            <textarea placeholder="Paket Lengkap ya :)" class="form-control btn-topleft p-4"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <button class="btn btn-warning float-right btn-edit btn-circle m-2"><i class="fa fa-fire"></i> Booking Now </button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            </div>`;

    

        $("#modalDetail").html(modalDetail);
        $("#modalD").modal("show");

        $('#tanggal').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoApply": true,
            "startDate": "08/03/2019",
            "endDate": "08/09/2019",
            "opens": "right",
            "drops": "up"
        }, function(start, end, label) {
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

    }
    function loadMore(){
        let page  = $("#loadMore").val();
        ambilProduk(page);
    }

    // Urutkan

    

    $('#searchData').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            ambilProduk(1);
        }
    });


    $('#urutkan').select2({
        theme: "bootstrap"
    });
    $('#tokoId').select2({
        theme: "bootstrap"
    });
    $('#kategori').select2({
        theme: "bootstrap"
    });
    $('#kota').select2({
        theme: "bootstrap"
    });

    $('#urutkan').on('select2:select', function (e) {
        ambilProduk(1);
    });

    $('#tokoId').on('select2:select', function (e) {
        ambilProduk(1);
    });

 
    </script>
@endsection

@endsection

