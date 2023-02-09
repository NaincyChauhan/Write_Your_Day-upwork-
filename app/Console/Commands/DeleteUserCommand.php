<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DeleteUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users who have requested to delete their account 14 days ago';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('status', 'deleted')
            ->where('deleted_at', '<=', now()->subDays(14))
            ->get();

        foreach ($users as $user) {
            $user->delete();
        }
    }
}
