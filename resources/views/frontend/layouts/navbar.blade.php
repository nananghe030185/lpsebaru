<header>
    <nav class="navbar navbar-expand-lg center-nav transparent !absolute navbar-light caret-none">
        <div class="container xl:flex-row lg:flex-row !flex-nowrap items-center">
            <div class="navbar-brand w-full">
            <a href="{{ route('frontend.home') }}">
                <img src="{{ asset('assets/images/logo-dark.png') }}" srcset="{{ asset('assets/images/logo-dark@2x.png 2x')}}" alt="image">
            </a>
            </div>
            <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
            <div class="offcanvas-header xl:hidden lg:hidden flex items-center justify-between flex-row p-6">
                <h3 class="text-white xl:text-[1.5rem] !text-[calc(1.275rem_+_0.3vw)] !mb-0">LPSE Indonesia</h3>
                <button type="button" class="btn-close btn-close-white mr-[-0.75rem] m-0 p-0 leading-none text-[#605dba] transition-all duration-[0.2s] ease-in-out border-0 motion-reduce:transition-none before:text-[1.05rem] before:content-['\ed3b'] before:w-[1.8rem] before:h-[1.8rem] before:leading-[1.8rem] before:shadow-none before:transition-[background] before:duration-[0.2s] before:ease-in-out before:flex before:justify-center before:items-center before:m-0 before:p-0 before:rounded-[100%] hover:no-underline bg-inherit before:bg-[rgba(255,255,255,.08)] before:font-Unicons hover:before:bg-[rgba(0,0,0,.11)] focus:outline-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body xl:!ml-auto lg:!ml-auto flex  flex-col !h-full">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link font-bold !tracking-[normal] hover:!text-[#605dba] !text-[.85rem]" href="{{ route('frontend.home') }}" >Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle font-bold !tracking-[normal] hover:!text-[#605dba] !text-[.85rem]" href="#" data-bs-toggle="dropdown">Project terbaru</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a class="dropdown-item hover:!text-[#605dba]" href="{{ route('frontend.tender') }}">LPSE</a></li>
                            <li class="nav-item"><a class="dropdown-item hover:!text-[#605dba]" href="{{ route('frontend.lelang') }}">SIRUP</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-bold !tracking-[normal] hover:!text-[#605dba] !text-[.85rem]" href="{{ route('frontend.harga') }}" >Harga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-bold !tracking-[normal] hover:!text-[#605dba] !text-[.85rem]" href="{{ route('frontend.blog') }}" >Blog</a>
                    </li>
                </ul>
                <!-- /.navbar-nav -->
                <!-- /.offcanvas-footer -->
            </div>
            <!-- /.offcanvas-body -->
            </div>
            <!-- /.navbar-collapse -->
            <div class="navbar-other w-full !flex !ml-auto">
            <ul class="navbar-nav !flex-row !items-center !ml-auto">
                <li class="nav-item language-select uppercase group">
                    <a class="nav-link after:!text-[#605dba] xl:!text-[.85rem] lg:!text-[.85rem] md:!text-[1.05rem] sm:!text-[1.05rem] xsm:!text-[1.05rem] hover:!text-[#605dba]" href="{{ route('login') }}" role="button" aria-haspopup="true" aria-expanded="false">Login</a>
                </li>
                <li class="nav-item language-select uppercase group">
                    <a class="btn btn-green btn-sm text-white !bg-[#45c4a0] border-[#45c4a0] hover:text-white hover:bg-[#45c4a0] hover:border-[#45c4a0] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#45c4a0] active:border-[#45c4a0] disabled:text-white disabled:bg-[#45c4a0] disabled:border-[#45c4a0]  !rounded-[50rem] mb-2 !mr-[.25rem]" href="{{ route('register') }}" role="button" aria-haspopup="true" aria-expanded="false">Daftar</a>
                </li>
                <li class="nav-item xl:hidden lg:hidden">
                    <button class="hamburger offcanvas-nav-btn">
                        <span></span>
                    </button>
                </li>
            </ul>
            <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-other -->
        </div>
    <!-- /.container -->
    </nav>
    <!-- /.navbar -->

</header>