@extends('layouts.home')

@section('title', 'Home')

@section('navbar')
    <x-navbar-color />
@endsection

@section('content')
    <div class="mt-8 px-15 mb-8">
        <h3 class="font-bold text-[24px]">Pasar Kota Yogyakarta</h3>
        <!-- section filter -->
        <div class="mt-4 flex gap-4 ">
            <div>
                <label for="kategori" class="block">Pilih Pasar</label>
                <select id="kategori" name="kategori"
                    class="border border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                    <option value="#">Semua Pasar</option>
                    <option value="Pasar">Pasar Bringharjo</option>
                    <option value="Pasar">Pasar Legi Kotagede Yogyakarta </option>
                    <option value="Pasar">Pasar Tradisional Ngasem</option>
                    <option value="Pasar">Pasar Pingit</option>
                    <option value="Pasar">Pasar Lempuyangan</option>
                    <option value="Pasar">Pasar Giwangan</option>
                    <option value="Pasar">Pasar Tradisional Kranggan</option>
                    <option value="Pasar">Pasar Gading</option>
                    <option value="cabai">Pasar Prawirotaman</option>
                    <option value="telur">Pasar Sentul Yogyakarta</option>
                    <option value="telur">Pasar Legi Patangpuluhan</option>
                </select>
            </div>
            <button class="p-2 w-8 h-8 rounded-lg bg-secondary self-end cursor-pointer">
                <i data-lucide="search" class="place-self-center w-4 h-4 text-white"></i>
            </button>
        </div>
        <!-- card pasar -->
        <div class="grid grid-cols-2 w-auto space-x-4">
            <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl">
                <div class="">
                    <img src="{{ asset('images/pprawirotaman.png') }}" class="w-100 h-50 object-cover rounded-lg">
                </div>
                <div class="ml-4">
                    <h6 class="font-bold">Pasar Bringharjo</h6>
                    <p class="text-justify">
                        Pasar Bringharjo, yang berada di pusat Kota Yogyakarta, merupakan salah satu pasar tertua dan paling
                        ramai di kota ini. Pasar ini terkenal sebagai pusat batik serta kain tradisional, selain menyediakan
                        kebutuhan sehari-hari seperti sayuran, buah, dan lauk-pauk. Karena lokasinya strategis dekat dengan
                        kawasan wisata Malioboro, pasar ini sering dikunjungi oleh warga lokal dan wisatawan untuk berburu
                        oleh-oleh khas Jogja.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl">
                <div class="">
                    <img src="{{ asset('images/pprawirotaman.png') }}" class="w-100 h-50 object-cover rounded-lg">
                </div>
                <div class="ml-4">
                    <h6 class="font-bold">Pasar Kranggan</h6>
                    <p class="text-justify">
                        Pasar Kranggan di Jalan Pangeran Diponegoro, Yogyakarta, telah mengalami transformasi—tidak hanya
                        menjadi pasar tradisional yang menjual sayur dan kebutuhan rumah tangga, tetapi juga menghadirkan
                        lantai dua yang khusus untuk kuliner kekinian seperti dessert, roti bakar, dan teh tarik dalam gaya
                        kopitiam. Hal ini menjadikan Pasar Kranggan sebagai lokasi yang menarik terutama bagi generasi muda
                        yang ingin pengalaman belanja sekaligus kuliner.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl">
                <div class="">
                    <img src="{{ asset('images/pprawirotaman.png') }}" class="w-100 h-50 object-cover rounded-lg">
                </div>
                <div class="ml-4">
                    <h6 class="font-bold">Pasar Legi Kotagede</h6>
                    <p class="text-justify">
                        Terletak di kawasan Kotagede yang kaya sejarah, Pasar Legi Kotagede bahkan berdiri sejak tahun 1549
                        atas prakarsa Ki Ageng Pamanahan. Pasar ini bukan hanya tempat jual-beli kebutuhan pokok tetapi juga
                        pusat kerajinan, batik, dan jajanan tradisional, serta masih menggunakan sistem “hari pasaran” Jawa
                        (Legi) hingga kini.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl">
                <div class="">
                    <img src="{{ asset('images/pprawirotaman.png') }}" class="w-100 h-50 object-cover rounded-lg">
                </div>
                <div class="ml-4">
                    <h6 class="font-bold">Pasar Gading</h6>
                    <p class="text-justify">
                        Pasar Gading yang beralamat di Jalan DI Panjaitan, Mantrijeron, Yogyakarta, dikenal sebagai pasar
                        yang buka dari pagi hingga malam hari (sekitar pukul 05.00-21.00) dengan penjual yang menyediakan
                        sayur mayur segar, bumbu dapur, dan juga terdapat warung sate legendaris bernama “Sate Gading” yang
                        mulai buka sore hari.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl">
                <div class="">
                    <img src="{{ asset('images/pprawirotaman.png') }}" class="w-100 h-50 object-cover rounded-lg">
                </div>
                <div class="ml-4">
                    <h6 class="font-bold">Pasar Ngasem</h6>
                    <p class="text-justify">
                        Pasar Ngasem di Jalan Polowijan, Patehan, Kecamatan Keraton, Yogyakarta, awalnya terkenal sebagai
                        pusat perdagangan burung — kegiatan yang telah ada sejak abad 1800-an. Kini pasar ini juga menjual
                        berbagai kuliner tradisional dan menjadi tempat wisata kuliner pagi yang populer karena lokasinya
                        dekat dengan kawasan wisata sejarah seperti Taman Sari.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl">
                <div class="">
                    <img src="{{ asset('images/pprawirotaman.png') }}" class="w-100 h-50 object-cover rounded-lg">
                </div>
                <div class="ml-4">
                    <h6 class="font-bold">Pasar Prawirotaman</h6>
                    <p class="text-justify">
                        Pasar Prawirotaman telah melakukan revitalisasi dan kini memiliki fasilitas modern seperti lift,
                        ruang kreatif, lounge, serta area rooftop yang digunakan sebagai tempat nongkrong dan kuliner. Pasar
                        ini menggabungkan fungsi tradisional pasar rakyat dengan ekonomi kreatif, menjadikannya salah satu
                        pasar yang disasar oleh kalangan milenial di Yogyakarta.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl">
                <div class="">
                    <img src="{{ asset('images/pprawirotaman.png') }}" class="w-100 h-50 object-cover rounded-lg">
                </div>
                <div class="ml-4">
                    <h6 class="font-bold">Pasar Lempuyangan</h6>
                    <p class="text-justify">
                        Pasar Lempuyangan di Jalan Hayam Wuruk, Tegal Panggung, Kota Yogyakarta, merupakan pasar relokasi
                        dari pasar Reksonegaran (1984) dan diresmikan 22 Februari 1986. Meskipun ukurannya tidak terlalu
                        besar, pasar ini populer untuk kuliner pagi dan jajanan legendaris seperti soto, jenang, serta lupis
                        yang banyak dicari oleh pengunjung lokal maupun wisatawan.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl">
                <div class="">
                    <img src="{{ asset('images/pprawirotaman.png') }}" class="w-100 h-50 object-cover rounded-lg">
                </div>
                <div class="ml-4">
                    <h6 class="font-bold">Pasar Sentul</h6>
                    <p class="text-justify">
                        Pasar Sentul yang beralamat di Jalan Sultan Agung 52, Kota Yogyakarta, telah direnovasi dan
                        direvitalisasi dengan konsep arsitektur Indische karena berada di kawasan cagar budaya Pakualaman.
                        Pasar ini memiliki lantai 1 untuk zona kering, lantai 2 untuk zona basah, dan rooftop untuk kuliner,
                        serta fasilitas ramah disabilitas.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl">
                <div class="">
                    <img src="{{ asset('images/pprawirotaman.png') }}" class="w-100 h-50 object-cover rounded-lg">
                </div>
                <div class="ml-4">
                    <h6 class="font-bold">Pasar Legi Patangpuluhan</h6>
                    <p class="text-justify">
                        Pasar Legi Patangpuluhan beralamat di Jalan Bugisan No. 128, Wirobrajan, Yogyakarta, dan resmi
                        dibuka pada 22 Februari 1986. Pasar ini menjual kebutuhan pokok seperti sayuran, bumbu dapur,
                        makanan ringan, lauk-pauk, dan peralatan rumah tangga; buka setiap hari mulai pukul 05.00 hingga
                        17.00 WIB.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl">
                <div class="">
                    <img src="{{ asset('images/pprawirotaman.png') }}" class="w-100 h-50 object-cover rounded-lg">
                </div>
                <div class="ml-4">
                    <h6 class="font-bold">Pasar Giwangan</h6>
                    <p class="text-justify">
                        Pasar Giwangan terletak di Jalan Imogiri Timur No. 212, Kota Yogyakarta, dan merupakan pasar induk
                        terbesar di DIY yang beroperasi 24 jam penuh. Pasar ini menjadi pusat distribusi buah, sayur, dan
                        kebutuhan pokok bagi wilayah Yogyakarta dan sekitarnya, dengan aktivitas paling ramai pada malam
                        hingga dini hari saat proses bongkar muat barang berlangsung.
                    </p>
                </div>
            </div>
        </div>
    @endsection
