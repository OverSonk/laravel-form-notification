<?php
namespace App\Traits;
use File;
use Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
trait Upload
{
    public function file($file, $driver)
    {
        $mime = $file->getClientOriginalExtension();
        $fileName = md5($file->__toString() . rand()) . '.' . $mime;
        $save = Storage::disk($driver)
            ->put($fileName,  file_get_contents($file));
        if (! $save) {
            throw new NotFoundHttpException;
        }
        $url = Storage::disk($driver)
            ->url($fileName);
        if($url){
            return [
                'url'=> $url,
                'name' => $file->getClientOriginalName()
            ];
        }else {
            throw new NotFoundHttpException;
        }
    }
}