@if(!empty(\Helper::getSetting()))
    <div>
        @if(!empty(\Helper::getSetting()['software_logo_white']) && is_string(\Helper::getSetting()['software_logo_white']))
            <img src="{{ asset('storage/'. \Helper::getSetting()['software_logo_white']) }}" alt="" class="show-in-dark h-8">
        @endif

        @if(!empty(\Helper::getSetting()['software_logo_black']) && is_string(\Helper::getSetting()['software_logo_black']))
            <img src="{{ asset('storage/'. \Helper::getSetting()['software_logo_black']) }}" alt="" class="show-in-light h-8">
        @endif
    </div>
@endif
