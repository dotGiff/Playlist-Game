<?php

namespace Database\Seeders;

use App\Models\Round;
use App\Models\Score;
use App\Models\Season;
use App\Models\Submission;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'is_admin' => true,
            'email' => 'admin@admin.com',
            'password' => bcrypt('test'),
        ]);
        User::factory(10)->create([
            'password' => bcrypt('test'),
        ]);
        $users = User::all();
        $seasons = Season::factory(2)->create([
            'user_id' => $users->first->id,
        ]);
        foreach ($seasons as $season) {
            foreach ($users as $user) {
                $season->participants()->attach($user);
            }
            $rounds = Round::factory(5)->create([
                'season_id' => $season->id,
            ]);
            foreach ($rounds as $round) {
                foreach($users as $user) {
                    Submission::factory()->create([
                        'round_id' => $round->id,
                        'user_id' => $user->id,
                    ]);
                }
            }
        }

        $round = Round::first();
        $i=0;
        foreach ($round->submissions as $submission) {
            $rank = min($i++, 4);
            foreach ($round->season->participants as $participant) {
                Score::factory()->create([
                    'user_id' => $participant->id,
                    'round_id' => $round->id,
                    'submission_id' => $submission->id,
                    'rank' => $rank,
                    'score' => Score::calculateScore($rank),
                ]);
            }
        }
    }
}
