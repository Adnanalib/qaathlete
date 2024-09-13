<!DOCTYPE html>
<html>

<head>
    <title>{{ config('app.name') }}{{ $team->name ? ' - ' . $team->name : '' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Main CSS -->
    <link type="text/css" href="{{ asset('assets/css/layout.css') }}" rel="stylesheet">
    <!-- Font CSS -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Barlow|InaiMathi|Nunito:wght@400;600;700&display=swap|Fugaz+One:regular|Work+Sans:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic&#038;subset=latin,latin-ext&#038;display=swap">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <style>
        #teamModalLabel {
            text-align: center;
        }

        .team-roaster .uuid-badge {
            width: 30px;
        }

        .team-roaster .uuid-badge>div {
            width: 1px;
            word-wrap: break-word;
            font-family: monospace;
            /* this is just for good looks */
            margin-left: 5px;
            white-space: pre;
            line-height: 13px;
            /* this is for displaying whitespaces */
            text-align: center;
            align-items: center;
            padding-top: 5px;
        }

        .col-md-4 {
            width: 33.33%;
            margin-top: 10px;
        }

        .team-roaster-container {
            display: flex !important;
        }

        .team-roaster .roaster-profile-img {
            width: 85px;
        }

        .team-roaster .roaster-number {
            width: 75px;
        }

        .team-roaster .roaster-text.title {
            padding-left: 10px;
        }

        .team-roaster .roaster-qr-img {
            margin-left: -10px;
            margin-top: 35px;
        }

        .team-roaster {
            height: 153px;
        }

        .team-roaster .uuid-badge,
        .team-roaster .roaster-profile-img {
            height: 143px;
        }

        .team-roaster .roaster-profile-img {
            margin-top: -140px
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-group form-focus mt-4">
            <h5 class="modal-title" id="teamModalLabel">{{ $team->name ?? '' }}</h5>
            <div class="row team-roaster-container">
                @foreach ($members as $key => $member)
                    @if (!empty($member->user))
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="team-roaster">
                                <div class="row">
                                    <div class="col-4 team-roaster-left">
                                        <div class="ml-1 uuid-badge">
                                            @php
                                                $characters = str_split($member->uuid);
                                                $uuid = implode(' ', $characters);
                                            @endphp
                                            <div>{{ $uuid }}</div>
                                        </div>
                                        <img class="roaster-profile-img"
                                            src="{{ getUserProfileImage($member->user) }}" />
                                    </div>
                                    <div class="col-8 z-up team-roaster-right">
                                        <div class="col-12">
                                            <p class="pb-0 roaster-text title">
                                                {{ str_limit($member->user->full_name, 50) }}
                                            </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 ml-3">
                                                <p class="pb-0 roaster-text">OKC, OK</p>
                                                <p class="pb-0 roaster-text">GPA:
                                                    {{ $member->user->ahtlete->gpa ?? '-' }}</p>
                                                <p class="pb-0 roaster-text">SS/UT</p>
                                                <p class="pb-0 roaster-number">#{{ $key }}</p>
                                            </div>
                                            <div class="col-4">
                                                <img class="roaster-qr-img"
                                                    src="{{ getQRImageSrc($member->qr_image_url) }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

</html>
