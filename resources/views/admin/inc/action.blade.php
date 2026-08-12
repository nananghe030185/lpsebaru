<div class="action-div">
    @isset($data)
        @isset($edit)
            @if (isset($data->system_reserve) ? !$data->system_reserve : true)
                <a href="{{ route($edit, $data) }}" class="edit-icon" title="Edit Data">
                    <i data-feather="edit"></i>
                @else
                    <a href="javascript:void(0)" class="lock-icon" title="Data ini di proteksi sistem, tidak dapat di edit">
                        <i data-feather="lock"></i>
                    </a>
            @endif
        @endisset
        
        @isset($fokusLelang)
            @if($isfokusLelang)
                <i data-feather="star" class="text-warning"></i>
            @else
                <a href="{{ route($fokusLelang, $data) }}" class="star-icon" title="Fokus">
                    <i data-feather="star"></i>
                </a>
            @endif
        @endisset

        @isset($fokusTender)
            @if ($isFokusTender)
                <i data-feather="star" class="text-warning"></i>
            @else
                <a href="{{ route($fokusTender , $data) }}" class="star-icon" title="Fokus">
                    <i data-feather="star"></i>
                </a>
            @endif
            
        @endisset

        @isset($fokusKataKunci)
            <a href="{{ route($fokusKataKunci , $data) }}" class="star-icon" title="Fokus">
                <i data-feather="star"></i>
            </a>
        @endisset

        @isset($scan)
            <a href="{{ route($scan, $data) }}" class="star-icon">
                <i data-feather="eye"></i>
            </a>
        @endisset

        @isset($unfokus)
            <a href="{{ route($unfokus, $data) }}" class="star-icon" title="Unfokus">
                <i data-feather="trash-2"></i>
            </a>
        @endisset

        @isset($pay)
            <a href="{{ route($pay, $data) }}" class="star-icon" title="Checkout">
                <i data-feather="shopping-cart"></i>
            </a>
        @endisset
        @isset($resend)
            <a href="{{ route($resend, $data) }}" class="send" title="Resend">
                <i data-feather="send"></i>
            </a>
        @endisset
        @isset($loginwhatsapp)
            <a href="{{ $loginwhatsapp }}" class="edit-icon" title="Login WhatsApp">
                <i data-feather="log-in"></i>
            </a>
        @endisset
        @isset($logoutwhatsapp)
            @if ($data->status != 'connected')
                <a href="javascript:void(0)" class="lock-icon" title="Logout WhatsApp (Session not connected)">
                    <i data-feather="log-out" class="text-muted"></i>
                </a>
            @else
                <a href="{{ $logoutwhatsapp }}" class="edit-icon" title="Logout WhatsApp">
                    <i data-feather="log-out"></i>
                </a>
            @endif
            
        @endisset
        @isset($sendwhatsapp)
            @if ($data->status != 'connected')
                <a href="javascript:void(0)" class="lock-icon" title="Kirim Pesan WhatsApp (Session not connected)">
                    <i data-feather="send" class="text-muted"></i>
                </a>
            @else
                <a href="{{ $sendwhatsapp }}" class="edit-icon" title="Kirim Pesan WhatsApp">
                    <i data-feather="send"></i>
                </a>
            @endif
            
        @endisset

        @isset($delete)
            @if (isset($data->system_reserve) ? !$data->system_reserve : true)
                <a href="#confirm{{ $data->id }}" data-bs-toggle="modal" class="delete-svg" title="Delete">
                    <i data-feather="trash-2" class="remove-icon delete-confirmation text-danger" ></i>
                </a>
                <!-- Delete Confirmation -->
                <div class="modal fade" id="confirm{{ $data->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="confirmLabel{{ $data->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi</h5>
                                <button class="btn-close py-0" type="button" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4 class="mb-3"><b> Anda yakin ingin menghapus ?</b></h4>
                                <p>Data ini akan di Hapus permanen, anda tidak dapat mengembalikan data yang telah di hapus</p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route($delete, $data->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-primary" data-bs-dismiss="modal"
                                        type="button">{{ __('Tutup') }}</button>
                                    <button class="btn btn-danger delete spinner-btn"
                                        type="submit">{{ __('Hapus') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endisset
    @endisset
    @isset($toggle)
        <label class="switch">
            <input data-route="{{ route($route, $toggle->id) }}" data-id="{{ $toggle->id }}"
                class="form-check-input toggle-status" type="checkbox" name="{{ $name }}"
                value="{{ $value }}" {{ $value ? 'checked' : '' }}
                @if ($toggle->system_reserve) disabled @endif>
            <span class="switch-state"></span>
        </label>
    @endisset
</div>
