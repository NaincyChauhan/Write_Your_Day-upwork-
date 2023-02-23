<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Popularpost as GetPopularpost;

class Popularpost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-popular-post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command Getting Popular Post';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $popularPosts = Post::where('created_at','>=', today()->subDays(5))->
                        selectRaw('posts.*, (SELECT COUNT(*) FROM views WHERE post_id = posts.id AND  post_type = posts.type) + (SELECT COUNT(*) FROM likeposts WHERE post_id = posts.id AND  post_type = posts.type) / 2 AS avg_engagement')
                        ->orderBy('avg_engagement','DESC')                        
                        ->take(10)
                        ->get();                
        
        foreach ($popularPosts as $key => $post) {
            $popular_post = new GetPopularpost();
            $popular_post->post_id = $post->id;
            $popular_post->save();
        }
        \Log::info("Popular Post Has Been Stored");
        return 0;
    }
}
