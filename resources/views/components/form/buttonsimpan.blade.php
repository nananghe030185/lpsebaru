@props(['id' => 'submit'])
<button type="submit" id="{{ $id }}" name="submit" class="btn btn-primary"><span class="icofont icofont-save pe-1"></span>{{ $slot == '' ? __('Simpan') : $slot }}</button>