<?php

namespace Tests;

use Dyrynda\Database\Schema\Grammars\MySqlGrammar;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Mockery as m;

class DatabaseMySqlSchemaGrammarTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    public function testAddingUuid()
    {
        $blueprint = new Blueprint('users', function ($table) {
            $table->uuid('foo');
            $table->efficientUuid('bar');
        });

        $connection = m::mock(Connection::class);

        $this->assertEquals(
            ['alter table `users` add `foo` char(36) not null, add `bar` binary(16) not null'],
            $blueprint->toSql($connection, new MySqlGrammar)
        );
    }
}
