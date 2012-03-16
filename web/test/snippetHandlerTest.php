<?php
require_once dirname(__FILE__) . '/simpletest/autorun.php';
require_once dirname(__FILE__) . '/../model/SnippetHandler.php';
require_once dirname(__FILE__) . '/../model/Snippet.php';

class SnippetHandlerTest extends unitTestcase
{

    private $_snippetHandler;
    private $_snippetId;

    function __construct()
    {
        $this->_snippetHandler = new SnippetHandler();
    }

    public function testIfGetSnippetByIDreturnCorrectObject()
    {
        $snippetA = $this->_snippetHandler->getNrOfSnippets(1);
        $snippetB = $this->_snippetHandler->getSnippetByID($snippetA[0]->getID());
        $this->assertEqual($snippetA[0]->getID(), $snippetB->getID());
    }

    public function testIfSnippetCaBeInsertedInDatabase() {
        $snippet = new Snippet(18, 'code', 'title', 'desc', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
        $this->_snippetId = $this->_snippetHandler->createSnippet($snippet);
        $this->assertTrue($this->_snippetId);
    }

    public function testIFSnippetCanBeDeleted() {
        $result = $this->_snippetHandler->deleteSnippet($this->_snippetId);
        $this->assertTrue($result);
    }

}
