<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Block;
use App\Models\BlockType;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlockType::insert([
            [
                'name'   => 'Heading',
                'slug'   => 'heading',
                'schema' => json_encode(['text' => 'string', 'level' => 'int']),
            ],
            [
                'name'   => 'Paragraph',
                'slug'   => 'paragraph',
                'schema' => json_encode(['text' => 'string']),
            ],
            [
                'name'   => 'Code',
                'slug'   => 'code',
                'schema' => json_encode(['code' => 'string', 'language' => 'string']),
            ],
            [
                'name'   => 'Image',
                'slug'   => 'image',
                'schema' => json_encode(['url' => 'string', 'alt' => 'string']),
            ],
        ]);

        $topics = [
            ['title' => 'HTML', 'slug' => 'html', 'description' => 'Learn the basics of HTML', 'order' => 1],
            ['title' => 'CSS', 'slug' => 'css', 'description' => 'Learn CSS styling', 'order' => 2],
            ['title' => 'JavaScript', 'slug' => 'javascript', 'description' => 'Learn JavaScript programming', 'order' => 3],
        ];

        foreach ($topics as $topic) {
            Topic::create($topic);
        }

        $html = Topic::where('slug', 'html')->first();
        $css = Topic::where('slug', 'css')->first();
        $js = Topic::where('slug', 'javascript')->first();

        SubTopic::insert([
            ['topic_id' => $html->id, 'title' => 'HTML Basics', 'slug' => 'basics', 'description' => 'Intro to HTML', 'order' => 1],
            ['topic_id' => $html->id, 'title' => 'HTML Forms', 'slug' => 'forms', 'description' => 'Working with forms', 'order' => 2],

            ['topic_id' => $css->id, 'title' => 'CSS Basics', 'slug' => 'basics', 'description' => 'Intro to CSS', 'order' => 1],
            ['topic_id' => $css->id, 'title' => 'CSS Flexbox', 'slug' => 'flexbox', 'description' => 'Layout with flexbox', 'order' => 2],

            ['topic_id' => $js->id, 'title' => 'JS Basics', 'slug' => 'basics', 'description' => 'Intro to JavaScript', 'order' => 1],
            ['topic_id' => $js->id, 'title' => 'JS DOM', 'slug' => 'dom', 'description' => 'Manipulating the DOM', 'order' => 2],
        ]);

        $htmlBasics = Subtopic::where('slug', 'basics')->whereHas('topic', fn($q) => $q->where('slug', 'html'))->first();
        $htmlForms  = Subtopic::where('slug', 'forms')->whereHas('topic', fn($q) => $q->where('slug', 'html'))->first();

        Article::insert([
            [
                'subtopic_id' => $htmlBasics->id,
                'title' => 'Introduction to HTML',
                'slug' => 'intro',
                'summary' => 'Learn what HTML is and how it works',
                'order' => 1
            ],
            [
                'subtopic_id' => $htmlForms->id,
                'title' => 'HTML Input Types',
                'slug' => 'input-types',
                'summary' => 'Different input types in HTML forms',
                'order' => 1
            ],
        ]);

        $heading = BlockType::where('slug', 'heading')->first();
        $paragraph = BlockType::where('slug', 'paragraph')->first();
        $code = BlockType::where('slug', 'code')->first();

        $intro = Article::where('slug', 'intro')->first();
        $inputs = Article::where('slug', 'input-types')->first();

        // HTML Intro article blocks
        Block::insert([
            [
                'article_id' => $intro->id,
                'block_type_id' => $heading->id,
                'content' => json_encode(['text' => 'What is HTML?', 'level' => 2]),
                'order' => 1
            ],
            [
                'article_id' => $intro->id,
                'block_type_id' => $paragraph->id,
                'content' => json_encode(['text' => 'HTML stands for HyperText Markup Language.']),
                'order' => 2
            ],
            [
                'article_id' => $intro->id,
                'block_type_id' => $code->id,
                'content' => json_encode([
                    'code' => "<!DOCTYPE html>\n<html>\n  <body>\n    <h1>Hello World</h1>\n  </body>\n</html>",
                    'language' => 'html'
                ]),
                'order' => 3
            ],
        ]);

        // HTML Input Types article blocks
        Block::insert([
            [
                'article_id' => $inputs->id,
                'block_type_id' => $heading->id,
                'content' => json_encode(['text' => 'HTML Input Types', 'level' => 2]),
                'order' => 1
            ],
            [
                'article_id' => $inputs->id,
                'block_type_id' => $paragraph->id,
                'content' => json_encode(['text' => 'There are different types of input elements.']),
                'order' => 2
            ],
            [
                'article_id' => $inputs->id,
                'block_type_id' => $code->id,
                'content' => json_encode([
                    'code' => '<input type="text">\n<input type="number">\n<input type="email">',
                    'language' => 'html'
                ]),
                'order' => 3
            ],
        ]);
    }
}
