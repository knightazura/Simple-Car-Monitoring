<!-- Medium & Large viewport -->
<div class="d-none d-sm-none d-md-block">
    <div class="row justify-content-md-center mt-4">
        <div class="col-sm-12 col-md-8 col-xl-7">
            <div class="card-deck">
                <!-- 1 -->
                <div class="card text-white bg-success">
                    <div class="card-body text-center">
                        <p class="card-text">JUMLAH MOBIL YANG TERSEDIA</p>
                        <h1 class="display-1">
                            <b>{{ $highlights_data['tac'] }}</b>
                        </h1>
                    </div>
                </div>
                <!-- 2 -->
                <div class="card text-white bg-primary">
                    <div class="card-body text-center">
                        <p class="card-text">JUMLAH MOBIL YANG DIGUNAKAN</p>
                        <h1 class="display-1">
                            <b>{{ $highlights_data['tuc'] }}</b>
                        </h1>
                    </div>
                </div>
                <!-- 3 | This should be chart but unsolved how to feed the data 
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <p class="card-text">Status seluruh kendaraan saat ini</p>
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
</div>

<!-- Small viewport -->
<div class="row d-block d-sm-block d-md-none justify-content-md-center mt-4">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <p class="card-text">Jumlah mobil yang ketersediaan untuk saat ini</p>
                        <h1 class="text-center display-1">
                            <b>{{ $highlights_data['tac'] }}</b>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mt-2">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <p class="card-text">Jumlah sopir yang standby</p>
                        <h1 class="text-center display-1">
                            <b>{{ $highlights_data['tuc'] }}</b>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mt-2">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <p class="card-text">Status kendaraan lainnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
