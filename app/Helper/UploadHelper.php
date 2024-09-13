<?php

use Illuminate\Support\Str;
use App\Enums\UploadFileType;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

function getFileSystemName(){
    return 'public';
}

/**
 * @param $image
 * @param bool $is_base_64
 * @return string
 */
function uploadAvatar($image, $is_base_64 = false)
{
    return uploadFileContent($image, UploadFileType::Image, null, false, $is_base_64, null, 800, 800);
}

/**
 * @param $image
 * @param bool $is_base_64
 * @return string
 */
function uploadThumbnail($image, $is_base_64 = false)
{
    return uploadFileContent($image, UploadFileType::Image, null, true, $is_base_64, null, 1500, 1500);
}

/**
 * @param $image
 * @param int $width
 * @param int $height
 * @return \Intervention\Image\Image
 */
function resizeImage($image, $width = 500, $height = 500)
{
    return Image::make($image)->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });
}
/**
 * @param $file
 * @param int $type
 * @param null $name
 * @param bool $resize
 * @param bool $is_base_64
 * @param null $destination
 * @param int $width
 * @param int $height
 * @return string
 */
function uploadFileContent($file, $type = UploadFileType::Image, $name = null, $resize = false, $is_base_64 = false, $destination = null, $width = 500, $height = 500)
{
    if (empty($destination)) {
        $destination =  config('app.upload_directory');
    }
    if ($type === UploadFileType::Image) {
        if (empty($name)) {
            $name =  date("Y-m-d-His-") . Str::random(10) . '.png';
        }
        if (!$is_base_64) {
            $file = $file->getRealPath();
        }
        if ($resize) {
            $file = resizeImage($file, $width, $height);
        } else {
            $file = Image::make($file);
        }
        $file->save(storage_path('app/public/' . $destination) . $name);
    }
    if ($type === UploadFileType::File) {
        $name =  date("Y-m-d-His-") . Str::random(10) . '.' . $file->extension();
        Storage::disk(getFileSystemName())->put($name, file_get_contents($file->getRealPath()));
    } else {
        Storage::disk(getFileSystemName())->put($name, $file);
    }
    return Storage::url($name);
}

function uploadFile($file)
{
    $name = $file->getClientOriginalName();

    return uploadFile($file, UploadFileType::File, $name, false);
}

/**
 * @param $path
 * @param string $default
 * @return string
 */
function getImage($path, $default = '')
{
    return !empty($path) ? asset('images/' . $path) : asset($default);
}

/**
 * @param $pic
 * @param string $default
 * @return string
 */
function getPhoto($pic, $default = '')
{
    $path = asset($pic);
    return !empty($pic) ? $path : asset($default);
}
