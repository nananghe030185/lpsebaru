@extends('frontend.layouts.master')

@section('description', $description)
@section('title', $title)

@section('css')
@endsection

@section('jumbotron')
@endsection

@section('main')
    <section class="section-frame overflow-hidden">
        <div class="wrapper !bg-[#edf2fc]">
          	<div class="container py-14 xl:!py-24 lg:!py-24 md:!py-24 !text-center">
				<div class="flex flex-wrap mx-[-15px]">
					<div class="w-full flex-[0_0_auto] px-[15px] max-w-full !mx-auto">
						<h1 class="text-[calc(1.365rem_+_1.38vw)] font-bold leading-[1.2] xl:text-[2.4rem] !mb-3">{{ $tender->nama_paket }}</h1>
						<h2 class="lead lg:!px-[1.25rem] xl:!px-[1.25rem] xxl:!px-[2rem] leading-[1.65] text-[0.9rem] font-medium !mb-[.25rem]">{{ $tender->lpse->nama_lpse }}</h2>
					</div>
				<!-- /column -->
				</div>
				<!-- /.row -->
			</div>
		<!-- /.container -->
		</div>
		<!-- /.wrapper -->
	</section>
	<!-- /section -->
	<div class="wrapper !bg-[#ffffff]">
        <div class="container py-[4.5rem] xl:!py-24 lg:!py-24 md:!py-24">
			<div class="flex flex-wrap mx-[-15px] xl:mx-[-35px] lg:mx-[-20px]">
				<div class="xl:w-8/12 lg:w-8/12 w-full flex-[0_0_auto] px-[15px] max-w-full md:px-[20px] lg:px-[20px] xl:px-[35px]">
				<div class="blog classic-view">
					<article class="post mb-8">
						<div class="card">
						<div class="card-body flex-[1_1_auto] p-[40px] xl:p-[2rem_2.5rem_1.25rem] lg:p-[2rem_2.5rem_1.25rem] md:p-[2rem_2.5rem_1.25rem] sm:pb-4 xsm:pb-4  ">
							<div class="post-header !mb-[.9rem]">
							<h2 class="post-title mt-1 !leading-[1.35] !mb-0">{{ $tender->nama_paket }}</h2>
							</div>
							<!-- /.post-header -->
							<div class="!relative">
							<p>
								<table class="table table-striped">
									<tr>
										<td>Kode Tender</td>
										<td>{{ $tender->tender_id}}</td>
									</tr>
									<tr>
										<td>Nama LPSE</td>
										<td>{{ $tender->nama_lpse}}</td>
									</tr>
									<tr>
										<td>Nilai HPS</td>
										<td>Rp. {{ number_format($tender->hps)}}</td>
									</tr>
									<tr>
										<td>Kategori</td>
										<td>{{ $tender->kategori}}</td>
									</tr>
									<tr>
										<td>Metode Pemilihan</td>
										<td>{{ $tender->metode_pemilihan}}</td>
									</tr>
									<tr>
										<td>Metode Pengadaan</td>
										<td>{{ $tender->metode_pengadaan}}</td>
									</tr>
									<tr>
										<td>Metode Evaluasi</td>
										<td>{{ $tender->metode_evaluasi}}</td>
									</tr>
									<tr>
										<td>Tanggal Akhir Penawaran</td>
										<td>{{ Carbon\Carbon::parse($tender->tanggal_akhir_penawaran)->format('d M Y')}}</td>
									</tr>
									<tr>
										<td>Nama LPSE</td>
										<td>{{ $tender->lpse->nama_lpse }}</td>
									</tr>
									<tr>
										<td>Tahap Tender</td>
										<td>{{ $tender->tahap_tender }}</td>
									</tr>
									@if($tender->description)
										<tr>
											<td>Deskripsi</td>
											<td>{{ $tender->description }}</td>
										</tr>
									@endif
								</table>
							</p>
							</div>
							<!-- /.post-content -->
						</div>
						<!--/.card-body -->
						<div class="card-footer xl:p-[1.25rem_2.5rem_1.25rem] lg:p-[1.25rem_2.5rem_1.25rem] md:p-[1.25rem_2.5rem_1.25rem] p-[18px_40px]">
							<ul class="text-[0.7rem] text-[#aab0bc] m-0 p-0 list-none flex  !mb-0">
								<li class="post-likes !ml-auto inline-block">
									<a class="text-[#aab0bc] hover:text-[#3f78e0] hover:border-[#3f78e0]" href="/r/tender/{{ $tender->slug }}" target="_blank">
										<i class="uil uil-outbox-alt pr-[0.2rem] align-[-.05rem] before:content-['\eb60']"></i>Kunjungi Halaman LPSE
									</a>
								</li>
							</ul>
							<!-- /.post-meta -->
						</div>
						<!-- /.card-footer -->
						</div>
						<!-- /.card -->
					</article>

				</div>
              <!-- /nav -->
            </div>
            <!-- /column -->
            @include('frontend.layouts.sidebar')
            <!-- /column .sidebar -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container -->
      </div>
      <!-- /section -->
@endsection

@section('script')
@endsection