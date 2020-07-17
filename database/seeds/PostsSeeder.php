<?php

use App\Posts;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Posts::truncate();

		$posts = [
			[
				'user_id' => '1',
				'title' => 'Post title 1',
				'body' => 'This a short description about post 1 post',
			],
			[
				'user_id' => '1',
				'title' => 'Post title 2',
				'body' => 'This a short description about post 2 post',
			],
			[
				'user_id' => '1',
				'title' => 'Post title 3',
				'body' => 'This a short description about post 3 post',
			],
		];

		foreach ($posts as $post) {
			Posts::create($post);
		}
	}
}
