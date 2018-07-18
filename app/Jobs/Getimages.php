<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Hoteldata;
use Illuminate\Support\Facades\Log;

class Getimages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try
        {
            $url = 'https://www.google.co.in/search?biw=1366&bih=630&tbm=isch&sa=1&ei=S8NNW7jNLoq8vwSf7b-wDg&q=';
            $url .= urlencode($this->data['name']);
            $html = file_get_contents($url);
            preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i',$html, $matches );
            $image = $matches[1][0];
            $newimage = Hoteldata::find($this->data['id']);
            $newimage->image = $image;
            $newimage->save();
        }
        catch(\Exception $e)
        {
            Log::info($e);
        }
    }
}
