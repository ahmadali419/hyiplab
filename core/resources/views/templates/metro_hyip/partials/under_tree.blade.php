<ul @if($isFirst) class="firstList" @endif>
    @foreach($user->allReferrals as $under)
        @if($loop->first)
            @php $layer++ @endphp
        @endif
        <p><b>Level {{ $layer }}</b> (Total Members {{ $under->allReferrals->count() }})</p>
        <li class="{{ $layer }}
         {{ $under->allReferrals->count() }}">{{ $under->fullname }} ( {{ $under->username }} )
         <b>Investments:</b> {{ $under->total_invests }}
            @if(($under->allReferrals->count()) > 0 && ($layer < $maxLevel))
                @include($activeTemplate.'partials.under_tree',['user'=>$under,'layer'=>$layer,'isFirst'=>false
                
                ])
            @endif
        </li>
    @endforeach
</ul>
{{-- <div class="tab">
    @foreach($user->allReferrals as $under)
        @if($loop->first)
            @php $layer++ @endphp
            <button class="tablinks" onclick="openTab(event, 'level{{ $layer }}')">Level {{ $layer }} ({{ $user->allReferrals->count() }} members)</button>
        @endif
    @endforeach
</div>

@foreach($user->allReferrals as $under)
    @if($loop->first)
        @php $layer++ @endphp
        <div id="level{{ $layer }}" class="tabcontent">
    @endif
    <ul>
        <li>{{ $under->fullname }} ({{ $under->username }})</li>
        @if(($under->allReferrals->count()) > 0 && ($layer < $maxLevel))
            @include($activeTemplate.'partials.under_tree', ['user' => $under, 'layer' => $layer, 'isFirst' => false])
        @endif
    </ul>
    @if($loop->last)
        </div>
    @endif
@endforeach

<script>
    function openTab(evt, level) {
        console.log('level',level)
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(level).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script> --}}
