<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LinkTemplate extends BaseModel
{
    use HasFactory;

    public static function store($request, $socialLink){
        $linkPreview = LinkPreview::getLinkDetail($request, $socialLink);
        Log::debug('linkPreview' . json_encode($linkPreview));
        $self = new self();
        $self->icon = isset($linkPreview['cover']) ? $linkPreview['cover'] : '';
        $self->title = isset($linkPreview['title']) ? $linkPreview['title'] : '';
        $self->save();
        return $self->id;
    }
}
