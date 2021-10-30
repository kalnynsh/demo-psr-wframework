<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        if (! $this->hasTable('posts')) {
            $table = $this->table('posts');

            $table
                ->addColumn('date', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
                ->addColumn('title', 'string', ['limit' => 64])
                ->addColumn('content', 'text', ['null' => true])
                ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
                ->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
                ->create();
        }

        if ($this->hasTable('posts')) {
            $table = $this->table('posts');

            $table
                ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
                ->addColumn('updated_at', 'datetime', ['null' => true])
                ->update();
        }
    }

    public function down()
    {
        $this
            ->table('posts')
            ->drop()
            ->save();
    }
}
