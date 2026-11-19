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
              <div class="md:w-7/12 lg:w-6/12 xl:w-5/12 w-full flex-[0_0_auto] px-[15px] max-w-full !mx-auto">
                <h1 class="text-[calc(1.365rem_+_1.38vw)] font-bold leading-[1.2] xl:text-[2.4rem] !mb-3">{{ $title }}</h1>
                <p class="lead lg:!px-[1.25rem] xl:!px-[1.25rem] xxl:!px-[2rem] leading-[1.65] text-[0.9rem] font-medium !mb-[.25rem]">{{ $description }}</p>
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
                @foreach ($lelangs as $lelang)
                <article class="post mb-8">
                    <div class="card">
                      <div class="card-body flex-[1_1_auto] p-[40px] xl:p-[2rem_2.5rem_1.25rem] lg:p-[2rem_2.5rem_1.25rem] md:p-[2rem_2.5rem_1.25rem] sm:pb-4 xsm:pb-4  ">
                        <div class="post-header !mb-[.9rem]">
                          {{-- <div class="inline-flex mb-[.4rem] uppercase tracking-[0.02rem] text-[0.7rem] font-bold text-[#aab0bc] relative align-top pl-[1.4rem] before:content-[''] before:absolute before:inline-block before:translate-y-[-60%] before:w-3 before:h-[0.05rem] before:left-0 before:top-2/4 before:bg-[#3f78e0]">
                            <a href="#" class="hover" rel="category">Teamwork</a>
                          </div> --}}
                          <!-- /.post-category -->
                          <h2 class="post-title mt-1 !leading-[1.35] !mb-0"><a class="text-[#343f52] hover:text-[#3f78e0]" href="/lelang/{{$lelang->slug}}">{{ $lelang->nama_paket }}</a></h2>
                        </div>
                        <!-- /.post-header -->
                        <div class="!relative">
                          <p>
                            <table class="table table-striped">
                               <tr>
                                    <td>Kode RUP</td>
                                    <td>{{ $lelang->kode_rup}}</td>
                               </tr>
                               <tr>
                                    <td>Satuan Kerja</td>
                                    <td>{{ $lelang->satuan_kerja}}</td>
                               </tr>
                               <tr>
                                    <td>Nilai Pagu</td>
                                    <td>Rp. {{ number_format($lelang->pagu)}}</td>
                               </tr>
                               <tr>
                                    <td>Sumber Dana</td>
                                    <td>{{ $lelang->sumber_dana }}</td>
                               </tr>
                               <tr>
                                    <td>Jenis Pengadaan</td>
                                    <td>{{ $lelang->jenis_pengadaan}}</td>
                               </tr>
                               <tr>
                                    <td>Metode Pemilihan</td>
                                    <td>{{ $lelang->pemilihan}}</td>
                               </tr>
                               
                            </table>
                          </p>
                        </div>
                        <!-- /.post-content -->
                      </div>
                      <!--/.card-body -->
                      <div class="card-footer xl:p-[1.25rem_2.5rem_1.25rem] lg:p-[1.25rem_2.5rem_1.25rem] md:p-[1.25rem_2.5rem_1.25rem] p-[18px_40px]">
                        <ul class="text-[0.7rem] text-[#aab0bc] m-0 p-0 list-none flex  !mb-0">
                            <li class="post-likes !ml-auto inline-block">
                                <a class="text-[#aab0bc] hover:text-[#3f78e0] hover:border-[#3f78e0]" href="/r/lelang/{{ $lelang->slug }}">
                                    <i class="uil uil-heart-alt pr-[0.2rem] align-[-.05rem] before:content-['\eb60']"></i>
                                    Lelang Detail
                                </a>
                            </li>
                        </ul>
                        <!-- /.post-meta -->
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                  </article>
                @endforeach
              </div>
              <a href="{{ route('register') }}" class="btn btn-expand btn-soft-primary !rounded-[50rem] mr-5 mb-5"><i class="uil uil-arrow-right before:content-['\e94c']"></i><span>Lelang Lainnya</span></a>
              <!-- /.blog -->
              <div class="blog itemgrid grid-view">
                <div class="flex flex-wrap mx-[-15px] isotope xl:mx-[-20px] lg:mx-[-20px] md:mx-[-20px] mt-[-40px] !mb-8">
                  <article class="item post xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[40px] px-[15px] max-w-full">
                    <div class="card">
                      <figure class="card-img-top overlay overlay-1 hover-scale group"><a href="#"> <img class="!transition-all !duration-[0.35s] !ease-in-out group-hover:scale-105" src="./assets/images/photos/b4.jpg" alt="image"></a>
                        <figcaption class="group-hover:opacity-100 absolute w-full h-full opacity-0 text-center px-4 py-3 inset-0 z-[5] pointer-events-none p-2">
                          <h5 class="from-top  !mb-0 absolute w-full translate-y-[-80%] p-[.75rem_1rem] left-0 top-2/4">Read More</h5>
                        </figcaption>
                      </figure>
                      <div class="card-body flex-[1_1_auto] p-[40px] xl:p-[1.75rem_1.75rem_1rem_1.75rem] lg:p-[1.75rem_1.75rem_1rem_1.75rem] md:p-[1.75rem_1.75rem_1rem_1.75rem] sm:pb-4 xsm:pb-4  ">
                        <div class="post-header !mb-[.9rem]">
                          <div class="inline-flex mb-[.4rem] uppercase tracking-[0.02rem] text-[0.7rem] font-bold text-[#aab0bc] relative align-top pl-[1.4rem] before:content-[''] before:absolute before:inline-block before:translate-y-[-60%] before:w-3 before:h-[0.05rem] before:left-0 before:top-2/4 before:bg-[#3f78e0]">
                            <a href="#" class="hover" rel="category">Coding</a>
                          </div>
                          <!-- /.post-category -->
                          <h2 class="post-title h3 !mt-1 !mb-3"><a class="text-[#343f52] hover:text-[#3f78e0]" href="./blog-post.html">Ligula tristique quis risus</a></h2>
                        </div>
                        <!-- /.post-header -->
                        <div class="!relative">
                          <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor. Aenean lacinia bibendum nulla sed.</p>
                        </div>
                        <!-- /.post-content -->
                      </div>
                      <!--/.card-body -->
                      <div class="card-footer xl:p-[1.25rem_1.75rem_1.25rem] lg:p-[1.25rem_1.75rem_1.25rem] md:p-[1.25rem_1.75rem_1.25rem] p-[18px_40px]">
                        <ul class="text-[0.7rem] text-[#aab0bc] m-0 p-0 list-none flex  !mb-0">
                          <li class="post-date inline-block"><i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i><span>14 Apr 2022</span></li>
                          <li class="post-comments inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]"><a class="text-[#aab0bc] hover:text-[#3f78e0] hover:border-[#3f78e0]" href="#"><i class="uil uil-comment pr-[0.2rem] align-[-.05rem] before:content-['\ea54']"></i>4</a></li>
                          <li class="post-likes !ml-auto inline-block"><a class="text-[#aab0bc] hover:text-[#3f78e0] hover:border-[#3f78e0]" href="#"><i class="uil uil-heart-alt pr-[0.2rem] align-[-.05rem] before:content-['\eb60']"></i>5</a></li>
                        </ul>
                        <!-- /.post-meta -->
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                  </article>
                  <!-- /.post -->
                  <article class="item post xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[40px] px-[15px] max-w-full">
                    <div class="card">
                      <figure class="card-img-top overlay overlay-1 hover-scale group"><a href="#"> <img class="!transition-all !duration-[0.35s] !ease-in-out group-hover:scale-105" src="./assets/images/photos/b5.jpg" alt="image"></a>
                        <figcaption class="group-hover:opacity-100 absolute w-full h-full opacity-0 text-center px-4 py-3 inset-0 z-[5] pointer-events-none p-2">
                          <h5 class="from-top  !mb-0 absolute w-full translate-y-[-80%] p-[.75rem_1rem] left-0 top-2/4">Read More</h5>
                        </figcaption>
                      </figure>
                      <div class="card-body flex-[1_1_auto] p-[40px] xl:p-[1.75rem_1.75rem_1rem_1.75rem] lg:p-[1.75rem_1.75rem_1rem_1.75rem] md:p-[1.75rem_1.75rem_1rem_1.75rem] sm:pb-4 xsm:pb-4  ">
                        <div class="post-header !mb-[.9rem]">
                          <div class="inline-flex mb-[.4rem] uppercase tracking-[0.02rem] text-[0.7rem] font-bold text-[#aab0bc] relative align-top pl-[1.4rem] before:content-[''] before:absolute before:inline-block before:translate-y-[-60%] before:w-3 before:h-[0.05rem] before:left-0 before:top-2/4 before:bg-[#3f78e0]">
                            <a href="#" class="hover" rel="category">Workspace</a>
                          </div>
                          <!-- /.post-category -->
                          <h2 class="post-title h3 !mt-1 !mb-3"><a class="text-[#343f52] hover:text-[#3f78e0]" href="./blog-post.html">Nullam id dolor elit id nibh</a></h2>
                        </div>
                        <!-- /.post-header -->
                        <div class="!relative">
                          <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor. Aenean lacinia bibendum nulla sed.</p>
                        </div>
                        <!-- /.post-content -->
                      </div>
                      <!--/.card-body -->
                      <div class="card-footer xl:p-[1.25rem_1.75rem_1.25rem] lg:p-[1.25rem_1.75rem_1.25rem] md:p-[1.25rem_1.75rem_1.25rem] p-[18px_40px]">
                        <ul class="text-[0.7rem] text-[#aab0bc] m-0 p-0 list-none flex  !mb-0">
                          <li class="post-date inline-block"><i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i><span>29 Mar 2022</span></li>
                          <li class="post-comments inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]"><a class="text-[#aab0bc] hover:text-[#3f78e0] hover:border-[#3f78e0]" href="#"><i class="uil uil-comment pr-[0.2rem] align-[-.05rem] before:content-['\ea54']"></i>3</a></li>
                          <li class="post-likes !ml-auto inline-block"><a class="text-[#aab0bc] hover:text-[#3f78e0] hover:border-[#3f78e0]" href="#"><i class="uil uil-heart-alt pr-[0.2rem] align-[-.05rem] before:content-['\eb60']"></i>3</a></li>
                        </ul>
                        <!-- /.post-meta -->
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                  </article>
                  <!-- /.post -->
                  <article class="item post xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[40px] px-[15px] max-w-full">
                    <div class="card">
                      <figure class="card-img-top overlay overlay-1 hover-scale group"><a href="#"> <img class="!transition-all !duration-[0.35s] !ease-in-out group-hover:scale-105" src="./assets/images/photos/b6.jpg" alt="image"></a>
                        <figcaption class="group-hover:opacity-100 absolute w-full h-full opacity-0 text-center px-4 py-3 inset-0 z-[5] pointer-events-none p-2">
                          <h5 class="from-top  !mb-0 absolute w-full translate-y-[-80%] p-[.75rem_1rem] left-0 top-2/4">Read More</h5>
                        </figcaption>
                      </figure>
                      <div class="card-body flex-[1_1_auto] p-[40px] xl:p-[1.75rem_1.75rem_1rem_1.75rem] lg:p-[1.75rem_1.75rem_1rem_1.75rem] md:p-[1.75rem_1.75rem_1rem_1.75rem] sm:pb-4 xsm:pb-4  ">
                        <div class="post-header !mb-[.9rem]">
                          <div class="inline-flex mb-[.4rem] uppercase tracking-[0.02rem] text-[0.7rem] font-bold text-[#aab0bc] relative align-top pl-[1.4rem] before:content-[''] before:absolute before:inline-block before:translate-y-[-60%] before:w-3 before:h-[0.05rem] before:left-0 before:top-2/4 before:bg-[#3f78e0]">
                            <a href="#" class="hover" rel="category">Meeting</a>
                          </div>
                          <!-- /.post-category -->
                          <h2 class="post-title h3 !mt-1 !mb-3"><a class="text-[#343f52] hover:text-[#3f78e0]" href="./blog-post.html">Ultricies fusce porta elit</a></h2>
                        </div>
                        <!-- /.post-header -->
                        <div class="!relative">
                          <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor. Aenean lacinia bibendum nulla sed.</p>
                        </div>
                        <!-- /.post-content -->
                      </div>
                      <!--/.card-body -->
                      <div class="card-footer xl:p-[1.25rem_1.75rem_1.25rem] lg:p-[1.25rem_1.75rem_1.25rem] md:p-[1.25rem_1.75rem_1.25rem] p-[18px_40px]">
                        <ul class="text-[0.7rem] text-[#aab0bc] m-0 p-0 list-none flex  !mb-0">
                          <li class="post-date inline-block"><i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i><span>26 Feb 2022</span></li>
                          <li class="post-comments inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]"><a class="text-[#aab0bc] hover:text-[#3f78e0] hover:border-[#3f78e0]" href="#"><i class="uil uil-comment pr-[0.2rem] align-[-.05rem] before:content-['\ea54']"></i>6</a></li>
                          <li class="post-likes !ml-auto inline-block"><a class="text-[#aab0bc] hover:text-[#3f78e0] hover:border-[#3f78e0]" href="#"><i class="uil uil-heart-alt pr-[0.2rem] align-[-.05rem] before:content-['\eb60']"></i>3</a></li>
                        </ul>
                        <!-- /.post-meta -->
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                  </article>
                  <!-- /.post -->
                  <article class="item post xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] xl:px-[20px] lg:px-[20px] md:px-[20px] mt-[40px] px-[15px] max-w-full">
                    <div class="card">
                      <figure class="card-img-top overlay overlay-1 hover-scale group"><a href="#"> <img class="!transition-all !duration-[0.35s] !ease-in-out group-hover:scale-105" src="./assets/images/photos/b7.jpg" alt="image"></a>
                        <figcaption class="group-hover:opacity-100 absolute w-full h-full opacity-0 text-center px-4 py-3 inset-0 z-[5] pointer-events-none p-2">
                          <h5 class="from-top  !mb-0 absolute w-full translate-y-[-80%] p-[.75rem_1rem] left-0 top-2/4">Read More</h5>
                        </figcaption>
                      </figure>
                      <div class="card-body flex-[1_1_auto] p-[40px] xl:p-[1.75rem_1.75rem_1rem_1.75rem] lg:p-[1.75rem_1.75rem_1rem_1.75rem] md:p-[1.75rem_1.75rem_1rem_1.75rem] sm:pb-4 xsm:pb-4  ">
                        <div class="post-header !mb-[.9rem]">
                          <div class="inline-flex mb-[.4rem] uppercase tracking-[0.02rem] text-[0.7rem] font-bold text-[#aab0bc] relative align-top pl-[1.4rem] before:content-[''] before:absolute before:inline-block before:translate-y-[-60%] before:w-3 before:h-[0.05rem] before:left-0 before:top-2/4 before:bg-[#3f78e0]">
                            <a href="#" class="hover" rel="category">Business Tips</a>
                          </div>
                          <!-- /.post-category -->
                          <h2 class="post-title h3 !mt-1 !mb-3"><a class="text-[#343f52] hover:text-[#3f78e0]" href="./blog-post.html">Morbi leo risus porta eget</a></h2>
                        </div>
                        <div class="!relative">
                          <p>Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor. Aenean lacinia bibendum nulla sed.</p>
                        </div>
                        <!-- /.post-content -->
                      </div>
                      <!--/.card-body -->
                      <div class="card-footer xl:p-[1.25rem_1.75rem_1.25rem] lg:p-[1.25rem_1.75rem_1.25rem] md:p-[1.25rem_1.75rem_1.25rem] p-[18px_40px]">
                        <ul class="text-[0.7rem] text-[#aab0bc] m-0 p-0 list-none flex  !mb-0">
                          <li class="post-date inline-block"><i class="uil uil-calendar-alt pr-[0.2rem] align-[-.05rem] before:content-['\e9ba']"></i><span>7 Jan 2022</span></li>
                          <li class="post-comments inline-block before:content-[''] before:inline-block before:w-[0.2rem] before:h-[0.2rem] before:opacity-50 before:m-[0_.6rem_0] before:rounded-[100%] before:align-[.15rem] before:bg-[#aab0bc]"><a class="text-[#aab0bc] hover:text-[#3f78e0] hover:border-[#3f78e0]" href="#"><i class="uil uil-comment pr-[0.2rem] align-[-.05rem] before:content-['\ea54']"></i>2</a></li>
                          <li class="post-likes !ml-auto inline-block"><a class="text-[#aab0bc] hover:text-[#3f78e0] hover:border-[#3f78e0]" href="#"><i class="uil uil-heart-alt pr-[0.2rem] align-[-.05rem] before:content-['\eb60']"></i>5</a></li>
                        </ul>
                        <!-- /.post-meta -->
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                  </article>
                  <!-- /.post -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.blog -->
              <nav class="flex" aria-label="pagination">
                <ul class="pagination">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                      <span aria-hidden="true"><i class="uil uil-arrow-left before:content-['\e949']"></i></span>
                    </a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                      <span aria-hidden="true"><i class="uil uil-arrow-right before:content-['\e94c']"></i></span>
                    </a>
                  </li>
                </ul>
                <!-- /.pagination -->
              </nav>
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
@endsection

@section('script')
@endsection