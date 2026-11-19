@extends('frontend.layouts.master')

@section('description', $description)
@section('title', $title)

@section('css')
@endsection

@section('jumbotron')
  @include('frontend.layouts.jumbotron')
@endsection

@section('main')
    <section class="wrapper !bg-[#ffffff] mt-10 ">
        <div class="container pt-20 xl:pt-28 lg:pt-28 md:pt-28 pb-16 xl:pb-20 lg:pb-20 md:pb-20">
          <h2 class="text-[calc(1.285rem_+_0.42vw)] font-bold xl:text-[1.6rem] leading-[1.3] mb-7 !text-center">Harga Layanan Kami</h2>
          <div class="pricing-wrapper">
            <div class="flex flex-wrap items-center justify-center switcher">
              <p class="!mb-0 !pr-[.75rem]">Bulanan</p>
              <div class="pricing-switchers w-8 h-4 clear-both !text-center !relative bg-[rgba(30,34,40,0.07)] box-content rounded-3xl border-[0.2rem] border-solid border-transparent">
                <div class="pricing-switcher pricing-switcher-active cursor-pointer w-full float-left h-4 leading-4 !relative z-[888] transition-[0.3s] duration-[ease-in-out] uppercase text-white"></div>
                <div class="pricing-switcher cursor-pointer w-full float-left h-4 leading-4 !relative z-[888] transition-[0.3s] duration-[ease-in-out] uppercase"></div>
                <div class="h-4 w-4 block absolute z-[555] transition-[0.3s] duration-[ease-in-out] m-0 rounded-[100%] border-[none] left-0 top-0 !bg-[rgba(63,120,224)] opacity-100 switcher-button"></div>
              </div>
              <p class="!mb-0 !pl-3 !relative">Tahunan <span class="text-[#e2626b]">(Hemat 30%)</span></p>
            </div>
  
            <div class="flex flex-wrap mx-0 !mt-2">
              <div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] max-w-full mt-[30px]">
                <div class="pricing card !shadow-none !border-0">
                  <div class="card-body flex-[1_1_auto] py-[60px] px-[40px] !border-0 border-[#fff]">
                    <div class="icon btn btn-circle btn-lg btn-soft-primary pointer-events-none !p-0 xl:text-[1.3rem] !w-12 !h-12 !text-[calc(1.255rem_+_0.06vw)] inline-flex items-center justify-center leading-none !rounded-[100%]"> <i class="uil uil-shopping-bag before:content-['\ecba']"></i> </div>
                    <h4 class="card-title">Trial</h4>
                    <div class="prices text-[#343f52]">
                      <div class="price price-show !justify-start">
						<span class="price-currency">Rp</span><span class="price-value">0</span> <span class="price-duration">14 Hari</span>
						<div class="price price-hide price-hidden !justify-start"><span class="price-currency">Rp</span><span class="price-value">0</span> <span class="price-duration">14 Hari</span></div>
					</div>
                      </div>
                    <!--/.prices -->
                    <ul class="pl-0 list-none bullet-bg bullet-soft-primary mt-7 !mb-8">
						<li class="relative pl-6 mt-[0.35rem]">
							<i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
							<span><strong>Dashboard</strong> Member </span>
						</li>
						<li class="relative pl-6 mt-[0.35rem]">
							<i class="uil uil-check absolute left-0 w-4 h-4 text-[0.8rem] leading-none tracking-[normal] !text-center flex items-center justify-center bg-[#dce7f9] text-[#3f78e0] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i>
							<span><strong>1</strong> Kata Kunci </span>
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
                    <a href="#" class="btn btn-soft-primary !rounded-[50rem] hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.05)]">Choose Plan</a>
                  </div>
                  <!--/.card-body -->
                </div>
                <!--/.pricing -->
              </div>
              <!--/column -->
              <div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] max-w-full mt-[30px]">
                <div class="pricing card !shadow-none !border-0">
                  <div class="card-body flex-[1_1_auto] py-[60px] px-[40px] !border-0 border-[#fff]">
                    <div class="icon btn btn-circle btn-lg btn-soft-primary pointer-events-none !p-0 xl:text-[1.3rem] !w-12 !h-12 !text-[calc(1.255rem_+_0.06vw)] inline-flex items-center justify-center leading-none !rounded-[100%]"> <i class="uil uil-shopping-cart-alt before:content-['\ecbc']"></i> </div>
                    <h4 class="card-title">Personal</h4>
                    <div class="prices text-[#343f52]">
                      <div class="price price-show !justify-start"><span class="price-currency">Rp</span><span class="price-value">350Rb</span> <span class="price-duration">3 Bulan</span></div>
                      <div class="price price-hide price-hidden !justify-start"><span class="price-currency">Rp</span><span class="price-value">350Rb</span> <span class="price-duration">3 Bulan</span></div>
                    </div>
                    <!--/.prices -->
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
                    <a href="#" class="btn btn-soft-primary !rounded-[50rem] hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.05)]">Choose Plan</a>
                  </div>
                  <!--/.card-body -->
                </div>
                <!--/.pricing -->
              </div>
              <!--/column -->
              <div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] max-w-full mt-[30px]">
                <div class="pricing card !bg-[#edf2fc]">
                  <div class="card-body flex-[1_1_auto] py-[60px] px-[40px] !border-0 border-[#fff]">
                    <div class="icon btn btn-circle btn-lg btn-primary text-white !bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#3f78e0] hover:border-[#3f78e0] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#3f78e0] active:border-[#3f78e0] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] pointer-events-none !p-0 xl:text-[1.3rem] !w-12 !h-12 !text-[calc(1.255rem_+_0.06vw)] inline-flex items-center justify-center leading-none !rounded-[100%]"> <i class="uil uil-store before:content-['\ed04']"></i> </div>
                    <h4 class="card-title">Premium</h4>
                    <div class="prices text-[#343f52]">
                      <div class="price price-show !justify-start"><span class="price-currency">Rp</span><span class="price-value">150Rb</span> <span class="price-duration">Bulan</span></div>
                      <div class="price price-hide price-hidden !justify-start"><span class="price-currency">Rp</span><span class="price-value">1,2Jt</span> <span class="price-duration">Bulan</span></div>
                    </div>
                    <!--/.prices -->
                    <ul class="pl-0 list-none bullet-bg bullet-primary mt-7 !mb-8">
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
                    <a href="#" class="btn btn-primary text-white !bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#3f78e0] hover:border-[#3f78e0] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#3f78e0] active:border-[#3f78e0] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] !rounded-[50rem] hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">Choose Plan</a>
                  </div>
                  <!--/.card-body -->
                </div>
                <!--/.pricing -->
              </div>
              <!--/column -->
              <div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] max-w-full mt-[30px]">
                <div class="pricing card !shadow-none !border-0">
                  <div class="card-body flex-[1_1_auto] py-[60px] px-[40px] !border-0 border-[#fff]">
                    <div class="icon btn btn-circle btn-lg btn-soft-primary pointer-events-none !p-0 xl:text-[1.3rem] !w-12 !h-12 !text-[calc(1.255rem_+_0.06vw)] inline-flex items-center justify-center leading-none !rounded-[100%]"> <i class="uil uil-store-alt before:content-['\ecf9']"></i> </div>
                    <h4 class="card-title">Corporate</h4>
                    <div class="prices text-[#343f52]">
                      <div class="price price-show !justify-start"><span class="price-currency">Rp</span><span class="price-value">125Rb</span> <span class="price-duration">Bulan</span></div>
                      <div class="price price-hide price-hidden !justify-start"><span class="price-currency">Rp</span><span class="price-value">2Jt</span> <span class="price-duration">Tahun</span></div>
                    </div>
                    <!--/.prices -->
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
                    <a href="#" class="btn btn-soft-primary !rounded-[50rem] hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.05)]">Choose Plan</a>
                  </div>
                  <!--/.card-body -->
                </div>
                <!--/.pricing -->
              </div>
            </div>
            <!--/.row -->
          </div>
          <!--/.pricing-wrapper -->
        </div>
    </section>
@endsection

@section('script')
@endsection