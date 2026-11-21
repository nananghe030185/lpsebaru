<div class="container-fluid">
    <div class="form theme-form">
        <div class="row">
            <div class="col-lg-6">
                <x-form.text name='nomer' :readonly=true  :value="'INV-' . date('Ymd') . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT)">Nomor Invoice</x-form.text>

                 <x-form.select name="durasi" :options="[
                        App\Helpers\AppHelper::getDurasiPersonal() => 'Personal - ' .  round(App\Helpers\AppHelper::getDurasiPersonal() / 30) . '  Bulan',
                        App\Helpers\AppHelper::getDurasiPremium() => 'Premium - '. round(App\Helpers\AppHelper::getDurasiPremium() / 30) .' Bulan',
                        App\Helpers\AppHelper::getDurasiCorporate() => 'Corporate - '. round(App\Helpers\AppHelper::getDurasiCorporate() / 30) .' Bulan'
                    ]" :selected='App\Helpers\AppHelper::getDurasiPersonal()'>
                        Membership
                </x-form.select>

                <x-form.text name='total' :readonly=true  :value="App\Helpers\AppHelper::getHargaPersonal()">Harga</x-form.text>
                <x-form.text name='kupon'>Kupon</x-form.text>
                <x-form.text name='membership' value='Personal' type='hidden'></x-form.text>
            </div>
            <div class="col-lg-6">
                <div class="card mt-5" id="personal">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Personal</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Dashboard</strong> Member</li>
                                    <li class="list-group-item  list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Unlimited</strong> Kata Kunci</li>
                                    <li class="list-group-item  list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Email</strong> Notifikasi</li>
                                    <li class="list-group-item  list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Telegram</strong> Notifikasi</li>
                                    <li class="list-group-item  list-group-item-action list-hover-danger"><i class="icofont icofont-close-circled text-danger"></i> <strong>Whatsapp</strong> Notifikasi</li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Paket LPSE</strong></li>
                                    <li class="list-group-item list-group-item-action list-hover-danger"><i class="icofont icofont-close-circled text-danger"></i> <strong>Paket Lelang SIRUP</strong></li>
                                    <li class="list-group-item list-group-item-action list-hover-danger"><i class="icofont icofont-close-circled text-danger"></i> <strong>Paket Swakelola SIRUP</strong></li>
                                    <li class="list-group-item list-group-item-action list-hover-danger"><i class="icofont icofont-close-circled text-danger"></i> <strong>7/24 Support</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-5" id="premium" style="display: none">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Premium</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Dashboard</strong> Member</li>
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Unlimited</strong> Kata Kunci</li>
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Email</strong> Notifikasi</li>
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Telegram</strong> Notifikasi</li>
                                    <li class="list-group-item list-group-item-action list-hover-danger"><i class="icofont icofont-close-circled text-danger"></i> <strong>Whatsapp</strong> Notifikasi</li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Paket LPSE</strong></li>
                                    <li class="list-group-item list-group-item-action list-hover-danger"><i class="icofont icofont-close-circled text-danger"></i> <strong>Paket Lelang SIRUP</strong></li>
                                    <li class="list-group-item list-group-item-action list-hover-danger"><i class="icofont icofont-close-circled text-danger"></i> <strong>Paket Swakelola SIRUP</strong></li>
                                    <li class="list-group-item list-group-item-action list-hover-danger"><i class="icofont icofont-close-circled text-danger"></i> <strong>7/24 Support</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-5" id="corporate" style="display: none">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Corporate</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Dashboard</strong> Member</li>
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Unlimited</strong> Kata Kunci</li>
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Email</strong> Notifikasi</li>
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Telegram</strong> Notifikasi</li>
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Whatsapp</strong> Notifikasi</li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Paket LPSE</strong></li>
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Paket Lelang SIRUP</strong></li>
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>Paket Swakelola SIRUP</strong></li>
                                    <li class="list-group-item list-group-item-action list-hover-success"><i class="icofont icofont-check-circled text-success"></i> <strong>7/24 Support</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>