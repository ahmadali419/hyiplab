@extends($activeTemplate . 'layouts.master')
@section('content')
    <script>
        "use strict"

        function createCountDown(elementId, sec) {
            var tms = sec;
            var x = setInterval(function() {
                var distance = tms * 1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes + "m " +
                    seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "COMPLETE";
                }
                tms--;
            }, 1000);
        }
    </script>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="text-end mb-4">
                <a href="{{ route('plan') }}" class="btn btn--outline-base btn-sm">
                    @lang('Investment Plan')
                </a>
            </div>
        </div>
        @include($activeTemplate . 'partials.invest_history', ['invests' => $invests])
        @if ($invests->hasPages())
            {{ $invests->links() }}
        @endif
    </div>
@endsection
