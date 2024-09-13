<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Dusterio\LinkPreview\Client;
use Exception;
use Illuminate\Support\Facades\Auth;


class LinkPreview extends BaseModel
{
    use HasFactory;
    public static function getPreviewArray($url){
        if(config('qr.default_social_link_enabled')){
            $defaultUrls = config('qr.defaultUrls');
            foreach ($defaultUrls as $key => $defaultUrl) {
                if (strpos($url, $key) !== false) {
                    return [
                        'title' => $defaultUrl['title'],
                        'cover' => asset($defaultUrl['cover']),
                    ];
                    break;
                }
            }
        }
        $previewClient = new Client($url);
        $preview = $previewClient->getPreviews();
        return $preview['general']->toArray();
    }
    public static function getLinkDetail($request, $socialLink)
    {
        $url = $request->link;
        try {
            if(!getCurrentUser()->checkPermission('check-link-limit')){
                if(empty($socialLink)){
                    throw new \Exception("Social links reached it's limit.");
                }
            }
            if(empty($request->_link_id) && AthleteLink::where(['url' => $url, 'user_id' => Auth::user()->id])->count() > 0){
                throw new Exception(__('This url is already added. Please use different url.'));
            }
            $generalPreview = self::getPreviewArray($url);

            if(count($generalPreview) > 0){
                if(!empty($request->_link_id)){
                    if(empty($socialLink)){
                        throw new Exception(__('This link is not more exist. Please refresh and try again.'));
                    }
                    $link_template_id = $socialLink->link_template_id;
                    $socialLink->delete();
                    LinkTemplate::where('id', $link_template_id)->delete();
                }
                return $generalPreview;
            }
        } catch (\Exception $e) {
            if(!empty($e->getMessage())){
                throw new Exception($e->getMessage());
            }
            if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
                throw new Exception(__('Please enter valid url. It is not a valid url.'));
            }
            throw new Exception(__('Unable to fetch url details. Please check internet connection and try again'));
        }
        return [];
    }
}
