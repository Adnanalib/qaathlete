<div class="dashboard-profile-container">
    <div class="flex dashboard-title-container">
        <p class="title">Social Links</p>
    </div>
    <div class="p-0 m-0 mt-2 row pl-10px profile-view">
        <div class="pb-4 col-md-12 ml-f-0 pl-f-0">
            @foreach ($links as $link)
                @include('profile.link', [
                    'title' => $link->template->title,
                    'image' => !empty($link->template->icon) ? asset($link->template->icon) : asset('assets/images/links/default.png'),
                    'url' => $link->url
                ])
                {{-- <div class="px-6 py-3 mt-3 border-none link-card">
                    <div class="p-0 m-0 row">
                        <div class="col-md-1 img-container">
                            <img
                                src="{{ !empty($link->template->icon) ? asset($link->template->icon) : asset('assets/images/links/default.png') }}" />
                        </div>
                        <div class="col-md-9">
                            <p class="link-title">{{ $link->template->title }}</p>
                            <a class="link-url" href="{{ $link->url }}">{{ $link->url }}</a>
                        </div>
                    </div>
                </div> --}}
            @endforeach
            @if (count($links) == 0)
                <div>
                    <p class="text-center">No Link Found</p>
                </div>
            @endif
        </div>
    </div>
</div>
