@extends('frontend.layouts.master')

@section('description', $description)
@section('title', $title)

@section('css')
@endsection

@section('jumbotron')
  @include('frontend.layouts.jumbotron')
@endsection

@section('main')
    <!-- /section -->
    <section class="wrapper !bg-[#ffffff]">
		<div class="container pt-32 xl:pt-40 lg:pt-40 md:pt-40 pb-[4.5rem] xl:pb-24 lg:pb-24 md:pb-24">
		  <div class="flex flex-wrap mx-[-15px] !text-center">
			<div class="lg:w-10/12 xl:w-9/12 xxl:w-8/12 flex-[0_0_auto] px-[15px] max-w-full !mx-auto !relative">
			  <img src="./assets/images/svg/doodle3.svg" class="!h-[3rem] absolute hidden xl:block lg:block" style="top: -45%; left: 23%" alt="image">
			  <img src="./assets/images/svg/doodle4.svg" class="h-8 absolute hidden xl:block lg:block" style="top: 6%; right: 2%" alt="image">
			  <h2 class="text-[0.8rem] !leading-[1.35] tracking-[0.02rem] uppercase text-[#aab0bc] !mb-3">App Features</h2>
			  <h3 class="xl:text-[2rem] text-[calc(1.325rem_+_0.9vw)] font-semibold !leading-[1.2] mb-12 lg:!px-5 xl:!px-0 xxl:!px-6">Jangan biarkan kompetitor anda <span class="text-gradient gradient-7">lebih dahulu mengetahui</span> paket pekerjaan LPSE</h3>
			</div>
			<!-- /column -->
		  </div>
		  <!-- /.row -->
		  <div class="flex flex-wrap mx-[-15px] mb-40">
			<div class="xxl:w-11/12 w-full flex-[0_0_auto] px-[15px] max-w-full !mx-auto">
			  <div class="flex flex-wrap mx-[-15px] xl:mx-[-20px] lg:mx-[-20px] md:mx-[-20px] mt-[-50px] !text-center">
				<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] px-[15px] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[50px] max-w-full">
				  <div class="svg-bg svg-bg-lg !bg-[#fef3e4] !rounded-[0.8rem] mb-4"> <img src="./assets/images/icons/solid/cloud-network-2.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"> </div>
				  <h4 class="text-[1rem]">Data up to Date</h4>
				</div>
				<!--/column -->
				<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] px-[15px] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[50px] max-w-full">
				  <div class="svg-bg svg-bg-lg bg-[#e1f6f0] !rounded-[0.8rem] mb-4"> <img src="./assets/images/icons/solid/touchscreen.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"> </div>
				  <h4 class="text-[1rem]">Mudah digunakan</h4>
				</div>
				<!--/column -->
				<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] px-[15px] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[50px] max-w-full">
				  <div class="svg-bg svg-bg-lg bg-[#e9eaf8] !rounded-[0.8rem] mb-4"> <img src="./assets/images/icons/solid/lock.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"> </div>
				  <h4 class="text-[1rem]">Pembayaran Aman</h4>
				</div>
				<!--/column -->
				<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] px-[15px] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[50px] max-w-full">
				  <div class="svg-bg svg-bg-lg bg-[#f8e7ec] !rounded-[0.8rem] mb-4"> <img src="./assets/images/icons/solid/rocket.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"> </div>
				  <h4 class="text-[1rem]">Transaksi Cepat</h4>
				</div>
				<!--/column -->
				<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] px-[15px] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[50px] max-w-full">
				  <div class="svg-bg svg-bg-lg bg-[#f0eaf6] !rounded-[0.8rem] mb-4"> <img src="./assets/images/icons/solid/bar-chart.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"> </div>
				  <h4 class="text-[1rem]">Notifikasi Real Time</h4>
				</div>
				<!--/column -->
				<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] px-[15px] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[50px] max-w-full">
				  <div class="svg-bg svg-bg-lg bg-[#feece9] !rounded-[0.8rem] mb-4"> <img src="./assets/images/icons/solid/safe.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"> </div>
				  <h4 class="text-[1rem]">Online Banking</h4>
				</div>
				<!--/column -->
				<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] px-[15px] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[50px] max-w-full">
				  <div class="svg-bg svg-bg-lg bg-[#e0e9fa] !rounded-[0.8rem] mb-4"> <img src="./assets/images/icons/solid/controls.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"> </div>
				  <h4 class="text-[1rem]">Configurable Fields</h4>
				</div>
				<!--/column -->
				<div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] px-[15px] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[50px] max-w-full">
				  <div class="svg-bg svg-bg-lg !bg-[#eaf3ef] !rounded-[0.8rem] mb-4"> <img src="./assets/images/icons/solid/checked.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"> </div>
				  <h4 class="text-[1rem]">Data Lengkap</h4>
				</div>
				<!--/column -->
			  </div>
			  <!--/.row -->
			</div>
			<!-- /column -->
		  </div>
		  <!-- /.row -->
		  <div class="flex flex-wrap mx-[-15px] !text-center">
			<div class="md:w-10/12 lg:w-7/12 xl:w-7/12 w-full flex-[0_0_auto] px-[15px] max-w-full !mx-auto !relative">
			  <img src="./assets/images/svg/doodle5.svg" class="!w-[5rem] absolute hidden xl:block lg:block" data-delay="1800" style="bottom: -60%; right: 10%" alt="image">
			  <img src="./assets/images/svg/doodle6.svg" class="!h-[5rem] !absolute hidden xl:block lg:block" data-delay="1800" style="top: -40%; left: -5%" alt="image">
			  <h2 class="text-[0.8rem] tracking-[0.02rem] uppercase text-[#aab0bc] !mb-3 !leading-[1.35]">Bagaimana cara kerjanya</h2>
			  <h3 class="text-[calc(1.325rem_+_0.9vw)] font-bold !leading-[1.2] xl:text-[2rem] !mb-8 xl:!px-6">Daftar kemudian lengkapi profile anda, Dan jadilah <span class="text-gradient gradient-7">selangkah lebih maju</span> dari kompetitor anda</h3>
			</div>
			<!-- /column -->
		  </div>
		  <!-- /.row -->
		  <div class="flex flex-wrap mx-[-15px] lg:!mb-40 xl:!mb-[17.5rem]">
			<div class="xxl:w-11/12 w-full flex-[0_0_auto] px-[15px] max-w-full !mx-auto">
			  <div class="flex flex-wrap mx-[-15px] mt-[-50px] xl:mt-0 lg:mt-0 !text-center items-center">
				<div class="md:w-6/12 lg:w-4/12 xl:w-4/12 w-full flex-[0_0_auto] px-[15px] max-w-full !mx-auto mb-[-2.5rem] lg:!mb-0 xl:!mb-0 mt-[50px] xl:mt-0 lg:mt-0">
				  <figure class="mx-auto"><img src="./assets/images/photos/devices4.png" srcset="./assets/images/photos/devices4@2x.png 2x" alt="image"></figure>
				</div>
				<!-- /column -->
				<div class="w-full xl:hidden lg:hidden px-[15px] mt-[50px] xl:mt-0 lg:mt-0"></div>
				<div class="md:w-6/12 lg:w-4/12 xl:w-4/12 w-full flex-[0_0_auto] px-[15px] max-w-full lg:!-order-1 xl:!-order-1 mt-[50px] xl:mt-0 lg:mt-0">
				  <div class="!mb-8">
					<span class="xl:text-[3rem] text-[calc(1.425rem_+_2.1vw)] !leading-none mb-3 font-medium text-gradient gradient-7">01</span>
					<h4 class="text-[1rem]">Buat Akun</h4>
					<p class="mb-0 xl:!px-7">Buat akun dengan mendaftarkan diri anda <a href="{{ route('register') }}"><span class="relative z-[2] whitespace-nowrap after:content-[''] after:block after:absolute after:w-[102.5%] after:h-[30%] after:left-[-1.5%] after:z-[-1] after:transition-all after:duration-[0.2s] after:ease-in-out after:mt-0 after:rounded-[5rem] after:bottom-[9%] motion-reduce:after:transition-none after:bg-[rgba(63,120,224,.12)]">Disini</span></a></p>
				  </div>
				  <!-- /div -->
				  <div>
					<span class="xl:text-[3rem] text-[calc(1.425rem_+_2.1vw)] !leading-none mb-3 font-medium text-gradient gradient-7">02</span>
					<h4 class="text-[1rem]">Lengkapi Profile</h4>
					<p class="mb-0 xl:!px-7">Lengkapi data Profile pada menu Dashboard yang telah kami sediakan.</p>
				  </div>
				  <!-- /div -->
				</div>
				<!-- /column -->
				<div class="md:w-6/12 lg:w-4/12 xl:w-4/12 w-full flex-[0_0_auto] px-[15px] max-w-full mt-[50px] xl:mt-0 lg:mt-0">
				  <div class="!mb-8">
					<span class="xl:text-[3rem] text-[calc(1.425rem_+_2.1vw)] !leading-none mb-3 font-medium text-gradient gradient-7">03</span>
					<h4 class="text-[1rem]">Pilih Kata Kunci</h4>
					<p class="mb-0 xl:!px-7">Tentukan Kata Kunci Paket Pekerjaan yang ingin anda bidik.</p>
				  </div>
				  <!-- /div -->
				  <div>
					<span class="xl:text-[3rem] text-[calc(1.425rem_+_2.1vw)] !leading-none mb-3 font-medium text-gradient gradient-7">04</span>
					<h4 class="text-[1rem]">Notifikasi</h4>
					<p class="mb-0 xl:!px-7">Kami akan mengirimkan Notifikasi Paket Pekerjaan yang sesuai dengan kata kunci yang anda pilih secara real time pada saat paket tersebut tayang ke HP anda.</p>
				  </div>
				  <!-- /div -->
				</div>
				<!-- /column -->
			  </div>
			  <!-- /.row -->
			</div>
			<!-- /column -->
		  </div>
		  <!-- /.row -->
		</div>
		<!-- /.container -->
	  </section>
    <!-- /section -->
    <section class="wrapper image-wrapper bg-full bg-image bg-overlay bg-overlay-light-600 bg-content [background-size:100%] bg-[center_center] bg-no-repeat bg-scroll relative z-0 before:content-[''] before:block before:absolute before:z-[1] before:w-full before:h-full before:left-0 before:top-0 before:bg-[rgba(255,255,255,.6)]" data-image-src="./assets/images/photos/bg23.png">
      <div class="container py-[4.5rem] md:pt-24 lg:pt-0 xl:pt-0 xl:pb-[7rem] lg:pb-[7rem] md:pb-[7rem] !relative" style="z-index: 2;">
        <div class="flex flex-wrap mx-[-15px]">
          <div class="xl:w-11/12 xxl:w-10/12 w-full flex-[0_0_auto] px-[15px] max-w-full !mx-auto">
            <div class="lg:mt-[-10rem] xl:!mt-[-15rem] !mb-[4.5rem] xl:!mb-[6rem] lg:!mb-[6rem] md:!mb-[6rem] !rounded-[0.8rem]">
              <div class="player relative z-[2] rounded-[0.4rem]" data-plyr-provider="vimeo" data-plyr-embed-id="165101721"></div>
            </div>
            <div class="!relative">
              <img src="./assets/images/svg/doodle7.svg" class="h-7 absolute hidden xl:block lg:block" data-delay="1800" style="top: -90%; right: -3%" alt="image">
              <img src="./assets/images/svg/doodle8.svg" class="!h-[4.5rem] absolute hidden xl:block lg:block" data-delay="1800" style="top: -20%; left: -12%" alt="image">
              <h2 class="text-[0.8rem] uppercase text-[#aab0bc] mb-3 !text-center !leading-[1.35]">FAQ</h2>
              <h3 class="text-[calc(1.325rem_+_0.9vw)] font-bold !leading-[1.2] xl:text-[2rem] mb-12 lg:!px-8 xl:!px-12 !text-center">Jika anda tidak menemukan <span class="text-gradient gradient-7">jawaban</span> atas pertanyaan anda, jangan sungkan untuk kirim pertanyaan via email yang tersedia.</h3>
            </div>
            <div class="flex flex-wrap mx-[-15px]">
              <div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] px-[15px] max-w-full !mb-0">
                <div id="accordion-1" class="accordion-wrapper">
                  <div class="card accordion-item mb-5 !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)]">
                    <div class="card-header !mb-0 !p-[.9rem_1.3rem_.85rem] !border-0 !rounded-[0.4rem] !bg-inherit" id="accordion-heading-1-1">
                      <button class="!text-[#343f52] !text-[0.9rem] hover:!text-[#605dba] before:!text-[#605dba] collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-1-1" aria-expanded="false" aria-controls="accordion-collapse-1-1">Apakah saya bisa membatalkan keanggotaan ?</button>
                    </div>
                    <!-- /.card-header -->
                    <div id="accordion-collapse-1-1" class="collapse" aria-labelledby="accordion-heading-1-1" data-bs-target="#accordion-1">
                      <div class="card-body flex-[1_1_auto]  p-[0_1.25rem_.25rem_2.35rem]">
                        <p>Bisa, anda bisa saja berhenti dari keanggotaan aplikasi kami, namun invoice yang telah dibayarkan tidak dapat dikembalikan</p>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.collapse -->
                  </div>
                  <!-- /.card -->
                  <div class="card accordion-item mb-5 !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)]">
                    <div class="card-header !mb-0 !p-[.9rem_1.3rem_.85rem] !border-0 !rounded-[0.4rem] !bg-inherit" id="accordion-heading-1-2">
                      <button class="!text-[#343f52] !text-[0.9rem] hover:!text-[#605dba] before:!text-[#605dba] collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-1-2" aria-expanded="false" aria-controls="accordion-collapse-1-2">Apa saja cara pembayaran yang tersedia ?</button>
                    </div>
                    <!-- /.card-header -->
                    <div id="accordion-collapse-1-2" class="collapse" aria-labelledby="accordion-heading-1-2" data-bs-target="#accordion-1">
                      <div class="card-body flex-[1_1_auto]  p-[0_1.25rem_.25rem_2.35rem]">
                        <p>Kami menyediakan cara pembayaran virtual akun dari berbagai Bank seperti BCA, BRI, BNI, Mandiri, Permata Bank. selain itu kami juga menerima pembayaran melalui gopay, Shopeepay, Alfamart, Alfamidi, Indomaret, i.saku, Akulaku</p>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.collapse -->
                  </div>
                  <!-- /.card -->
                  <div class="card accordion-item mb-5 !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)]">
                    <div class="card-header !mb-0 !p-[.9rem_1.3rem_.85rem] !border-0 !rounded-[0.4rem] !bg-inherit" id="accordion-heading-1-3">
                      <button class="!text-[#343f52] !text-[0.9rem] hover:!text-[#605dba] before:!text-[#605dba] collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-1-3" aria-expanded="false" aria-controls="accordion-collapse-1-3">Bagaimana saya mengatur akun saya ?</button>
                    </div>
                    <!-- /.card-header -->
                    <div id="accordion-collapse-1-3" class="collapse" aria-labelledby="accordion-heading-1-3" data-bs-target="#accordion-1">
                      <div class="card-body flex-[1_1_auto]  p-[0_1.25rem_.25rem_2.35rem]">
                        <p>setelah anda daftar, anda dapat mengatur akun sendiri melalui menu dashboard yang telah kami sediakan, dalam menu dashboard ada banyak fitur yang bisa anda nikmati seperti data semua tender LPSE, data Lelang Sirup, data Profile akun dan menu Invoice untuk menambah masa aktif akun anda</p>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.collapse -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.accordion-wrapper -->
              </div>
              <!--/column -->
              <div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] px-[15px] max-w-full">
                <div id="accordion-2" class="accordion-wrapper">
                  <div class="card accordion-item mb-5 !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)]">
                    <div class="card-header !mb-0 !p-[.9rem_1.3rem_.85rem] !border-0 !rounded-[0.4rem] !bg-inherit" id="accordion-heading-2-1">
                      <button class="!text-[#343f52] !text-[0.9rem] hover:!text-[#605dba] before:!text-[#605dba] collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-2-1" aria-expanded="false" aria-controls="accordion-collapse-2-1">Apakah saya bisa mendapatkan laporan tender ?</button>
                    </div>
                    <!-- /.card-header -->
                    <div id="accordion-collapse-2-1" class="collapse" aria-labelledby="accordion-heading-2-1" data-bs-target="#accordion-2">
                      <div class="card-body flex-[1_1_auto]  p-[0_1.25rem_.25rem_2.35rem]">
                        <p>Ya, anda bisa mendapatkan laporan semua tender yang ingin anda kerjakan, kami telah menyediakan fitur untuk mendownload laporan yang anda inginkan</p>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.collapse -->
                  </div>
                  <!-- /.card -->
                  <div class="card accordion-item mb-5 !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)]">
                    <div class="card-header !mb-0 !p-[.9rem_1.3rem_.85rem] !border-0 !rounded-[0.4rem] !bg-inherit" id="accordion-heading-2-2">
                      <button class="!text-[#343f52] !text-[0.9rem] hover:!text-[#605dba] before:!text-[#605dba] collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-2-2" aria-expanded="false" aria-controls="accordion-collapse-2-2">Apakah ada harga diskon ?</button>
                    </div>
                    <!-- /.card-header -->
                    <div id="accordion-collapse-2-2" class="collapse" aria-labelledby="accordion-heading-2-2" data-bs-target="#accordion-2">
                      <div class="card-body flex-[1_1_auto]  p-[0_1.25rem_.25rem_2.35rem]">
                        <p>Ya, kami menyediakan harga diskon sebagai promo pada moment moment tertentu seperti hari kemerdekaan, tahun baru dll, diskon tersebut dapat anda nikmati dengan memasukan kode Kupon yang kami umumkan dimedia sosial, untuk itu pantau terus sosial media kami untuk mendapatkan kode Kupon Diskon yang anda inginkan.</p>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.collapse -->
                  </div>
                  <!-- /.card -->
                  <div class="card accordion-item mb-5 !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)]">
                    <div class="card-header !mb-0 !p-[.9rem_1.3rem_.85rem] !border-0 !rounded-[0.4rem] !bg-inherit" id="accordion-heading-2-3">
                      <button class="!text-[#343f52] !text-[0.9rem] hover:!text-[#605dba] before:!text-[#605dba] collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-collapse-2-3" aria-expanded="false" aria-controls="accordion-collapse-2-3">apakah ada masa coba akun?</button>
                    </div>
                    <!-- /.card-header -->
                    <div id="accordion-collapse-2-3" class="collapse" aria-labelledby="accordion-heading-2-3" data-bs-target="#accordion-2">
                      <div class="card-body flex-[1_1_auto]  p-[0_1.25rem_.25rem_2.35rem]">
                        <p>Ya, sebelum anda memutuskan untuk membayar keanggotaan, anda dapat mencoba fitur aplikasi yang kami sediakan saat pertama kali mendaftar, masa keanggotaan masa coba (trial) dapat anda nikmati selama 14 hari dari hari pertama kami terdaftar sebagai akun</p>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.collapse -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.accordion-wrapper -->
              </div>
              <!--/column -->
            </div>
            <!--/.row -->
          </div>
          <!--/column -->
        </div>
        <!--/.row -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /section -->
    
      <!-- harga -->
      <section class="wrapper !bg-[#ffffff]">
		<div class="container py-24 xl:!py-[8rem] lg:!py-[8rem] md:!py-[8rem]">
		  <div class="flex flex-wrap mx-[-15px] !text-center">
			<div class="md:w-11/12 lg:w-9/12 xl:w-8/12 xxl:w-7/12 w-full flex-[0_0_auto] px-[15px] max-w-full !mx-auto !relative">
			  <img src="./assets/images/svg/doodle3.svg" class="!h-[3rem] absolute hidden xl:block lg:block" style="top: -20%; right: -12%" alt="image">
			  <img src="./assets/images/svg/doodle9.svg" class="!h-[7rem] absolute hidden xl:block lg:block" style="bottom: 5%; left: -17%" alt="image">
			  <h2 class="text-[0.8rem] uppercase text-[#aab0bc] mb-3 !text-center !leading-[1.35]">Kenapa pilih {{env('APP_NAME')}}?</h2>
			  <h3 class="text-[calc(1.325rem_+_0.9vw)] font-bold !leading-[1.2] xl:text-[2rem] mb-14 !text-center">Inilah beberapa  <span class="text-gradient gradient-7">Alasan</span> kenapa Pelanggan kami memilih {{env('APP_NAME')}}.</h3>
			</div>
			<!-- /column -->
		  </div>
		  <!-- /.row -->
		  <div class="flex-wrap mx-[-15px] flex items-start mb-36">
			<div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] px-[15px] max-w-full xl:!sticky lg:!sticky" style="top: 8rem;">
			  <figure class="m-0 p-0"><img class="w-full max-w-full !h-auto" src="./assets/images/photos/devices5.png" srcset="./assets/images/photos/devices5@2x.png 2x" alt="image"></figure>
			</div>
			<!-- /column -->
			<div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] px-[15px] max-w-full ml-auto">
			  <div class="flex flex-row !mb-8">
				<div>
				  <div class="svg-bg svg-bg-lg bg-[#e6e5f4] !rounded-[0.8rem] mr-5"><img src="./assets/images/icons/solid/calendar.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"></div>
				</div>
				<div>
				  <h4 class="text-[1rem]">Data Real Time</h4>
				  <p>Sistem kami bekerja 24 jam sehari setiap hari untuk menyajikan Paket Pekerjaan LPSE kemudian langsung mengabarkan kepada anda melalui beragam channel yang telah disediakan</p>
				</div>
			  </div>
			  <div class="flex flex-row !mb-8">
				<div>
				  <div class="svg-bg svg-bg-lg bg-[#e1f6f0] !rounded-[0.8rem] mr-5"><img src="./assets/images/icons/solid/currency.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"></div>
				</div>
				<div>
				  <h4 class="text-[1rem]">Multi Channel</h4>
				  <p>Notifikasi Paket Pekerjaan yang di kirim dengan beragam channel seperti email, telegram dan Whatsapp</p>
				</div>
			  </div>
			  <div class="flex flex-row !mb-8">
				<div>
				  <div class="svg-bg svg-bg-lg bg-[#f8e7ec] !rounded-[0.8rem] mr-5"><img src="./assets/images/icons/solid/server.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"></div>
				</div>
				<div>
				  <h4 class="text-[1rem]">Manajemen Data Lengkap</h4>
				  <p>Data yang kami kumpulkan bukan hanya dari LPSE, tetapi dari SIRUP sehingga anda dapat mengetahui Paket Pekerjaan sebelum tayang di LPSE</p>
				</div>
			  </div>
			  <div class="flex flex-row !mb-8">
				<div>
				  <div class="svg-bg svg-bg-lg !bg-[#fef3e4] !rounded-[0.8rem] mr-5"><img src="./assets/images/icons/solid/devices.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"></div>
				</div>
				<div>
				  <h4 class="text-[1rem]">Hemat waktu dan Tenaga anda</h4>
				  <p>Anda tidak perlu pusing mengecek LPSE satu per satu di seluruh Indonesia, biarkan sistem kami melakukannya untuk anda.</p>
				</div>
			  </div>
			  <div class="flex flex-row !mb-8">
				<div>
				  <div class="svg-bg svg-bg-lg bg-[#e0e9fa] !rounded-[0.8rem] mr-5"><img src="./assets/images/icons/solid/search.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"></div>
				</div>
				<div>
				  <h4 class="text-[1rem]">Harga Terjangkau</h4>
				  <p>Harga membership yang terjangkau dengan fitur dan informasi lengkap kami berikan untuk anda.</p>
				</div>
			  </div>
			  <div class="flex flex-row !mb-8">
				<div>
				  <div class="svg-bg svg-bg-lg !bg-[#eaf3ef] !rounded-[0.8rem] mr-5"><img src="./assets/images/icons/solid/compare.svg" class="svg-inject icon-svg solid text-[#343f52] text-navy" alt="image"></div>
				</div>
				<div>
				  <h4 class="text-[1rem]">Laporan Lengkap</h4>
				  <p>Dapatkan Laporan Lengkap Paket Pekerjaan LPSE untuk di analisa lebih lanjut.</p>
				</div>
			  </div>
			</div>
			<!-- /column -->
		  </div>
		  <!-- /.row -->
		  <div class="flex flex-wrap mx-[-15px]">
			<div class="md:w-11/12 lg:w-10/12 xl:w-9/12 xxl:w-8/12 w-full flex-[0_0_auto] px-[15px] max-w-full !mx-auto !text-center !relative">
			  <img src="./assets/images/svg/doodle1.svg" class="h-9 !absolute hidden xl:block lg:block" style="top: 2%; left: 9%" alt="image">
			  <img src="./assets/images/svg/doodle10.svg" class="h-7 absolute hidden xl:block lg:block" style="top: -45%; left: -17%" alt="image">
			  <img src="./assets/images/svg/doodle11.svg" class="!h-[4rem] absolute hidden xl:block lg:block" style="top: -40%; right: -15%" alt="image">
			  <h2 class="text-[0.8rem] tracking-[0.02rem] uppercase text-[#aab0bc] !mb-3 !leading-[1.35]">Kata Pelanggan</h2>
			  <h3 class="text-[calc(1.325rem_+_0.9vw)] font-bold !leading-[1.2] xl:text-[2rem] mb-12 xl:!px-10 xxl:!px-16">Apa kata <span class="text-gradient gradient-7">Pelanggan</span> yang telah mencoba aplikasi kami</h3>
			</div>
			<!-- /column -->
		  </div>
		  <!-- /.row -->
		  <div class="itemgrid mb-14">
			<div class="flex flex-wrap mx-[-15px] isotope mt-[-30px]">
			  <div class="item md:w-6/12 lg:w-6/12 xl:w-4/12 w-full flex-[0_0_auto] px-[15px] max-w-full mt-[30px]">
				<div class="card !shadow-none !rounded-[0.8rem] !bg-[#f0f0f8]">
				  <div class="card-body flex-[1_1_auto] p-[40px]">
					<blockquote class="!text-[0.85rem] !leading-[1.7] !font-normal pl-4 icon !mb-0 relative p-0 border-0 before:content-['\201d'] before:absolute before:top-[-1.5rem] before:left-[-0.9rem] before:text-[rgba(52,63,82,0.05)] before:text-[10rem] before:leading-none before:z-[1]">
					  <p>“Aplikasi LPSE Indonesia mudah digunakan simple but powerful, saya yang awam saja mengenai aplikasi komputer dapat langsung menggunakan Aplikasi ini ”</p>
					  <div class="flex items-center text-left">
						<div class="info !pl-0">
						  <h5 class="!mb-1 text-[.9rem] !leading-[1.5]">Rudi Setiawan</h5>
						  <p class="!mb-0 text-[.8rem]">Marketing Consultant</p>
						</div>
					  </div>
					</blockquote>
				  </div>
				  <!-- /.card-body -->
				</div>
				<!-- /.card -->
			  </div>
			  <!--/column -->
			  <div class="item md:w-6/12 lg:w-6/12 xl:w-4/12 w-full flex-[0_0_auto] px-[15px] max-w-full mt-[30px]">
				<div class="card !shadow-none !rounded-[0.8rem] !bg-[#edf9f6]">
				  <div class="card-body flex-[1_1_auto] p-[40px]">
					<blockquote class="!text-[0.85rem] !leading-[1.7] !font-normal pl-4 icon !mb-0 relative p-0 border-0 before:content-['\201d'] before:absolute before:top-[-1.5rem] before:left-[-0.9rem] before:text-[rgba(52,63,82,0.05)] before:text-[10rem] before:leading-none before:z-[1]">
					  <p>“Aplikasi ini sangat membantu sekali menemukan tender sesuai dengan bidang kami biasa kami kerjakan, semua data tender LPSE dari seluruh Indonesia tersedia dalam satu tempat jadi ga perlu repot repot saya cek satu satu seluruh LPSE yang jumlahnya ratusan, Terima kasih LPSE Indonesia”</p>
					  <div class="flex items-center text-left">
						<div class="info !pl-0">
						  <h5 class="!mb-1 text-[.9rem] !leading-[1.5]">Dadan Ramdani</h5>
						  <p class="!mb-0 text-[.8rem]">Marketing Project</p>
						</div>
					  </div>
					</blockquote>
				  </div>
				  <!-- /.card-body -->
				</div>
				<!-- /.card -->
			  </div>
			  <!--/column -->
			  <div class="item md:w-6/12 lg:w-6/12 xl:w-4/12 w-full flex-[0_0_auto] px-[15px] max-w-full mt-[30px]">
				<div class="card !shadow-none !rounded-[0.8rem] !bg-[#fef4f2]">
				  <div class="card-body flex-[1_1_auto] p-[40px]">
					<blockquote class="!text-[0.85rem] !leading-[1.7] !font-normal pl-4 icon !mb-0 relative p-0 border-0 before:content-['\201d'] before:absolute before:top-[-1.5rem] before:left-[-0.9rem] before:text-[rgba(52,63,82,0.05)] before:text-[10rem] before:leading-none before:z-[1]">
					  <p>“Sebelum menggunakan Aplikasi LPSE Indonesia biasanya kami mendapat informasi tender LPSE melalui kabar dari perusahaan lain yang mengajak kami untuk kerjasama, setelah menggunakan Aplikasi LPSE Indonesia saya jadi lebih cepat mengetahui informasi tender dari orang lain”</p>
					  <div class="flex items-center text-left">
						<div class="info !pl-0">
						  <h5 class="!mb-1 text-[.9rem] !leading-[1.5]">Ami Kurniawan</h5>
						  <p class="!mb-0 text-[.8rem]">Sales Manager</p>
						</div>
					  </div>
					</blockquote>
				  </div>
				  <!-- /.card-body -->
				</div>
				<!-- /.card -->
			  </div>
			  <!--/column -->
			  <div class="item md:w-6/12 lg:w-6/12 xl:w-4/12 w-full flex-[0_0_auto] px-[15px] max-w-full mt-[30px]">
				<div class="card !shadow-none !rounded-[0.8rem] !bg-[#fbf1f4]">
				  <div class="card-body flex-[1_1_auto] p-[40px]">
					<blockquote class="!text-[0.85rem] !leading-[1.7] !font-normal pl-4 icon !mb-0 relative p-0 border-0 before:content-['\201d'] before:absolute before:top-[-1.5rem] before:left-[-0.9rem] before:text-[rgba(52,63,82,0.05)] before:text-[10rem] before:leading-none before:z-[1]">
					  <p>“Harga untuk berlangganan Aplikasi ini sangat sangat terjangkau, Informasi tender dari ratusan juta sampai puluhan milyar bisa kita dapatkan hanya dengan membayar 350rb - 2juta, murah sekali”</p>
					  <div class="flex items-center text-left">
						<div class="info !pl-0">
						  <h5 class="!mb-1 text-[.9rem] !leading-[1.5]">Dadan Ramdani</h5>
						  <p class="!mb-0 text-[.8rem]">Marketing Manajer</p>
						</div>
					  </div>
					</blockquote>
				  </div>
				  <!-- /.card-body -->
				</div>
				<!-- /.card -->
			  </div>
			  <!--/column -->
			  <div class="item md:w-6/12 lg:w-6/12 xl:w-4/12 w-full flex-[0_0_auto] px-[15px] max-w-full mt-[30px]">
				<div class="card !shadow-none !rounded-[0.8rem] !bg-[#edf2fc]">
				  <div class="card-body flex-[1_1_auto] p-[40px]">
					<blockquote class="!text-[0.85rem] !leading-[1.7] !font-normal pl-4 icon !mb-0 relative p-0 border-0 before:content-['\201d'] before:absolute before:top-[-1.5rem] before:left-[-0.9rem] before:text-[rgba(52,63,82,0.05)] before:text-[10rem] before:leading-none before:z-[1]">
					  <p>“Aplikasi ini menyediakan berbagai chanel seperti email, telegram dan whatsapp untuk mengirimkan tender LPSE sesuai kata kunci yang kita tetapkan, simple mudah dan ga ribet, terima kasih LPSE Indonesia”</p>
					  <div class="flex items-center text-left">
						<div class="info !pl-0">
						  <h5 class="!mb-1 text-[.9rem] !leading-[1.5]">Andi Sucipta</h5>
						  <p class="!mb-0 text-[.8rem]">Marketing Manager</p>
						</div>
					  </div>
					</blockquote>
				  </div>
				  <!-- /.card-body -->
				</div>
				<!-- /.card -->
			  </div>
			  <!--/column -->
			  <div class="item md:w-6/12 lg:w-6/12 xl:w-4/12 w-full flex-[0_0_auto] px-[15px] max-w-full mt-[30px]">
				<div class="card !shadow-none !rounded-[0.8rem] !bg-[#fff8ee]">
				  <div class="card-body flex-[1_1_auto] p-[40px]">
					<blockquote class="!text-[0.85rem] !leading-[1.7] !font-normal pl-4 icon !mb-0 relative p-0 border-0 before:content-['\201d'] before:absolute before:top-[-1.5rem] before:left-[-0.9rem] before:text-[rgba(52,63,82,0.05)] before:text-[10rem] before:leading-none before:z-[1]">
					  <p>“Aplikasi LPSE Indonesia dirancang serba otomatis, mulai dari pengiriman notifikasi sampai pembayaran membership semuanya otomatis. LPSE Indonesia keren....”</p>
					  <div class="flex items-center text-left">
						<div class="info !pl-0">
						  <h5 class="!mb-1 text-[.9rem] !leading-[1.5]">Usman Sapta</h5>
						  <p class="!mb-0 text-[.8rem]">Marketing</p>
						</div>
					  </div>
					</blockquote>
				  </div>
				  <!-- /.card-body -->
				</div>
				<!-- /.card -->
			  </div>
			  <!--/column -->
			</div>
			<!-- /.row -->
		  </div>
  
		  <!-- price -->
  
		  <div class="container pt-20 xl:pt-28 lg:pt-28 md:pt-28 pb-16 xl:pb-20 lg:pb-20 md:pb-20">
			  <div class="flex flex-wrap mx-[-15px] mt-[-30px]">
				<div class="xl:w-4/12 lg:w-4/12 w-full flex-[0_0_auto] px-[15px] max-w-full mt-[30px]">
				  <h2 class="text-[calc(1.305rem_+_0.66vw)] font-bold xl:text-[1.8rem] leading-[1.3] xl:!mt-32 lg:!mt-32 !mb-3">Harga Terjangkau</h2>
				  <p class="lead !text-[1.05rem] !leading-[1.6] font-medium">Kami memberikan <span class="relative z-[2] whitespace-nowrap after:content-[''] after:block after:absolute after:w-[102.5%] after:h-[30%] after:left-[-1.5%] after:z-[-1] after:transition-all after:duration-[0.2s] after:ease-in-out after:mt-0 after:rounded-[5rem] after:bottom-[9%] motion-reduce:after:transition-none after:bg-[rgba(63,120,224,.12)]">harga terjangkau</span>, dengan Data Lengkap dan beragam fitur untuk mendukung bisnis anda.</p>
				  <p>Nikmati <a href="{{ route('register') }}" class="hover">Trial Membership</a> sebelum anda memutuskan untuk melakukan pembayaran</p>
				  <a href="/harga" class="btn btn-primary text-white !bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#3f78e0] hover:border-[#3f78e0] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#3f78e0] active:border-[#3f78e0] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] !rounded-[50rem] !mt-2 hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">Harga Lainnya</a>
				</div>
				<!--/column -->
				<div class="xl:w-7/12 lg:w-7/12 w-full flex-[0_0_auto] px-[15px] max-w-full xl:!ml-[8.33333333%] lg:!ml-[8.33333333%] pricing-wrapper mt-[30px]">
				  <div class="flex flex-wrap items-center switcher xl:!justify-end lg:!justify-end">
					<p class="!mb-0 !pr-[.75rem]">Bulanan</p>
					<div class="pricing-switchers w-8 h-4 clear-both !text-center !relative bg-[rgba(30,34,40,0.07)] box-content rounded-3xl border-[0.2rem] border-solid border-transparent">
					  <div class="pricing-switcher pricing-switcher-active cursor-pointer w-full float-left h-4 leading-4 !relative z-[888] transition-[0.3s] duration-[ease-in-out] uppercase text-white"></div>
					  <div class="pricing-switcher cursor-pointer w-full float-left h-4 leading-4 !relative z-[888] transition-[0.3s] duration-[ease-in-out] uppercase"></div>
					  <div class="h-4 w-4 block absolute z-[555] transition-[0.3s] duration-[ease-in-out] m-0 rounded-[100%] border-[none] left-0 top-0 !bg-[rgba(63,120,224)] opacity-100 switcher-button"></div>
					</div>
					<p class="!mb-0 !pl-3 !relative">Tahunan <span class="text-[#e2626b]">(Save 30%)</span></p>
				  </div>
				  <div class="flex flex-wrap mx-[-15px] mt-[25px] !relative">
					<div class="shape bg-dot primary rellax !w-[6rem] !h-[8rem] bg-[radial-gradient(#3f78e0_2px,transparent_2.5px)] absolute z-[1] opacity-50 px-[15px] mt-[30px]" data-rellax-speed="1" style="bottom: -0.5rem; right: -1.6rem;"></div>
					<div class="shape !rounded-[50%] bg-line red rellax !w-[8rem] !h-[8rem] absolute z-[1] opacity-50" data-rellax-speed="1" style="top: -1rem; left: -2rem;"></div>
  
					<div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] px-[15px] max-w-full mt-[30px]">
					  <div class="pricing card">
						<div class="card-body pb-14">
						  <div class="prices text-[#343f52]">
							<div class="price price-show !justify-start"><span class="price-currency">Rp</span><span class="price-value">150Rb</span> <span class="price-duration">Bulan</span></div>
							<div class="price price-hide price-hidden !justify-start"><span class="price-currency">Rp</span><span class="price-value">1,2 Jt</span> <span class="price-duration">Tahun</span></div>
						  </div>
						  <!--/.prices -->
						  <h4 class="card-title !mt-2">Premium</h4>
						  <ul class="pl-0 list-none bullet-bg bullet-soft-primary mt-7 !mb-8">
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Dashboard</strong> Member </span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Unlimited</strong> Kata Kunci </span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Email</strong> Notifikasi </span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Telegram</strong> Notifikasi </span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-times bullet-soft-red absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center !bg-[#fae3e4] !text-[#e2626b] rounded-[100%] top-[0.2rem] before:content-['\ed3b'] before:align-middle before:table-cell"></i>
								  <span><strong>Whatsapp</strong> Notifikasi</span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Paket LPSE</strong></span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-times bullet-soft-red absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center !bg-[#fae3e4] !text-[#e2626b] rounded-[100%] top-[0.2rem] before:content-['\ed3b'] before:align-middle before:table-cell"></i>
								  <span><strong>Paket Lelang SIRUP</strong></span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-times bullet-soft-red absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center !bg-[#fae3e4] !text-[#e2626b] rounded-[100%] top-[0.2rem] before:content-['\ed3b'] before:align-middle before:table-cell"></i>
								  <span><strong>Paket Swakelola SIRUP</strong></span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-times bullet-soft-red absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center !bg-[#fae3e4] !text-[#e2626b] rounded-[100%] top-[0.2rem] before:content-['\ed3b'] before:align-middle before:table-cell"></i>
								  <span> 7/24 <strong>Support</strong></span>
							  </li>
						  </ul>
						  <a href="{{ route('register') }}" class="btn btn-primary text-white !bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#3f78e0] hover:border-[#3f78e0] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#3f78e0] active:border-[#3f78e0] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] !rounded-[50rem] hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">Pilih Premium </a>
						</div>
						<!--/.card-body -->
					  </div>
					  <!--/.pricing -->
					</div>
					<!--/column -->
					<div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] px-[15px] max-w-full popular mt-[30px]">
					  <div class="pricing card">
						<div class="card-body pb-14">
						  <div class="prices text-[#343f52]">
							<div class="price price-show !justify-start"><span class="price-currency">Rp</span><span class="price-value">200Rb</span> <span class="price-duration">Bulan</span></div>
							<div class="price price-hide price-hidden !justify-start"><span class="price-currency">Rp</span><span class="price-value">2Jt</span> <span class="price-duration">2Tahun</span></div>
						  </div>
						  <!--/.prices -->
						  <h4 class="card-title !mt-2">Corporate</h4>
						  <ul class="pl-0 list-none bullet-bg bullet-soft-primary mt-7 !mb-8">
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Dashboard</strong> Member </span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Unlimited</strong> Kata Kunci </span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Email</strong> Notifikasi </span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Telegram</strong> Notifikasi </span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Whatsapp</strong> Notifikasi</span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Paket LPSE</strong></span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Paket Lelang SIRUP</strong></span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span><strong>Paket Swakelola SIRUP</strong></span>
							  </li>
							  <li class="relative pl-6 mt-[0.35rem]">
								  <i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
								  <span> 7/24 <strong>Support</strong></span>
							  </li>
						  </ul>
						  <a href="{{ route('register') }}" class="btn btn-primary text-white !bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#3f78e0] hover:border-[#3f78e0] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#3f78e0] active:border-[#3f78e0] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] !rounded-[50rem] hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">Pilih Corporate</a>
						</div>
						<!--/.card-body -->
					  </div>
					  <!--/.pricing -->
					</div>
					<!--/column -->
				  </div>
				  <!--/.row -->
				</div>
				<!--/column -->
			  </div>
			  <!--/.row -->
			</div>
		  <!-- /.row -->
		  <!-- /.grid-view -->
		</div>
		<!-- /.container -->
	  </section>
      <!-- end harga -->
    
      <!-- /section -->
    <section class="wrapper image-wrapper bg-full bg-image bg-overlay bg-overlay-light-600 [background-size:100%] bg-[center_center] bg-no-repeat bg-scroll relative z-0 before:content-[''] before:block before:absolute before:z-[1] before:w-full before:h-full before:left-0 before:top-0 before:bg-[rgba(255,255,255,.6)]" data-image-src="./assets/images/photos/bg23.png">
    <div class="overflow-hidden" style="z-index:1;">
    <div class="divider divider-alt text-[#fefefe] mx-[-0.5rem]">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100">
        <g fill="currentColor">
            <polygon points="1440 100 0 15 0 0 1440 0 1440 100" />
        </g>
        </svg>
    </div>
    </div>
    <!-- /.overflow-hidden -->
    <div class="container pt-10 xl:pt-10 lg:pt-10 md:pt-16 pb-8 xl:pb-10 lg:pb-10 md:pb-10 text-center xl:text-left lg:text-left">
    <div class="flex flex-wrap mx-0 mt-[-50px]">
        <div class="md:w-10/12 md:!ml-[8.33333333%] lg:!ml-0 lg:w-6/12 xl:!ml-0 xl:w-5/12 w-full flex-[0_0_auto] max-w-full !relative mt-[50px]">
        <img src="./assets/images/svg/doodle2.svg" class="!h-[5rem] !absolute hidden xl:block lg:block" style="bottom: 36%; right: -25%" alt="image">
        <img src="./assets/images/svg/doodle6.svg" class="!h-[4.5rem] !absolute hidden xl:block lg:block" style="top: -20%; left: -25%" alt="image">
        <h2 class="text-[calc(1.325rem_+_0.9vw)] font-semibold !leading-[1.2] xl:text-[2rem] mb-4">Jadilah yang terdepan sebelum <span class="text-gradient gradient-7">di dahului.</span> Kompetitor anda</h2>
        <p class="lead !text-[1.2rem] !leading-[1.5] font-normal mb-7">Take Action sekarang dan jadilah yang terdepan.</p>
        <div class="flex justify-center xl:!justify-start lg:!justify-start">
            <span class="inline-flex">
				<a href="{{ route('register') }}" class="btn btn-expand btn-primary text-white bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#3f78e0] hover:border-[#3f78e0] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#3f78e0] active:border-[#3f78e0] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] !rounded-[50rem] mr-5 mb-3 xl:!mb-0 lg:!mb-0"><i class="uil uil-arrow-right before:content-['\e94c']"></i><span>Daftar</span></a>
            </span>
        </div>
        </div>
        <!-- /column -->
        <div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] max-w-full ml-auto mt-lg-n15 xl:!mt-[-10rem] lg:!mt-[-5rem] mt-[50px]">
        <figure class="m-0 p-0"><img class="w-full max-w-full !h-auto" src="./assets/images/photos/devices6.png" srcset="./assets/images/photos/devices6@2x.png 2x" alt="image"></figure>
        </div>
        <!-- /column -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container -->
</section>
<!-- /section -->
@endsection

@section('script')
@endsection