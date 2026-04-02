<form method="POST" action="{{ route('admin.user.update-profile', $user) }}" enctype="multipart/form-data" class="theme-form">
    @csrf
    @method('PUT')

        <div class="row custom-input">
            <div class="col-xxl-6 box-col-12">
                <div class="mb-3">
                    <label class="form-label" for="perusahaan">{{__('Perusahaan')}}</label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="icofont icofont-building" for="perusahaan"></i>
                        </div>
                        <input class="form-control" id="perusahaan" name="perusahaan" type="text" placeholder="Perusahaan" value="{{ isset($user->perusahaan) ? $user->perusahaan : old('perusahaan') }}">
                    </div>
                    @error('perusahaan')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-xxl-6 box-col-12">
                <div class="mb-3">
                    <label class="form-label" for="human-friendly">{{__('Masa Berlaku')}}</label>
                    <div class="input-group flatpicker-calender">
                        <div class="input-group-text">
                            <i class="icofont icofont-calendar" for="masa_berlaku"></i>
                        </div>
                        <input class="form-control" id="human-friendly" name="masa_berlaku" type="date" value="{{ isset($user->masa_berlaku) ? $user->masa_berlaku : old('masa_berlaku') }}" placeholder="Masa Berlaku">
                        @error('masa_berlaku')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 box-col-12">
                <div class="mb-3">
                    <label class="form-label" for="kbli">{{__('KBLI')}}</label>
                    <input class="form-control" id="kbli" name="kbli" type="text" placeholder="pisahkan dengan koma" value="{{ old('kbli', $user->kbli ?? '') }}">
                    @error('kbli')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-xxl-6 box-col-12">
                <div class="mb-3">
                    <label class="form-label" for="kata_kunci">{{__('Kata Kunci Paket')}}</label>
                    <input class="form-control" id="kata_kunci" name="kata_kunci" type="text" placeholder="pisahkan dengan koma" value="{{ old('kata_kunci', $user->kata_kunci ?? '') }}" required>
                    @error('kata_kunci')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-xxl-6 box-col-12">
                <div class="mb-3">
                    <label class="form-label">Whatsapp</label>
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <label class="form-check-label" for="whatsapp" style="padding-top: 5px;padding-left:5px;"><i class="flag-icon flag-icon-id"></i></label>
                        </div>
                        <input class="form-control" id="whatsapp" name="whatsapp" type="text" placeholder="Nomer Whatsapp" value="{{ old('whatsapp', $user->whatsapp ?? '') }}">
                        <div class="input-group-text">
                            <div class="form-check checkbox checkbox-solid-info">
                                <input class="form-check-input checkbox-shadow" id="notif_whatsapp_tender" type="checkbox" name="notif_whatsapp_tender" {{ $user->notif_whatsapp_tender ? 'checked' : '' }}>
                                <label class="form-check-label m-1" for="notif_whatsapp_tender" data-bs-toggle="tooltip" title="Notifikasi Whatsapp untuk Tender">
                                    <span>Tender</span>
                                </label>
                            </div>
                        </div>
                        <div class="input-group-text" >
                            <div class="form-check checkbox checkbox-solid-info">
                                <input class="form-check-input checkbox-shadow" id="notif_whatsapp_lelang" type="checkbox" name="notif_whatsapp_lelang" value="1" {{ $user->notif_whatsapp_lelang ? 'checked' : '' }}>
                                <label class="form-check-label m-1" for="notif_whatsapp_lelang" data-bs-toggle="tooltip" title="Notifikasi Whatsapp untuk Lelang">
                                    <span>Lelang</span>
                                </label>
                            </div>
                        </div>
                        @error('whatsapp')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 box-col-12">
                <div class="mb-3">
                    <label class="form-label">Telegram</label>
                    <div class="input-group mb-3">
                        <div class="input-group">
                        <!-- link to show modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modelTelegram">
                                <i class="icofont icofont-question-circle"></i>
                            </button>

                            <input class="form-control" id="telegram" name="telegram" type="text" placeholder="Nomer telegram" value="{{ old('telegram', $user->telegram ?? '') }}">
                            <div class="input-group-text">
                                <div class="form-check checkbox checkbox-solid-info">
                                    <input class="form-check-input checkbox-shadow" id="notif_telegram_tender" type="checkbox" name="notif_telegram_tender" {{ $user->notif_telegram_tender ? 'checked' : '' }}>
                                    <label class="form-check-label m-1" for="notif_telegram_tender" data-bs-toggle="tooltip" title="Notifikasi Telegram untuk Tender">
                                        <span>Tender</span>
                                    </label>
                                </div>
                            </div>
                            <div class="input-group-text" >
                                <div class="form-check checkbox checkbox-solid-info">
                                    <input class="form-check-input checkbox-shadow" id="notif_telegram_lelang" type="checkbox" name="notif_telegram_lelang" value="1" {{ $user->notif_telegram_lelang ? 'checked' : '' }}>
                                    <label class="form-check-label m-1" for="notif_telegram_lelang" data-bs-toggle="tooltip" title="Notifikasi Telegram untuk Lelang">
                                        <span>Lelang</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('telegram')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-xxl-12 box-col-12">
                <div class="mb-3">
                    <ul class="checkbox-wrapper">
                        <li> 
                            <input class="form-check-input checkbox-shadow" id="checkbox-icon" type="checkbox" name="notif_email_tender" value="1" {{ $user->notif_email_tender ? 'checked' : '' }}>
                            <label class="form-check-label" for="checkbox-icon">
                                <i class="icofont icofont-email"></i><span>Notifikasi Email Tender</span>
                            </label>
                        </li>
                        <li> 
                            <input class="form-check-input checkbox-shadow" id="checkbox-icon" type="checkbox" name="notif_email_lelang" value="1" {{ $user->notif_email_lelang ? 'checked' : '' }}>
                            <label class="form-check-label" for="checkbox-icon">
                                <i class="icofont icofont-email"></i><span>Notifikasi Email Lelang</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    <div class="text-start">
        <button class="btn btn-primary" type="submit">
            {{__('Update Profile')}}
        </button>
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">{{__('Kembali')}}</a>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="modelTelegram">
    <div class="modal-dialog modal-md  modal-dialog-centered">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Panduan Token Telegram</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <table>
                <tr>
                    <td>1. Buka Aplikasi Telegram</td>
                </tr>
                <tr>
                    <td>2. Cari Bot @lpseindonesia_bot</td>
                </tr>
                <tr>
                    <td>3. Klik /start untuk Mulai</td>
                </tr>
                <tr>
                    <td>4. Ketik /token lalu kirim</td>
                </tr>
                <tr>
                    <td>5. Salin Token yang diberikan Bot</td>
                </tr>
                <tr>
                    <td>6. Masukan Token pada kolom Telegram diatas</td>
                </tr>
                <tr>
                    <td>7. Selesai</td>
                </tr>
            </table>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>
<!-- Modal end -->


