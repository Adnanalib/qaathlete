<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelQuartile;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Config;

function getQRImageURL()
{
    if (config('qr.isEnabled') == 'true') {
        return Auth::user()->qr_image_url;
    }
    return Auth::user()->qr_image_url ? url('storage/' . Auth::user()->qr_image_url) : "";
}
function getQRImageSrc($qrImageUrl)
{
    if (config('qr.isEnabled') == 'true') {
        return $qrImageUrl;
    }
    return asset('storage/' . $qrImageUrl);
}

function getQRImage($qrUrl, $uuid)
{
    if (config('qr.isEnabled') == 'true') {
        return generateQRImage($qrUrl, $uuid);
    }
    return getLocalQRImage($qrUrl, $uuid);
}
function createQRCode($uuid)
{
    try {
        $qrUrl = url('/profile-view') . '/' . $uuid;
        $user = User::where('uuid', $uuid)->latest()->first();
        if (!empty($user)) {
            $qr = getQRImage($qrUrl, $uuid);
            $user
                ->setNumberAttributeValue('qr_image_url', $qr['qr_image_url'])
                ->setAttributeValue('qr_id', $qr['qr_id'])
                ->setAttributeValue('qr_url', $qr['qr_url'])
                ->setAttributeValue('qr_data', $qr['qr_data'])
                ->save();
        }
    } catch (\Throwable $th) {
        Log::error("Error: " . json_encode($th->getMessage()));
    } catch (\Exception $th) {
        Log::error("Error: " . json_encode($th->getMessage()));
    }
}
function createTeamQRCode($uuid)
{
    $qrUrl = url('/team-profile-view') . '/' . $uuid;
    $qr = getQRImage($qrUrl, $uuid);
    return [
        'qr_image_url' => $qr['qr_image_url'],
        'qr_id' => $qr['qr_id'],
        'qr_url' => $qr['qr_url'],
        'qr_data' => $qr['qr_data'],
    ];
}


function getLocalQRImage($qrUrl, $uuid)
{
    $writer = new PngWriter();
    // Create QR code
    $qrCode = QrCode::create($qrUrl)
        ->setEncoding(new Encoding('ISO-8859-1'))
        ->setErrorCorrectionLevel(new ErrorCorrectionLevelQuartile())
        ->setSize(500)
        ->setMargin(0)
        ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
        ->setForegroundColor(new Color(78, 115, 211, 0.1))
        ->setBackgroundColor(new Color(255, 255, 255));

    // Create generic logo
    $logo = Logo::create(base_path() . '/public/assets/images/footer-logo.jpg')
        // create(base_path().'/public/assets/images/logo-for-qr.png')
        ->setResizeToWidth(150)
        ->setPunchoutBackground(true);

    $result = $writer->write($qrCode, $logo);
    $fileName = 'qr-codes/' . date("Y-m-d-His-") . Str::random(10) . '-' . $uuid . '.png';
    Storage::disk('public')->put($fileName, $result->getString());
    return [
        'qr_image_url' => $fileName ?? '',
        'qr_id' => null,
        'qr_url' => $qrUrl ?? '',
        'qr_data' => null,
        'qr_image_url' => $fileName,
    ];
}
function generateQRImage($qrUrl, $uuid)
{
    try {
        $url =  config('qr.url') . '/campaign/';
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'AccessToken' => 'key',
                'Authorization' => "Bearer " . config('qr.key'),
            ]
        ]);
        $result = $client->post($url, [
            'json' => [
                'qr' => [
                    "qrlogoXY" => "75,75",
                    'logo' => asset('assets/images/logo-for-qr.jpg'),
                    "backgroundColor" => "rgb(255, 255, 255)",
                    "color01" => "#000000",
                    "color02" => "#000000",
                    "eye_color" => "#000000",
                    "colorDark" => "#000000",
                    "eye_color01" => "#000000",
                    "eye_color02" => "#000000",
                    "eye_outer" => "eyeOuter2",
                    "eye_inner" => "eyeInner2",
                    "qrData" => "pattern1",
                    "transparentBkg" => false,
                    "qrCategory" => "url",
                    "text" => $qrUrl,
                    // "frame" => 3,
                    // "frameColor" => "rgb(255, 255, 255)",
                    // "frameText" => "SCAN ME",
                ],
                'qrUrl' => $qrUrl,
                "qrType" => "qr2",
                "qrCategory" => "url"
            ]
        ])->getBody()->getContents();
        $result = json_decode($result, true);
        return [
            'qr_image_url' => $result['imageUrl'] ?? '',
            'qr_id' => $result['qrId'] ?? '',
            'qr_url' => $qrUrl ?? '',
            'qr_data' => json_encode($result),
        ];
    } catch (\Throwable $th) {
        Log::error("Error: " . json_encode($th->getMessage()));
        throw $th;
    } catch (\Exception $th) {
        Log::error("Error: " . json_encode($th->getMessage()));
        throw $th;
    }
}

function getQrDetail($member)
{
    $qr_id = $member->qr_id;

    if (!empty($member->qr_detail_result) && config('qr.isCacheEnabled') == 'true') {
        return extractQRData($member->qr_detail_result);
    }
    try {
        $url =  config('qr.baseUrl') . '/data/' . $qr_id;
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'AccessToken' => 'key',
                'Authorization' => "Bearer " . config('qr.key'),
            ]
        ]);
        $result = $client->get($url, [
            "period" => env('qr.period', ''),
            "tz" => config('qr.timezone', ''), // timezone
        ])->getBody()->getContents();
        $result = json_decode($result, true);
        $member->qr_detail_result = json_encode($result);
        $member->save();
        return extractQRData($member->qr_detail_result);
    } catch (\Throwable $th) {
        Log::error("Error: " . json_encode($th->getMessage()));
        throw $th;
    } catch (\Exception $th) {
        Log::error("Error: " . json_encode($th->getMessage()));
        throw $th;
    }
}
function extractQRData($result)
{
    $result = json_decode($result, true);
    $data = [
        'graph' => [
            'labels' => $result['data']['graph']['label'] ?? [],
            'scans' => $result['data']['graph']['scans'] ?? [],
        ],
        'scans' => $result['data']['scans'] ?? 0,
        'data' => $result['data']['data'] ?? [],
    ];
    logDebug('getQrDetailResult' . json_encode($result));
    logDebug('returnDataOfExtractQRData' , $data);
    // dd($result);
    return $data;
}
