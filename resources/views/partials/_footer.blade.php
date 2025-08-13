  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12 justify-content-center">
            <div class="footer-menu text-center">
                <ul>
                    <li class="d-lg-flex d-block justify-content-center p-0">
                        <p>© @php date_default_timezone_set('Asia/Dhaka') @endphp {{ date('Y') }} <a href="#">Buy Now Pay Later - Rangs</a><p> <span class="px-1">|</span> Developed by <a target="_blank" href="https://www.codewareltd.com">Codeware LTD</a></p></p>
                        {{-- <p>Developed by <a target="_blank" href="www.codewareltd.com">Codeware LTD</a></p> --}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="overlayer">
        <div class="loader-overlay">
            <div class="">
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                {{-- <img id="pulse" src="{{ asset('assets/img/rangs-logo-1.png') }}" alt="rangs-logo"> --}}
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript for label effects only
    $(window).load(function() {
        $(".col-3 input").val("");

        $(".input-effect input").focusout(function() {
            if ($(this).val() != "") {
                $(this).addClass("has-content");
            } else {
                $(this).removeClass("has-content");
            }
        })
    });
</script>
