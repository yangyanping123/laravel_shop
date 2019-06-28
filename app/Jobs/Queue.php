<?php

namespace App\Jobs;

use App\Entities\Posts;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Queue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
       $this->data=$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $insert = [
                'title'=>$this->data->title,
                'author_id'=>$this->data->author_id,
                'content'=>$this->data->content,
                'description'=>$this->data->description,
            ];
            $result = Posts::create($insert);
            echo json_encode(['code' => 200, 'msg' => $result]);
        }catch (\Exception $exception) {
            echo json_encode(['code'=>0,'msg'=>$exception->getMessage()]);
        }
    }
}
