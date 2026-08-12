 <!-- latest jquery-->
 <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
 <!-- Bootstrap js-->
 <script src="{{ minify('/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
 <!-- feather icon js-->
 <script src="{{ minify('/js/icons/feather-icon/feather.min.js') }}"></script>
 <script src="{{ minify('/js/icons/feather-icon/feather-icon.js') }}"></script>
 <!-- scrollbar js-->
 <script src="{{ asset('assets/js/scrollbar/simplebar.min.js') }}"></script>
 <script src="{{ minify('/js/scrollbar/custom.js') }}"></script>
 <!-- Sidebar jquery-->
 <script src="{{ minify('/js/config.js') }}"></script>
 <!-- Plugins JS start-->
 <script src="{{ minify('/js/sidebar-menu.js') }}"></script>
 <script src="{{ minify('/js/sidebar-pin.js') }}"></script>
 <script src="{{ minify('/js/slick/slick.min.js') }}"></script>
 <script src="{{ minify('/js/slick/slick.js') }}"></script>
 <script src="{{ minify('/js/header-slick.js') }}"></script>
 @yield('scripts')
 <script src="{{ minify('/js/script.js') }}"></script>
 <script src="{{ minify('/js/script1.js') }}"></script>
 <script src="{{ minify('/js/theme-customizer/customizer.js') }}"></script>
 <script src="{{ minify('/js/toastr.min.js') }}"></script>

<!-- Status Update-->
 <script>
    $(document).ready(function() {
        $(document).on('change', '.toggle-status', function() {
            
            let status = $(this).prop('checked') ? 1 : 0;
            let url = $(this).data('route');
            let clickedToggle = $(this);
            $.ajax({
                type: "PUT",
                url: url,
                data: {
                    status: status,
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    clickedToggle.prop('checked', status);
                    toastr.success("Status berhasil diupdate",
                    "Berhasil",
                        {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut",
                        }
                    );
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });
</script>
