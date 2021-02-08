<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Board extends Model
{
    protected $fillable = [
        'name', 'slug','user_id'
    ];
    protected $appends=['qrcode','qrlink','printQrcode'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getQrcodeAttribute(){
        $user=User::find($this->user_id);
        $url=URL::to('/').'/menu/'.$user->slug.'/'.$this->slug;
        $png=base64_encode(QrCode::format('png')->size(512)->generate($url));

        return $png;
    }
    public function getPrintQrcodeAttribute(){
        $user=User::find($this->user_id);
        $url=URL::to('/').'/menu/'.$user->slug.'/'.$this->slug;
        return QrCode::size(250)->generate($url);

    }
    public function getQrlinkAttribute(){
        $user=User::find($this->user_id);
        $url=URL::to('/').'/menu/'.$user->slug.'/'.$this->slug;

        return $url;
    }
}
