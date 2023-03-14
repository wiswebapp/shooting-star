<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\OpenCallResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\OpenCallFormFilledMail;
use App\Repositories\UploadFileRepository;

class OpenCallFormService {

    public function __construct(private UploadFileRepository $uploadFileRepository) {
        $this->uploadFileRepository = $uploadFileRepository;
    }

    public function store(array $response, object $artWorkImage)
    {
        $customItems = array_filter($response, function($key) {
            return strpos($key, 'custom_') === 0;
        }, ARRAY_FILTER_USE_KEY);

        foreach ($customItems as $key => $val) {
            if (is_object($val)) {
                $val = $this->uploadFileRepository->uploadFile('front_opencall', $val, $response['open_call_id'].'/'.Str::slug($response['name']));
            }
            $newData[] = [str_replace("custom_", "", $key) => $val];
        }

        if ($artWorkImage) {
            foreach ($artWorkImage as $file) {
                $artwork[] = $this->uploadFileRepository->uploadFile('front_opencall', $file, $response['open_call_id'].'/'.Str::slug($response['name']));
            }

            $response['art_work_title'] = json_encode($response['art_work_title']);
            $response['art_work_size'] = json_encode($response['art_work_size']);
            $response['art_work_medium'] = json_encode($response['art_work_medium']);
            $response['art_work_image'] = json_encode($artwork);
        }

        $response['other_field'] = json_encode($newData, TRUE);
        $opencallResponse = OpenCallResponse::create($response);

        Mail::to(config('mail.from.address'))->send(new OpenCallFormFilledMail('Admin', $response));
        Mail::to($response['email'])->send(new OpenCallFormFilledMail('User', $response));

        return $opencallResponse;
    }

}
