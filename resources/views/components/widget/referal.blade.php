@props(['username' => ''])
<div class="row">
    <div class="col-sm-12">
        <div class="card widget-hover overflow-hidden">
            <div class="card-body pt-0 count-student">
                <div class="school-wrapper">
                    <div class="school-header">
                        <x-form.text name='referal' value="{{ url('/') }}?r={{ $username }}">Link Referal</x-form.text>
                        <button class='btn btn-primary' onclick="copyRef()">Copy</button>
                        <div class="d-flex gap-1 align-items-center flex-wrap pt-xxl-0 pt-2">
                            <i class="fa-solid fa-share-alt text-xs"></i>
                            <i class="fa-brands fa-facebook-square"></i>
                            <i class="fa-brands fa-instagram"></i>
                            <i class="fa-brands fa-square-x-twitter"></i>
                            <i class="fa-brands fa-pinterest"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyRef(){
    var copytext = document.getElementById("referal");;
    copytext.select();
    navigator.clipboard.writeText(copytext.value);
    alert('Link Referal sudah dicopy ke clipboard');
}

</script>