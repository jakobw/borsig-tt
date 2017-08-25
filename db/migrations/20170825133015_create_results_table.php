<?php

use Phinx\Migration\AbstractMigration;

class CreateResultsTable extends AbstractMigration
{
  /**
   * Change Method.
   *
   * Write your reversible migrations using this method.
   *
   * More information on writing migrations is available here:
   * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
   *
   * The following commands can be used in this method and Phinx will
   * automatically reverse them when rolling back:
   *
   *    createTable
   *    renameTable
   *    addColumn
   *    renameColumn
   *    addIndex
   *    addForeignKey
   *
   * Remember to call "create()" or "update()" and NOT "save()" when working
   * with the Table class.
   */
  public function change()
  {
		$table = $this->table('results');
		$table->addColumn('team_id', 'integer')
			->addColumn('match_nr', 'integer')
			->addColumn('opponent', 'string', ['limit' => 100])
			->addColumn('date', 'date')
			->addColumn('home', 'integer', ['limit' => 1])
			->addColumn('score_we', 'integer', ['limit' => 4])
			->addColumn('score_they', 'integer', ['limit' => 4])
			->create();
  }
}
